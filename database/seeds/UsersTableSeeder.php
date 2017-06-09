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
            'id' =>1,
            'salutation' => 'Mr',
            'first_name' => 'Jitender Singla',
            'middle_name' => 'Singla',
            'last_name' => 'Singla',
            'gender' => 'male',
            'slug' => 'jitender-singla-1',
            'user_role_id' => 1,
            'address' => 'Test',
            'city' => 'Test',
            'state' => 'Test',
            'country' => 'India',
            'pin_code' => '110059',
            'currency' => 'INR',
            'country_code' => 91,
            'email' => 'jitender@gmail.com',
            'mobile_number' => 9999999999,
            'password' => Hash::make('admin123'),
            'is_verified' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' =>2,
            'salutation' => 'Ms',
            'first_name' => 'Richa',
            'middle_name' => 'Sing',
            'last_name' => 'Singh',
            'gender' => 'male',
            'slug' => 'richa-1',
            'user_role_id' => 2,
            'address' => 'Test',
            'city' => 'Test',
            'state' => 'Test',
            'country' => 'India',
            'pin_code' => '110059',
            'currency' => 'INR',
            'country_code' => 91,
            'email' => 'richa@gmail.com',
            'mobile_number' => 9292929292,
            'password' => Hash::make('9292929292'),
            'is_verified' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' =>3,
            'salutation' => 'Mr',
            'first_name' => 'Arun',
            'middle_name' => 'Arun',
            'last_name' => 'Singh',
            'gender' => 'male',
            'slug' => 'arun-1',
            'user_role_id' => 4,
            'address' => 'Test',
            'city' => 'Test',
            'state' => 'Test',
            'country' => 'India',
            'pin_code' => '110059',
            'currency' => 'INR',
            'country_code' => 91,
            'email' => 'arun@gmail.com',
            'mobile_number' => 9393939393,
            'password' => Hash::make('9393939393'),
            'is_verified' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' =>4,
            'salutation' => 'Mr',
            'first_name' => 'Nikhil',
            'middle_name' => '',
            'last_name' => 'Singh',
            'gender' => 'male',
            'slug' => 'nikhil-1',
            'user_role_id' => 4,
            'address' => 'Test',
            'city' => 'Test',
            'state' => 'Test',
            'country' => 'India',
            'pin_code' => '110059',
            'currency' => 'INR',
            'country_code' => 91,
            'email' => 'nikhil@gmail.com',
            'mobile_number' => 9494949494,
            'password' => Hash::make('9494949494'),
            'is_verified' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' =>5,
            'salutation' => 'Ms',
            'first_name' => 'Divya',
            'middle_name' => '',
            'last_name' => 'Singh',
            'gender' => 'male',
            'slug' => 'divya-1',
            'user_role_id' => 3,
            'address' => 'Test',
            'city' => 'Test',
            'state' => 'Test',
            'country' => 'India',
            'pin_code' => '110059',
            'currency' => 'INR',
            'country_code' => 91,
            'email' => 'divya@gmail.com',
            'mobile_number' => 9494949495,
            'password' => Hash::make('admin'),
            'is_verified' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);
   }
}