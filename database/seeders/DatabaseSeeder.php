<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call([
			SettingsTableSeeder::class,
			PermissionsTableSeeder::class,
			UserTypesTableSeeder::class,
			UserTypePermissionsTableSeeder::class,
			UsersTableSeeder::class,
			CarouselsTableSeeder::class,
			BlogsTableSeeder::class,
			BlogContentImagesTableSeeder::class,
		]);
	}
}