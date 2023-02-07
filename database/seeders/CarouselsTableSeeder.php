<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Carousel;

class CarouselsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Carousel::create([
			'uploaded_by' => 1,
			'description' => 'A sample carousel image',
			'image' => 'Defensive Measures Add-On Banner.png'
		]);

		Carousel::create([
			'uploaded_by' => 1,
			'description' => 'A sample carousel image',
			'image' => 'Downloads Banner.jpg'
		]);
	}
}