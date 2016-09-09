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
        	['title' => 'category1', 'slug' => 'category-1', 'description' => 'grrftrtyrtyrtyr','image' => 'a107554947deaa73fa7af5ab08ee4158.jpeg','is_blocked' => 0,'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['title' => 'category2', 'slug' => 'category-2', 'description' => 'grrftrtyrtyrtyr','image' => 'ff3394b85046ce91abb2ca96b00e2d59.png','is_blocked' => 0,'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
	        ['title' => 'category3', 'slug' => 'category-3', 'description' => 'grrftrtyrtyrtyr','image' => 'a107554947deaa73fa7af5ab08ee4158.jpeg','is_blocked' => 0,'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
    	]);
    }
}
