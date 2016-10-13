<?php

use Illuminate\Database\Seeder;

class UserBusinessesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_businesses')->delete();
        
        DB::table('user_businesses')->insert([[
            'user_id' => 2,
            'bussiness_category_id' => 1,
            'title' => 'test',
            'keywords' => 'software',
            'about_us' => '',
            'address' => '#444',
            'city' => 'greater',
            'state' => 'up',
            'country' => 'India'
            'pin_code' => 898980,
            'mobile_number' => 7836860011,
            'secondary_phone_number' => 7836810011,
            'email' => 'madhav.niet@gmail.com',
            'website' => '',
            'working_hours' => '',
            'business_logo' => '',
            'identity_proof' => '',
            'business_proof' => '',
            'is_identity_proof_validate' => '',
            'is_business_proof_validate' => '',
            'is_agree_to_terms' => 1,
            'is_blocked' => 0,
            'latitude' => 0,
            'logitude' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'user_id' => 3,
            'bussiness_category_id' => 2,
            'title' => 'Clothing, accessories, and shoes',
            'keywords' => 'cloth,dress',
            'about_us' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'country' => 'India'
            'pin_code' => 110075,
            'mobile_number' => 9191919191,
            'secondary_phone_number' => 2131243534,
            'email' => 'divya.ravish@axovel.in',
            'website' => '',
            'working_hours' => '',
            'business_logo' => '',
            'identity_proof' => '',
            'business_proof' => '',
            'is_identity_proof_validate' => '',
            'is_business_proof_validate' => '',
            'is_agree_to_terms' => 1,
            'is_blocked' => 0,
            'latitude' => 0,
            'logitude' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);
    }
}
