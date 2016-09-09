<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        
        DB::table('users')->insert([
        	['full_name' => 'Divya', 'slug' => 'divya-1', 'user_role_id' => 1,'email' => 'divya.ravish@axovel.in','mobile_no' => 999, 'otp' =>325235,'password' => Hash::make('admin567'), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['full_name' => 'Rohan', 'slug' => 'rohan-2', 'user_role_id' => 3,'email' => 'rohan@axovel.in','mobile_no' => 999, 'otp' =>54534, 'password' => Hash::make('123456'), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
	        ['full_name' => 'sakshi','slug' => 'sakshi-3', 'user_role_id' => 4,'email' => 'sakshi@axovel.in','mobile_no' => 999,'otp' =>636363, 'password' => Hash::make('123456'), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
    	]);
    }
}
