<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Contacts extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {

        $table->id();
        $table->string('name');
		$table->string('email')->nullable();
		$table->string('phone')->nullable();
		$table->text('message');
		$table->tinyInteger('open')->default(1);
		$table->datetime('created_at');

        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
