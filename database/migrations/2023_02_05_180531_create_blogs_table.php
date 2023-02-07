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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('summary')->nullable();
            $table->string('poster')->nullable();
            $table->string('slug');
            $table->mediumText('content');
            $table->boolean('is_draft')->default(1);
            $table->bigInteger('author')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('author')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
};
