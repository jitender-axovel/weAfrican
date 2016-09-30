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
            ['title' => 'Sponsor Plan (Home Page)', 'slug' => 'sponser-plan-1', 'coverage' => 'Country', 'price' => 0, 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['title' => 'Business Plan1', 'slug' => 'business-plan-1', 'coverage' => 'Country', 'price' => 0, 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['title' => 'Business Plan2', 'slug' => 'business-plan-2', 'coverage' => 'State', 'price' => 0, 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['title' => 'Business Plan3', 'slug' => 'business-plan-3', 'coverage' => 'County/Region', 'price' => 0, 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['title' => 'Event Plan1', 'slug' => 'event-plan-1', 'coverage' => 'Country', 'price' => 0, 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['title' => 'Event Plan2', 'slug' => 'event-plan-2', 'coverage' => 'State', 'price' => 0, 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['title' => 'Event Plan3', 'slug' => 'event-plan-3', 'coverage' => 'County/Region', 'price' => 0, 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
    	]);
    }
}