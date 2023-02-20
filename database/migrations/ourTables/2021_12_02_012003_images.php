<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Images extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {

        $table->id();
        $table->string('image')->nullable();
		$table->integer('albums_id')->nullable();
		$table->integer('services_id')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
}
