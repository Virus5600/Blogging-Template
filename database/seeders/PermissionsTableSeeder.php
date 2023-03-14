<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Permission::create([
			'name' => 'Change Owner',
			'slug' => 'change_owner'
		]);

		// BLOGS
		$blogPerm =  Permission::create([
			'name' => 'Blogs Tab Access',
			'slug' => 'blogs_tab_access'
		]);

		Permission::create([
			'parent_permission' => $blogPerm->id,
			'name' => 'Blogs Tab Create',
			'slug' => 'blogs_tab_create'
		]);

		Permission::create([
			'parent_permission' => $blogPerm->id,
			'name' => 'Blogs Tab Edit',
			'slug' => 'blogs_tab_edit'
		]);

		Permission::create([
			'parent_permission' => $blogPerm->id,
			'name' => 'Blogs Tab Delete',
			'slug' => 'blogs_tab_delete'
		]);

		Permission::create([
			'parent_permission' => $blogPerm->id,
			'name' => 'Blogs Tab Perma Delete',
			'slug' => 'blogs_tab_perma_delete'
		]);

		// USERS
		$userPerm = Permission::create([
			'name' => 'Users Tab Access',
			'slug' => 'users_tab_access'
		]);

		Permission::create([
			'parent_permission' => $userPerm->id,
			'name' => 'Users Tab Create',
			'slug' => 'users_tab_create'
		]);

		Permission::create([
			'parent_permission' => $userPerm->id,
			'name' => 'Users Tab Edit',
			'slug' => 'users_tab_edit'
		]);

		Permission::create([
			'parent_permission' => $userPerm->id,
			'name' => 'Users Tab Permissions',
			'slug' => 'users_tab_permissions'
		]);

		Permission::create([
			'parent_permission' => $userPerm->id,
			'name' => 'Users Tab Delete',
			'slug' => 'users_tab_delete'
		]);

		Permission::create([
			'parent_permission' => $userPerm->id,
			'name' => 'Users Tab Perma Delete',
			'slug' => 'users_tab_perma_delete'
		]);

		// USER TYPE
		$typePerm = Permission::create([
			'name' => 'User Types Tab Access',
			'slug' => 'user_types_tab_access'
		]);

		Permission::create([
			'parent_permission' => $typePerm->id,
			'name' => 'User Types Tab Create',
			'slug' => 'user_types_tab_create'
		]);

		Permission::create([
			'parent_permission' => $typePerm->id,
			'name' => 'User Types Tab Edit',
			'slug' => 'user_types_tab_edit'
		]);

		Permission::create([
			'parent_permission' => $typePerm->id,
			'name' => 'User Types Tab Delete',
			'slug' => 'user_types_tab_delete'
		]);

		Permission::create([
			'parent_permission' => $typePerm->id,
			'name' => 'User Types Tab Perma Delete',
			'slug' => 'user_types_tab_perma_delete'
		]);

		Permission::create([
			'parent_permission' => $typePerm->id,
			'name' => 'User Types Tab Permissions',
			'slug' => 'user_types_tab_permissions'
		]);

		// PERMISSIONS
		$permsPerm = Permission::create([
			'name' => 'Permissions Tab Access',
			'slug' => 'permissions_tab_access'
		]);

		Permission::create([
			'parent_permission' => $permsPerm->id,
			'name' => 'Permissions Tab Manage',
			'slug' => 'permissions_tab_manage'
		]);
	}
}
