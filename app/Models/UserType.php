<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'name',
		'authority_level'
	];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'deleted_at' => 'datetime',
	];

	protected $with = [
		'permissions'
	];

	// Relationships
	public function users() { return $this->hasMany('App\Models\User'); }
	public function permissions() { return $this->belongsToMany('App\Models\Permission', 'user_type_permissions'); }

	// Custom Functions
	public function hasPermission(...$permissions) {
		$matches = 0;

		foreach ($permissions as $t) {
			foreach ($this->permissions as $h) {
				if ($t == $h->slug) {
					$matches += 1;
				}
			}
		}

		return $matches == count($permissions);
	}
}