<?php

use Illuminate\Database\Seeder;

class SubscriptionPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('subscription_plans')->delete();
        
        DB::table('subscription_plans')->insert([
            ['title' => 'Free', 'slug' => 'free-1', 'product_limit' => 0, 'service_limit' => 0, 'price' => 0, 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['title' => 'Search result on top', 'slug' => 'Search result on top-2', 'product_limit' => 0, 'service_limit' => 0, 'price' => 5, 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['title' => 'Banner', 'slug' => 'Banner-3', 'product_limit' => 0, 'service_limit' => 0, 'price' => 10, 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['title' => '2+3', 'slug' => '2-3-4', 'product_limit' => 0, 'service_limit' => 0, 'price' => 12, 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
    	]);
    }
}
