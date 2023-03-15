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
		$toRet = Storage::disk('s3')->url('uploads/blogs/'.$this->blog->slug.'/content/'.$this->image_name);
		
		if(config('app.env') === 'production' || config('app.env') === 'staging')
				$toRet = preg_replace("/(http(?!s))(.+)/", "$1s$2", $toRet);
		
		return $toRet;
	}
}