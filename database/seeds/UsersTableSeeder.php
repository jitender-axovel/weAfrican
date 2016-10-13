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
            'slug' => 'jitender-singla-1',
            'user_role_id' => 1,
            'country_code' => 91,
            'mobile_number' => 9999999999,
            'password' => Hash::make('admin123'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'full_name' => 'madhav',
            'slug' => 'madhav-2',
            'user_role_id' => 3,
            'country_code' => 91,
            'mobile_number' => 7836860011,
            'password' => Hash::make('7836860011'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'full_name' => 'Divya',
            'slug' => 'divya-3',
            'user_role_id' => 3,
            'country_code' => 91,
            'mobile_number' => 9191919191,
            'password' => Hash::make('9191919191'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);
   }
}