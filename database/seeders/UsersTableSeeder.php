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
			'username' => 'admin',
			'password' => Hash::make('admin'),
			'user_type_id' => 1
		]);
	}
}