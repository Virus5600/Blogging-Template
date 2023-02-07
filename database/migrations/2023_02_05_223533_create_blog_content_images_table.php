<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_content_images', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('blog_id')->unsigned();
			$table->string('image_name');
			$table->timestamps();

			$table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('blog_content_images');
	}
};