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
            'id' => 1,
            'user_id' => 5,
            'business_id' => 'Div999',
            'bussiness_category_id' => 1,
            'title' => 'Divya',
            'keywords' => 'Divya',
            'about_us' => 'Divya',
            'website' => 'divyaaxovel.com',
            'is_identity_proof_validate' => 1,
            'is_business_proof_validate' => 1,
            'is_agree_to_terms' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);
    }
}
