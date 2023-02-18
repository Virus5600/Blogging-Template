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
	public $dateSort = "latest";
	public $pages = 10;

	// Validation
	protected $rules = [
		'search' => 'string|max:255',
		'dateSort' => ["regex:/(latest)|(oldest)/"],
		'pages' => 'numeric|min:10'
	];

	// Configurations
	protected $paginationTheme = 'bootstrap';

	// COMPONENT FUNCTION //
	public function render() {
		// Validation
		$validator = Validator::make([
				"search" => $this->search,
				"dateSort" => $this->dateSort,
				"pages" => $this->pages
			],
			$this->rules
		);
		$cleaned = $validator->validate();

		if ($validator->fails()) {
			Log::debug($validator->messages());
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "Invalid search input"
			]);

			return;
		}
		$this->resetPage('blogsPage');

		$search = "%{$cleaned['search']}%";
		$searchQuery = function($query) use ($search) {
			return $query->where("title", "LIKE", $search)
				->orWhere("summary", "LIKE", $search);
		};

		$blogs = Blog::select(['title', 'summary', 'author', 'slug', 'poster', 'created_at'])
			->where('is_draft', '=', 0)
			->where($searchQuery)
			->{$cleaned['dateSort'] ?: 'latest'}()
			->paginate((int) $cleaned['pages'] ?: 10, ["*"], 'blogsPage');

		return view('livewire.blogs.index', [
			'blogs' => $blogs
		])
			->extends('layouts.user')
			->section('content');
	}
}