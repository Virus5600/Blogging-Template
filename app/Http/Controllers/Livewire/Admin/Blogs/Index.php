<?php

namespace App\Http\Controllers\Livewire\Admin\Blogs;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Blog;

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
		$search = "%{$this->search}%";
		$blogs = Blog::withTrashed()
			->where("title", "LIKE", $search)
			->orWhere("summary", "LIKE", $search)
			->paginate(10, ["*"], 'blogs');

		return view('livewire.admin.blogs.index', [
			'blogs' => $blogs
		])
			->extends('layouts.admin')
			->section('content');
	}

	// FORM FUNCTIONS //
	public function search() {
		$validator = Validator::make(["search" => $this->search], $this->rules);

		if ($validator->fails()) {
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "Invalid search input"
			]);

			return;
		}

		$this->resetPage('blogs');
	}
}
