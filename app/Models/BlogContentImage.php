<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Storage;

class BlogContentImage extends Model
{
	use HasFactory;

	protected $fillable = [
		'blog_id',
		'image_name'
	];

	// Relationship Function
	protected function blog() { return $this->belongsTo('App\Models\Blog'); }

	// Custom Function
	public function getImage() {
		return Storage::disk('s3')->url('uploads/blogs/'.$this->blog->slug.'/content/'.$this->image_name);
	}
}