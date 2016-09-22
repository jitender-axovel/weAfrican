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
            $table->integer('user_business_id')->unsigned();
            $table->foreign('user_business_id')->references('id')->on('user_businesses');
            $table->string('title');
            $table->text('description');
            $table->string('city');
            $table->string('url');
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
        Schema::dropIfExists('business_banners');
    }
}
