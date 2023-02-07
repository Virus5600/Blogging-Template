<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'title',
		'summary',
		'poster',
		'slug',
		'content',
		'is_draft',
		'author'
	];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'deleted_at' => 'datetime',
	];

	// Relationship Function
	protected function user() { return $this->belongsTo('App\User', 'author', 'user_id'); }
	protected function blogContentImages() { return $this->hasMany('App\Models\AnnouncementContentImage', 'blog_id', 'id'); }

	// Custom Functions
	public function getPoster() {
		return asset('uploads/blogs/'.$this->slug.'/'.$this->poster);
	}
}