<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_businesses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('bussiness_category_id')->unsigned();
            $table->foreign('bussiness_category_id')->references('id')->on('bussiness_categories');
            $table->string('title');
            $table->string('keywords');
            $table->longText('about_us');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->integer('pin_code');
            $table->integer('phone_number');
            $table->integer('secondary_phone_number');
            $table->string('email');
            $table->string('website');
            $table->string('working_hours');
            $table->string('identity_proof');
            $table->string('business_proof');
            $table->boolean('is_identity')->default(false);
            $table->boolean('is_business')->default(false);
            $table->boolean('is_agree_to_terms');
            $table->boolean('is_blocked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_businesses');
    }
}
