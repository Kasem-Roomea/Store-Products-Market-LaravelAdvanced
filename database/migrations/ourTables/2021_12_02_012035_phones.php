<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Phones extends Migration
{
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {

		$table->id();
		$table->string('phone');
		$table->integer('appInfo_id');

        });
    }

    public function down()
    {
        Schema::dropIfExists('phones');
    }
}
