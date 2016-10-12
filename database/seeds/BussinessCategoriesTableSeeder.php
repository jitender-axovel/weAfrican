<?php

use Illuminate\Database\Seeder;

class BussinessCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bussiness_categories')->delete();
        
        DB::table('bussiness_categories')->insert([
        	['title' => 'category1', 'slug' => 'category-1', 'description' => 'grrftrtyrtyrtyr','image' => 'cf02abe0ef5b9f8e429b6689ebc6ec7e.jpg','is_blocked' => 0,'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['title' => 'category2', 'slug' => 'category-2', 'description' => 'grrftrtyrtyrtyr','image' => '3d0e787630bf396dd2213b6035224665.jpeg','is_blocked' => 0,'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
	        ['title' => 'category3', 'slug' => 'category-3', 'description' => 'grrftrtyrtyrtyr','image' => '36c26a20f7d5cbe7ed1e5d0a591a3770.jpeg','is_blocked' => 0,'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
    	]);
    }
}
