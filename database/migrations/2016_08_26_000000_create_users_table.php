<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name')->nullable();
            $table->string('slug')->nullable();
            $table->integer('user_role_id')->unsigned();
            $table->foreign('user_role_id')->references('id')->on('user_roles');
            $table->unsignedInteger('country_code')->nullable();
            $table->unsignedBigInteger('mobile_number');
            $table->unsignedInteger('otp')->default('1234')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->boolean('is_blocked')->default(0);
            $table->boolean('is_notify')->default(false);
            $table->string('image')->nullable();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
