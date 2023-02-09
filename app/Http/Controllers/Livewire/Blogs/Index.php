<?php

namespace App\Http\Controllers\Livewire\Blogs;

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
		$searchQuery = function($query) use ($search) {
			return $query->where("title", "LIKE", $search)
				->orWhere("summary", "LIKE", $search);
		};

		$blogs = Blog::select(['title', 'summary', 'author', 'slug', 'poster', 'created_at'])
			->where('is_draft', '=', 0)
			->where($searchQuery)
			->paginate(10, ["*"], 'blogsPage');

		return view('livewire.blogs.index', [
			'blogs' => $blogs
		])
			->extends('layouts.user')
			->section('content');
	}
}