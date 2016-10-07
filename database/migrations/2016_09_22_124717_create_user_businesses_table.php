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
            $table->longText('about_us')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->integer('pin_code')->nullable();
            $table->bigInteger('mobile_number');
            $table->bigInteger('secondary_phone_number')->nullable();
            $table->string('email');
            $table->string('website')->nullable();
            $table->string('working_hours')->nullable();
            $table->string('business_logo')->nullable();
            $table->string('identity_proof')->nullable();
            $table->string('business_proof')->nullable();
            $table->boolean('is_identity_proof_validate')->default(false);
            $table->boolean('is_business_proof_validate')->default(false);
            $table->boolean('is_agree_to_terms');
            $table->boolean('is_blocked')->default(false);
            $table->float('latitude', 8, 10)->nullable();
            $table->float('longitude', 8, 10)->nullable();
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
