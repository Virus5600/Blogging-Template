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

class Create extends Component
{
	use WithFileUploads;

	// Fields (models)
	public $title, $summary, $poster, $content, $is_draft;

	// Validation
	protected $rules = [
		'title' => 'required|string|max:150',
		'summary' => 'string|max:255',
		'poster' => 'image|max:10240',
		'content' => 'required|string|max:16777215',
		'is_draft' => 'boolean'
	];

	protected $messages = [
		'title.required' => 'Title is required',
		'title.string' => 'Invalid instorePublicly',
		'title.max' => 'Exceeded character count',
		'summary.string' => 'Invalid instorePublicly',
		'summary.max' => 'Exceeded character count',
		'poster.image' => 'Poster should be an image file (jpg, jpeg, png, bmp, gif, svg, or webp)',
		'poster.max' => 'Maximum file size is 10MB',
		'content.required' => 'Content is required',
		'content.string' => 'Invalid instorePublicly',
		'content.max' => 'Exceeded character count',
		'is_draft.boolean' => 'Invalid instorePublicly'
	];

	// COMPONENT FUNCTION //
	public function render() {
		return view('livewire.admin.blogs.create')
			->extends('layouts.admin')
			->section('content');
	}

	// FORM FUNCTIONS //
	public function create(Request $req) {
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

		try {
			DB::beginTransaction();

			$slug = Str::slug($this->title) . "-" . time();

			// Blog content is to follow and thus, a placeholder will be used.
			$blog = Blog::create([
				'title' => $this->title,
				'summary' => $this->summary,
				'slug' => $slug,
				'content' => "<p><div class='spinner-border mr-2' role='status'></div>Processing...</p>",
				'is_draft' => $this->is_draft ? true : false,
				'author' => auth()->user()->id
			]);

			// File handling
			if ($this->poster) {
				$destination = "uploads/blogs/{$slug}";
				$fileType = $this->poster->getClientOriginalExtension();
				$image = "{$slug}-" . uniqid() . ".{$fileType}";
				$this->poster->storePubliclyAs($destination, $image, 's3');
				
				$blog->poster = $image;
			}

			// Base64 handling (Summernote)
			$dom = new DOMDocument();
			$dom->encoding = 'utf-8';
			$dom->loadHtml(mb_convert_encoding($this->content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
			$images = $dom->getElementsByTagName('img');
			foreach($images as $i) {
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
			}

			$blog->content = $dom->saveHTML();
			$blog->save();

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

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