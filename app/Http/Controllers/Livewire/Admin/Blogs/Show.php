<?php

namespace App\Http\Controllers\Livewire\Admin\Blogs;

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
		$blog = Blog::where('slug', '=', $this->slug)
			->first();

		if ($blog == null) {
			session()->flash('has_icon', true);
			session()->flash('flash_info', "Blog either does not exists or is already deleted");

			$this->redirectRoute('blogs.admin.index');
		}

		return view('livewire.admin.blogs.show', [
			'blog' => $blog,
		])
			->extends('layouts.admin')
			->section('content');
	}
}