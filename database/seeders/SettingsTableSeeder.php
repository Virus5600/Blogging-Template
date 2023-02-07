<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Settings;

class SettingsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Settings::create([
			'name' => 'web_logo',
			'value' => 'default-favicon.png',
			'is_file' => 1
		]);

		Settings::create([
			'name' => 'web_name',
			'value' => 'Blogging Website Template'
		]);

		Settings::create([
			'name' => 'web_desc',
			'value' => 'A blogging website template that allows you to setup a basic blogging page'
		]);

		Settings::create([
			'name' => 'address',
			'value' => null
		]);

		Settings::create([
			'name' => 'contacts',
			'value' => null
		]);

		Settings::create([
			'name' => 'email',
			'value' => null
		]);
	}
}
// admin123