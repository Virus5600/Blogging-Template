<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\UserType;

class UserTypesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		UserType::create([
			'name' => 'Owner',
			'authority_level' => 1
		]);

		UserType::create([
			'name' => 'Admin',
			'authority_level' => 2
		]);
		
		UserType::create([
			'name' => 'Moderator',
			'authority_level' => 3
		]);
		
		UserType::create([
			'name' => 'Editor',
			'authority_level' => 4
		]);
	}
}