<?php

namespace App\Http\Controllers\Livewire\Blogs\Components;

use Livewire\Component;

use App\Models\Blog;

class PartialTable extends Component
{
	// Protected variables (internal)
	protected $blogs;

	// COMPONENT FUNCTION //
	public function render() {
		$this->blogs = Blog::select(['title', 'summary', 'slug', 'poster'])
			->where('is_draft', '=', 0)
			->latest()
			->take(3)
			->get();

		return view('livewire.blogs.components.partial-table', [
			'blogs' => $this->blogs
		]);
	}
}