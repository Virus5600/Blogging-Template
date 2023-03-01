<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BlogContentImage;

class BlogContentImagesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		BlogContentImage::create([
			'blog_id' => 1,
			'image_name' => "introduction-1676776749-content_image-63f197c765ef9.png"
		]);

		BlogContentImage::create([
			'blog_id' => 1,
			'image_name' => "introduction-1676776749-content_image-63f197c8b566f.png"
		]);

		BlogContentImage::create([
			'blog_id' => 1,
			'image_name' => "introduction-1676776749-content_image-63f197c9939a3.png"
		]);

		BlogContentImage::create([
			'blog_id' => 2,
			'image_name' => "this-is-fine-1676778849-content_image-63f19d63aa278.jpeg"
		]);

		BlogContentImage::create([
			'blog_id' => 2,
			'image_name' => "this-is-fine-1676778849-content_image-63f19d63e1c00.png"
		]);
	}
}