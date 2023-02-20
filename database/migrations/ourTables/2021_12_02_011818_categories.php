<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Categories extends Migration
{
	public function up()
    {
        Schema::create('categories', function (Blueprint $table) {

		$table->id();
		$table->tinyInteger('is_active')->default(1);
		$table->string('name_ar')->nullable();
		$table->string('name_en')->nullable();
		$table->text('description_ar')->nullable();
		$table->text('description_en')->nullable();
		$table->integer('categories_id')->nullable();
		$table->enum('type',['services','portfolio'])->nullable();
		$table->datetime('created_at');
		$table->string('image')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
