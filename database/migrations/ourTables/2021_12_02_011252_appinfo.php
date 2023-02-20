<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Appinfo extends Migration
{
	public function up()
    {
        Schema::create('appinfo', function (Blueprint $table) {

		$table->id();
		
		$table->text('welcomeAr')->nullable();
		$table->text('welcomeEn')->nullable();
		$table->text('aboutAr')->nullable();
		$table->text('aboutEn')->nullable();
		$table->text('policyAr')->nullable();
		$table->text('policyEn')->nullable();
		$table->text('privacyAr')->nullable();
		$table->text('privacyEn')->nullable();
		$table->datetime('createdAt')->nullable();
		$table->datetime('updatedAt')->nullable();

		$table->tinyInteger('hiddenPhone')->nullable();
		$table->bigInteger('subscriptions_id')->nullable();
		$table->integer('currencies_id')->nullable();
		$table->string('VAT')->nullable();
		$table->string('logo')->nullable();
		$table->string('facebook')->nullable();
		$table->string('twitter')->nullable();

		$table->string('instgram')->nullable();
		$table->string('youtube')->nullable();
		$table->string('main_color')->nullable();
		$table->string('sub_color1')->nullable();
		$table->string('sub_color2')->nullable();
		$table->string('snapchat')->nullable();
		$table->string('appNameAr')->nullable();
		$table->string('appNameEn')->nullable();
		$table->text('addressAr')->nullable();
		$table->text('addressEn')->nullable();

		$table->text('appSubjectAr')->nullable();
		$table->text('appSubjectEn')->nullable();
		$table->string('homeAr')->nullable();
		$table->string('homeEn')->nullable();
		$table->string('aboutUsAr')->nullable();
		$table->string('aboutUsEn')->nullable();
		$table->string('servicesAr')->nullable();
		$table->string('servicesEn')->nullable();
		$table->string('portfolioAr')->nullable();
		$table->string('portfolioEn')->nullable();
		$table->string('contactAr')->nullable();
		$table->string('contactEn')->nullable();
		$table->string('defualtLang')->nullable();
		$table->string('coverimage')->nullable();
		$table->string('image_home_1')->nullable();
		$table->string('title_home_1Ar')->nullable();
		$table->string('title_home_1En')->nullable();
		$table->string('image_home_2')->nullable();
		$table->string('title_home_2Ar')->nullable();
		$table->string('title_home_2En')->nullable();
		$table->string('cover_image')->nullable();
		$table->text('map_link')->nullable();
		$table->integer('seo_id')->nullable();
        $table->string('ar')->nullable()->default('ar');
		$table->string('en')->nullable()->default('en');
		$table->string('whatsapp')->nullable();


        });
    }

    public function down()
    {
        Schema::dropIfExists('appinfo');
    }
}
