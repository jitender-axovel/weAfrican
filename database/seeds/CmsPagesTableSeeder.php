<?php

use Illuminate\Database\Seeder;

class CmsPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cms_pages')->delete();
        
        DB::table('cms_pages')->insert([
        	['title' => 'About Us', 'slug' => 'about-us', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        	['title' => 'Privacy Policy', 'slug' => 'privacy-policy', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        	['title' => 'Terms of Use', 'slug' => 'terms-of-use', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        	['title' => 'Cookie Policy', 'slug' => 'cookie-policy', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['title' => 'FAQ', 'slug' => 'faq', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
    	]);
    }
}
