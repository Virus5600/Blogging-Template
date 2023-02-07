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
		Schema::create('carousels', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('uploaded_by')->unsigned();
			$table->text('description')->nullable();
			$table->string('image')->nullable();
			$table->tinyInteger('is_active')->default(1);
			$table->bigInteger('deleted_by')->nullable();
			$table->softDeletes();
			$table->timestamps();

			$table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('carousels');
	}
};