<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Permission;
use App\Models\UserType;

class UserTypePermissionsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// VAR SETTING
		$blogPerm = Permission::select(['id'])->where('slug', '=', 'blogs_tab_access')->first();
		$userPerm = Permission::select(['id'])->where('slug', '=', 'users_tab_access')->first();
		$typePerm = Permission::select(['id'])->where('slug', '=', 'user_types_tab_access')->first();
		$permPerm = Permission::select(['id'])->where('slug', '=', 'permissions_tab_access')->first();

		// Owner
		UserType::where('name', '=', 'Owner')
			->first()
			->permissions()
			->sync(Permission::select(['id'])
					->pluck('id')
					->toArray()
				);

		// Admin
		UserType::where('name', '=', 'Admin')
			->first()
			->permissions()
			->sync(Permission::select(['id'])
					->where('slug', '<>', 'change_owner')
					->pluck('id')
					->toArray()
				);

		// Moderator
		UserType::where('name', '=', 'Moderator')
			->first()
			->permissions()
			->sync(Permission::select(['id'])
					->where('slug', '<>', 'change_owner')
					->where(function($query) {
						$query->where('slug', 'NOT LIKE', 'blogs%perma_delete')
							->where('slug', 'NOT LIKE', 'users%perma_delete');
					})
					->where(function($query) {
						$query->where('slug', 'LIKE', 'blogs%delete')
							->orWhere('slug', 'LIKE', 'users%create')
							->orWhere('slug', 'LIKE', 'users%edit')
							->orWhere('slug', 'LIKE', 'users%delete');
					})
					->orWhereIn('id', [
						$blogPerm->id,
						$userPerm->id
					])
					->pluck('id')
					->toArray()
				);

		// Editor
		UserType::where('name', '=', 'Editor')
			->first()
			->permissions()
			->sync(
				Permission::select(['id'])
					->where('slug', '<>', 'change_owner')
					->whereNotIn('parent_permission', [
						$userPerm->id,
						$permPerm->id,
						$typePerm->id
					])
					->whereNotIn('id', [
						$permPerm->id,
						$typePerm->id
					])
					->orWhere(function($query) use ($blogPerm, $userPerm) {
						$query->where('parent_permission', '=', $blogPerm->id)
						->where('slug', 'NOT LIKE', 'blogs%perma_delete');
					})
					->orWhereIn('id', [
						$blogPerm->id,
						$userPerm->id
					])
					->pluck('id')
					->toArray()
			);
	}
}