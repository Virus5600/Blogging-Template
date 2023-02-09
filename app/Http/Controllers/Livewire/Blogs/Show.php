<?php

namespace App\Http\Controllers\Livewire\Blogs;

use Livewire\Component;

use App\Models\Blog;

class Show extends Component
{
	// PUBLIC PARAMETERS //
	public $slug;

	// COMPONENT FUNCTION //
	public function mount($slug) {
		$this->slug = $slug;
	}

	public function render() {
		$blog = Blog::select(['title', 'poster', 'slug', 'content', 'author', 'created_at', 'updated_at'])
			->where('slug', '=', $this->slug)
			->first();

		if ($blog == null) {
			session()->flash('has_icon', true);
			session()->flash('flash_info', "<h3>What's that?</h3>");
			session()->flash('message', "<p class='text-center'>We're unable to find the blog you're looking for!<br>Maybe you can look it up here?</p>");
			session()->flash('has_timer', true);
			session()->flash('duration', 10000);

			$this->redirectRoute('blogs.index');
		}

		$otherBlogs = Blog::select(['title', 'summary', 'slug', 'poster', 'created_at'])
			->where('is_draft', '=', 0)
			->where('slug', '!=', $this->slug)
			->latest()
			->take(3)
			->get();

		return view('livewire.blogs.show', [
			'blog' => $blog,
			'otherBlogs' => $otherBlogs
		])
			->extends('layouts.user')
			->section('content');
	}
}