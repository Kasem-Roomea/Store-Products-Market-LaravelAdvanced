<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Services extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {

		$table->id();
		$table->string('name_ar')->nullable();
		$table->string('name_en')->nullable();
		$table->string('description_ar')->nullable();
		$table->string('description_en')->nullable();
		$table->text('service_ar')->nullable();
		$table->string('service_en');
		$table->text('agent')->nullable();
		$table->string('image')->nullable();
		$table->datetime('created_at');
		$table->tinyInteger('is_active')->default(1);
		$table->integer('seo_id')->nullable();
		$table->string('client');

        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
}
