<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Seo extends Migration
{
    public function up()
    {
        Schema::create('seo', function (Blueprint $table) {

		$table->id();
		$table->text('description')->nullable();
		$table->text('keywords')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('seo');
    }
}
