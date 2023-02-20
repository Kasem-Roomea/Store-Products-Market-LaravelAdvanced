<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdminsLogin extends Migration
{
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {

		$table->id();
		$table->string('name')->nullable();
		$table->string('email');
		$table->string('emailApi');
		$table->string('password');
		$table->string('passwordApi');
		$table->string('apiToken')->nullable();
		$table->datetime('updated_at')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
