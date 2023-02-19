<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Str;

use Storage;

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

	protected $with = [
		'user',
		'blogContentImages'
	];

	// Relationship Function
	public function user() { return $this->belongsTo('App\Models\User', 'author'); }
	public function blogContentImages() { return $this->hasMany('App\Models\BlogContentImage', 'blog_id', 'id'); }

	// Custom Functions
	public function getPoster() {
		return Storage::disk('s3')->url('uploads/blogs/'.$this->slug.'/'.$this->poster);
	}

	public function getLifetime() {
		$now = now();
		$createdAt = $this->created_at;

		$seconds = $now->diffInSeconds($createdAt);	if ($seconds < 60) return "{$seconds} " . Str::plural("sec", $seconds);
		$minutes = $now->diffInMinutes($createdAt);	if ($minutes < 60) return "{$minutes} " . Str::plural("min", $minutes);
		$hours = $now->diffInHours($createdAt);		if ($hours < 24) return "{$hours} " . Str::plural("hour", $hours);
		$days = $now->diffInDays($createdAt);		if ($days < 7) return "{$days} " . Str::plural("day", $days);
		$weeks = $now->diffInWeeks($createdAt);		if ($weeks < 4) return "{$weeks} " . Str::plural("week", $weeks);
		$months = $now->diffInMonths($createdAt);	if ($months < 12) return "{$months} " . Str::plural("month", $months);
		$years = $now->diffInYears($createdAt);		return "{$years} " . Str::plural("year", $years);
	}
}