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
            'user_id' => 5,
            'business_id' => 'Div999',
            'business_category_id' => 1,
            'title' => 'Divya',
            'keywords' => 'Divya',
            'about_us' => 'Divya',
            'address' => 'Dawarka Sector 7',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'country' => 'India',
            'pin_code' => '110054',
            'currency' => 'INR',
            'mobile_number' => 9494949494,
            'email' => 'divyaaxovel@gmail.com',
            'website' => 'divyaaxovel.com',
            'is_identity_proof_validate' => 1,
            'is_business_proof_validate' => 1,
            'is_agree_to_terms' => 1,
            'latitude' => 28.662199,
            'longitude' => 77.228125,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);
    }
}
