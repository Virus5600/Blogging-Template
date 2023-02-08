<?php

namespace App\Http\Controllers\Livewire\Admin\Blogs;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Blog;

use DB;
use Exception;
use Log;
use Validator;

class Index extends Component
{
	use WithPagination;

	// Fields (models)
	public $search = "";

	// Validation
	protected $rules = ['search' => 'string|max:255'];

	// Configurations
	protected $paginationTheme = 'bootstrap';

	// COMPONENT FUNCTION //
	public function render() {
		$validator = Validator::make(["search" => $this->search], $this->rules);

		if ($validator->fails()) {
			Log::debug($validator->messages());
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "Invalid search input"
			]);

			return;
		}
		$this->resetPage('blogsPage');

		$search = "%{$this->search}%";
		$blogs = Blog::withTrashed()
			->where("title", "LIKE", $search)
			->orWhere("summary", "LIKE", $search)
			->paginate(10, ["*"], 'blogsPage');

		return view('livewire.admin.blogs.index', [
			'blogs' => $blogs
		])
			->extends('layouts.admin')
			->section('content');
	}

	// CLICK FUNCTIONS //
	public function publish($id) {
		$blog = Blog::withTrashed()
			->find($id);

		if ($blog == null) {
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "The blog either does not exists or is already deleted"
			]);

			return;
		}

		try {
			DB::beginTransaction();

			$blog->is_draft = 0;
			$blog->restore();
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

		$this->dispatchBrowserEvent('flash_success', [
			'flash_success' => "Successfully published \"{$blog->title}\""
		]);
	}

	public function draft($id) {
		$blog = Blog::withTrashed()
			->find($id);

		if ($blog == null) {
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "The blog either does not exists or is already deleted"
			]);

			return;
		}

		try {
			DB::beginTransaction();

			$blog->is_draft = 1;
			$blog->restore();
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

		$this->dispatchBrowserEvent('flash_success', [
			'flash_success' => "Successfully drafted \"{$blog->title}\""
		]);
	}
}