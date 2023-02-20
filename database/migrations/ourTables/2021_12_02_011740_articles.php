<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Articles extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {

        $table->id();
        $table->string('title_ar');
		$table->string('title_en')->nullable();
		$table->text('description_ar')->nullable();
		$table->text('description_en')->nullable();
		$table->timestamp('created_at')->nullable();
		$table->tinyInteger('is_active')->default(1);

        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
