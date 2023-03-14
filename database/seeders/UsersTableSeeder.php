<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

use Hash;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		User::create([
			'first_name' => "Blog",
			'last_name' => "Owner",
			'birthdate' => now()->format("Y-m-d"),
			'email' => 'privatelaravelmailtester@gmail.com',
			'avatar' => 'Code Senpai.png',
			'username' => 'owner',
			'password' => Hash::make('owner'),
			'user_type_id' => 1
		]);

		User::create([
			'first_name' => "Blog",
			'last_name' => "Admin",
			'birthdate' => now()->format("Y-m-d"),
			'email' => 'admin@admin.com',
			'username' => 'admin',
			'password' => Hash::make('admin'),
			'user_type_id' => 2
		]);

		User::create([
			'first_name' => "Blog",
			'last_name' => "Moderator",
			'birthdate' => now()->format("Y-m-d"),
			'email' => 'moderator@moderator.com',
			'username' => 'moderator',
			'password' => Hash::make('moderator'),
			'user_type_id' => 3
		]);

		User::create([
			'first_name' => "Blog",
			'last_name' => "Editor",
			'birthdate' => now()->format("Y-m-d"),
			'email' => 'editor@editor.com',
			'username' => 'editor',
			'password' => Hash::make('editor'),
			'user_type_id' => 4
		]);
	}
}