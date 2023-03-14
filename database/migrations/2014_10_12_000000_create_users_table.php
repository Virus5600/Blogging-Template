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
		Schema::create('users', function (Blueprint $table) {
			$table->id();

			// User information
			$table->string('first_name');
			$table->string('middle_name')->nullable();
			$table->string('last_name');
			$table->string('suffix')->nullable();
			$table->date('birthdate');
			$table->string('email')->unique();
			$table->string('avatar')->nullable();
			$table->bigInteger('user_type_id')->unsigned();
			$table->string('username');
			$table->string('password');
			
			// Login related information
			$table->tinyInteger('login_attempts')->default(0)->unsigned();
			$table->boolean('locked')->default(false);
			$table->ipAddress('locked_by')->nullable();
			$table->date('last_auth')->nullable();
			$table->rememberToken();
			$table->softDeletes();
			$table->timestamps();

			$table->foreign('user_type_id')->references('id')->on('user_types')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
};
