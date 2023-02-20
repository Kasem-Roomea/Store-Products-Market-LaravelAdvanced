<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Portfolio extends Migration
{
    public function up()
    {
        Schema::create('portfolio', function (Blueprint $table) {

		$table->id();
		$table->string('image');
		$table->text('descriptionAr')->nullable();
		$table->text('descriptionEn')->nullable();
		$table->integer('categories_id')->nullable();
		$table->tinyInteger('is_active')->default(1);

        });
    }

    public function down()
    {
        Schema::dropIfExists('portfolio');
    }
}
