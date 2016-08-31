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
        	['first_name' => 'Divya', 'last_name' => '', 'slug' => 'divya-1', 'user_role_id' => 1,'email' => 'divya.ravish@axovel.in','mobile_no' => 999, 'password' => Hash::make('admin567'), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
    	]);
    }
}
