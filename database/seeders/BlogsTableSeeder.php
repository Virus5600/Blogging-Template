<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Blog;

class BlogsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Blog::create([
			'id' => 1,
			'title' => "Introduction",
			'summary' => "An introduction of me!",
			'poster' => "introduction-1676776749-63f1952d78952.png",
			'slug' => "introduction-1676776749",
			'content' => "<p><span style=\"font-size: 36px;\">Hello!</span><p>I'm Code Senpai a.k.a. Virus5600... but I'm mostly known as Satch by my acquaintances, friends, and family.</p><p>I'm currently a working student, studying at National University under the BS Computer Science with specialization in Digital Forensics. However, my strong suit is web development and I've made several projects already.</p><p>I'm also a Minecraft enthusiasts and mod developer. So far, I've developed 2 published mods for Bedrock Edition (Mobile, Console, and Win10) and 1 mod for Java Edition (PC).</p><p>The bedrock mods I've developed are:</p><ol><li><span style=\"font-weight: bolder;\">MCPC Commands</span>&nbsp;which allows players on bedrock to use java edition commands using the \"/\" (slash) command. It was manually coded using JavaScript and ran with the BlockLauncher application.<br><img style=]\"width: 50%;\" data-filename=\"introduction-1676776749-content_image-63f197c765ef9.png\" src=\"https://infosec-project.s3.ap-northeast-1.amazonaws.com/uploads/blogs/introduction-1676776749/content/introduction-1676776749-content_image-63f197c765ef9.png\" data-fallback-image=\"https://blogging-tmp-test.herokuapp.com/storage/uploads/blogs/default.png\"><br></li><li><span style=\"font-weight: bolder;\">Defensive Measures Add-On</span>&nbsp;was my 2nd mod developed for bedrock. It was created using the built-in Mojang add-on API and thus, I only use JSON instead of an actual programming language. All models, textures, and animations are all also created by me.<br><img style=\"width: 50%;\" data-filename=\"introduction-1676776749-content_image-63f197c8b566f.png\" src=\"https://infosec-project.s3.ap-northeast-1.amazonaws.com/uploads/blogs/introduction-1676776749/content/introduction-1676776749-content_image-63f197c8b566f.png\" data-fallback-image=\"https://blogging-tmp-test.herokuapp.com/storage/uploads/blogs/default.png\"><br></li></ol><p>On the other hand, the only Java Edition mod I've developed is the Java counterpart of Defensive Measures Add-On. It's the same name except the \"Add-On\" part where I replaced it with \"Mod\" thus naming it Defensive Measures Mod.</p><p><img style=\"width: 50%;\" data-filename=\"introduction-1676776749-content_image-63f197c9939a3.png\" src=\"https://infosec-project.s3.ap-northeast-1.amazonaws.com/uploads/blogs/introduction-1676776749/content/introduction-1676776749-content_image-63f197c9939a3.png\" data-fallback-image=\"https://blogging-tmp-test.herokuapp.com/storage/uploads/blogs/default.png\"><br></p></p>",
			'is_draft' => 0,
			'author' => 1,
			'created_at' => "2023-02-19 03:19:09",
			'updated_at' => "2023-02-19 03:30:18"
		]);

		Blog::create([
			'id' => 2,
			'title' => "This is fine...",
			'summary' => "Yeah, this is fine...",
			'poster' => "this-is-fine-1676778849-63f19d610c735.png",
			'slug' => "this-is-fine-1676778849",
			'content' => "<p>As we all know... you do not know what I know.<p>However, we all know that the more you fuck around, the more you find out.</p><p class=\"text-center\"><br></p><p class=\"text-center\"><img style=\"width: 25%;\" data-filename=\"this-is-fine-1676778849-content_image-63f19d63aa278.jpeg\" src=\"https://infosec-project.s3.ap-northeast-1.amazonaws.com/uploads/blogs/this-is-fine-1676778849/content/this-is-fine-1676778849-content_image-63f19d63aa278.jpeg\" data-fallback-image=\"https://blogging-tmp-test.herokuapp.com/storage/uploads/blogs/default.png\"><br><small class=\"text-secondary text-wrap\" style=\"max-width: 10%; max-inline-size: 10%;\">Figure 1.0: FAFO Chart, indicating that the more you fuck around, the more you fucking find out.</small></p><p>Ah, also...</p><p style=\"text-align: center;\"><img style=\"width: 800px;\" data-filename=\"this-is-fine-1676778849-content_image-63f19d63e1c00.png\" src=\"https://infosec-project.s3.ap-northeast-1.amazonaws.com/uploads/blogs/this-is-fine-1676778849/content/this-is-fine-1676778849-content_image-63f19d63e1c00.png\" data-fallback-image=\"https://blogging-tmp-test.herokuapp.com/storage/uploads/blogs/default.png\"><br></p><p style=\"text-align: center;\">Please support me. &#128517;</p></p>",
			'is_draft' => 0,
			'author' => 1,
			'created_at' => "2023-02-19 03:54:09",
			'updated_at' => "2023-02-22 11:01:13"
		]);
	}
}