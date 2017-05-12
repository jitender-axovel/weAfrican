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
        
        DB::table('users')->insert([[
            'full_name' => 'Jitender Singla',
            'user_name' => 'jitender-singla',
            'slug' => 'jitender-singla-1',
            'user_role_id' => 1,
            'country_code' => 91,
            'mobile_number' => 9999999999,
            'password' => Hash::make('admin123'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'full_name' => 'Richa',
            'user_name' => 'richa',
            'slug' => 'richa-2',
            'user_role_id' => 4,
            'country_code' => 91,
            'mobile_number' => 9292929292,
            'password' => Hash::make('9292929292'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'full_name' => 'Arun',
            'user_name' => 'arun',
            'slug' => 'arun-3',
            'user_role_id' => 4,
            'country_code' => 91,
            'mobile_number' => 9393939393,
            'password' => Hash::make('9393939393'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'full_name' => 'Nikhil',
            'user_name' => 'nikhil',
            'slug' => 'nikhil-4',
            'user_role_id' => 4,
            'country_code' => 91,
            'mobile_number' => 9494949494,
            'password' => Hash::make('9494949494'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);
   }
}