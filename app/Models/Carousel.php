<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'uploaded_by',
		'description',
		'image',
		'is_active',
		'deleted_by',
	];

	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at',
	];

	protected $casts = [
		'created_at' => 'date: M d, y',
		'updated_at' => 'date: M d, y',
		'deleted_at' => 'date: M d, y',
	];

	// Relationships
	protected function uploadedBy() { return $this->belongsTo('App\Models\User', 'uploaded_by'); }
	
	public function deletedBy() {
		return User::withTrashed()
			->where('id', $this->deleted_by)
			->get();
	}
}