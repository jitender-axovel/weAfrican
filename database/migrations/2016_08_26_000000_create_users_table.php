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
            $table->string('full_name');
            $table->string('slug');
            $table->integer('user_role_id')->unsigned();
            $table->foreign('user_role_id')->references('id')->on('user_roles');
            $table->string('email')->unique();
            $table->integer('mobile_no');
            $table->integer('otp');
            $table->string('password');
            $table->boolean('is_blocked')->default(0);
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
