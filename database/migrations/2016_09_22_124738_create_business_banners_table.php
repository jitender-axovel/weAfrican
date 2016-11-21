<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_banners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('business_id')->unsigned();
            $table->foreign('business_id')->references('id')->on('user_businesses');
            $table->integer('subscription_plan_id')->unsigned();
            $table->foreign('subscription_plan_id')->references('id')->on('subscription_plans');
            $table->string('image')->nullable();
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->decimal('latitude', 9, 6)->nullable();
            $table->decimal('longitude', 9 ,6)->nullable();
            $table->boolean('is_blocked')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('business_banners');
    }
}
