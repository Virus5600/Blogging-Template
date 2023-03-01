<?php

namespace App\Http\Controllers\Livewire\Admin\Blogs;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Blog;
use App\Models\BlogContentImage;

use DB;
use DOMDocument;
use Exception;
use Log;
use Storage;
use Validator;

class Edit extends Component
{
	use WithFileUploads;

	// Fields (models)
	public $title, $summary, $poster, $content, $is_draft, $slug, $blog;

	// Validation
	protected $rules = [
		'title' => 'required|string|max:150',
		'summary' => 'string|max:255',
		'poster' => 'nullable|image|max:10240',
		'content' => 'required|string|max:16777215',
		'is_draft' => 'boolean'
	];

	protected $messages = [
		'title.required' => 'Title is required',
		'title.string' => 'Invalid input',
		'title.max' => 'Exceeded character count',
		'summary.string' => 'Invalid input',
		'summary.max' => 'Exceeded character count',
		'poster.image' => 'Poster should be an image file (jpg, jpeg, png, bmp, gif, svg, or webp)',
		'poster.max' => 'Maximum file size is 10MB',
		'content.required' => 'Content is required',
		'content.string' => 'Invalid input',
		'content.max' => 'Exceeded character count',
		'is_draft.boolean' => 'Invalid input'
	];

	// COMPONENT FUNCTION //
	public function mount($slug) {
		$this->slug = $slug;

		$this->blog = Blog::withTrashed()
			->where('slug', '=', $this->slug)
			->first();

		if ($this->blog == null) {
			return redirect()
				->route('admin.blogs.index')
				->with('flash_error', "The blog either does not exists or is already deleted");
		}

		$this->title = $this->blog->title;
		$this->summary = $this->blog->summary;
		$this->content = $this->blog->content;
		$this->is_draft = $this->blog->is_draft;
	}

	public function render() {
		return view('livewire.admin.blogs.edit', [
			'blog' => $this->blog
		])
			->extends('layouts.admin')
			->section('content');
	}

	// FORM FUNCTIONS //
	public function update(Request $req) {
		$blog = Blog::withTrashed()
			->where('slug', '=', $this->slug)
			->first();

		if ($blog == null) {
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "The blog either does not exists or is already deleted"
			]);

			return;
		}

		$validator = Validator::make([
			"title" => $this->title,
			"summary" => $this->summary,
			"poster" => $this->poster,
			"content" => $this->content,
			"is_draft" => $this->is_draft ? true : false
		], $this->rules, $this->messages);

		if ($validator->fails()) {
			$validator->validate();
			return;
		}

		$moveAllFiles = false;
		try {
			DB::beginTransaction();

			$slug = Str::slug($this->title) . "-" . time();
			$blog = $this->blog;

			// Renaming the dedicated folder and its poster
			if (substr($blog->slug, 0, strrpos($blog->slug, "-")) != substr($slug, 0, strrpos($slug, "-"))) {
				$moveAllFiles = true;

				$oldPosterName = $blog->poster;
				$newPosterName = str_replace($blog->slug, $slug, $blog->poster);

				Storage::disk('s3')->move("uploads/blogs/{$blog->slug}/", "uploads/blogs/{$slug}/");
				Storage::disk('s3')->move("uploads/blogs/{$slug}/{$blog->poster}", "uploads/blogs/{$slug}/{$newPosterName}/");
			}
			else {
				$slug = $blog->slug;
			}

			// Blog content is to follow and thus, the old content will be used.
			$blog->title = $this->title;
			$blog->summary = $this->summary;
			$blog->content = $this->content;
			$blog->is_draft = $this->is_draft ? true : false;

			// File handling
			if ($this->poster) {
				$destination = "uploads/blogs/{$slug}";
				$fileType = $this->poster->getClientOriginalExtension();
				$image = "{$slug}-" . uniqid() . ".{$fileType}";
				$this->poster->storePubliclyAs($destination, $image, 's3');
				
				Storage::disk("s3")->delete("uploads/blogs/{$slug}/". ($moveAllFiles ? $newPosterName : $blog->poster));
				$blog->poster = $image;
			}

			// Preparation for removal of removed images on announcement...
			$keptImages = array();

			// Base64 handling (Summernote)
			$dom = new DOMDocument();
			$dom->encoding = 'utf-8';
			$dom->loadHtml(mb_convert_encoding($this->content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

			$images = $dom->getElementsByTagName('img');
			foreach($images as $i) {
				$blogImage = BlogContentImage::where('image_name', '=', $i->getAttribute('data-filename'))->first();

				if ($blogImage == null) {
					if (!preg_match('(^data:image)', $i->getAttribute('src')))
						continue;
				
					$extension = explode('/', explode(':', substr($i->getAttribute('src'), 0, strpos($i->getAttribute('src'), ';')))[1])[1];
					$replace = substr($i->getAttribute('src'), 0, strpos($i->getAttribute('src'), ',')+1);
					$image = str_replace($replace, '', $i->getAttribute('src'));
					$image_name = $slug . '-content_image-' . uniqid() . '.' . $extension;

					Storage::disk('s3')->put("uploads/blogs/{$slug}/content/{$image_name}", base64_decode($image), 'public');
					
					$ci = BlogContentImage::create([
						'blog_id' => $blog->id,
						'image_name' => $image_name
					]);
					
					$i->removeAttribute('src');
					$i->setAttribute('src', $ci->getImage());
					$i->setAttribute('data-filename', $ci->image_name);
					$i->setAttribute('data-fallback-image', asset('/storage/uploads/blogs/default.png'));
					array_push($keptImages, $image_name);
				}
				else {
					$image_name = $i->getAttribute('data-filename');

					// Updates the existing content images' URL to match the new shit
					if ($moveAllFiles) {
						$replacement = str_replace($blog->slug, $slug, $i->getAttribute('src'));
						$replacementName = str_replace($blog->slug, $slug, $image_name);

						// For the table update
						$ci = $blog->blogContentImages()
							->where('image_name', '=', $image_name)
							->first();
						$ci->image_name = $replacementName;
						$ci->save();

						// For the file update
						Storage::disk('s3')->move("uploads/blogs/{$blog->slug}content/{$image_name}", "uploads/blogs/{$slug}/content/{$replacementName}");

						// For the Summernote content update
						$i->removeAttribute('src');
						$i->removeAttribute('data-filename');
						$i->setAttribute('src', $replacement);
						$i->setAttribute('data-filename', $replacementName);
					}

					array_push($keptImages, $image_name);
				}
			}

			foreach ($blog->blogContentImages as $ci) {
				if (!in_array($ci->image_name, $keptImages)) {
					$image_name = $ci->image_name;
					$ci->delete();

					Storage::disk("s3")->delete("uploads/blogs/{$slug}/content/{$image_name}");
				}
			}

			$blog->slug = $slug;
			$blog->content = $dom->saveHTML();
			$blog->save();

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			// If some shit happens during the process, revert the folder's name back to its old one... along with the poster.
			if ($moveAllFiles) {
				Storage::disk('public')->move("uploads/blogs/{$slug}/", "uploads/blogs/{$blog->slug}/");
				Storage::disk('public')->move("uploads/blogs/{$blog->slug}/{$newPosterName}", "uploads/blogs/{$blog->slug}/{$oldPosterName}/");
			}

			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "Something went wrong, please try again later"
			]);
			return;
		}

		return redirect()
			->route('admin.blogs.index')
			->with('flash_success', "Successfully uploaded blog");
	}
}