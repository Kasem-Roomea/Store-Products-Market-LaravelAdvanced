<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Emails extends Migration
{
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {

        $table->id();
        $table->string('email');
		$table->integer('appInfo_id');

        });
    }

    public function down()
    {
        Schema::dropIfExists('emails');
    }
}
