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
		Schema::create('user_type_permissions', function (Blueprint $table) {
			$table->bigInteger('user_type_id')->unsigned();
			$table->bigInteger('permission_id')->unsigned();

			$table->foreign('user_type_id')->references('id')->on('user_types')->onDelete('cascade');
			$table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('user_type_permissions');
	}
};
