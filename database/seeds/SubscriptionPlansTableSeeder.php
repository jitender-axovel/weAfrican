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
            ['id' => 1, 'title' => 'Sponsor Plan (Home Page)', 'slug' => 'sponser-plan-1', 'coverage' => 'Country', 'validity_period' => 0,'price' => 0,'keywords_limit' => '0', 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['id' => 2, 'title' => 'Business Plan 1', 'slug' => 'business-plan-1', 'coverage' => 'Country','validity_period' => 0, 'price' => 0, 'keywords_limit' => '0','is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['id' => 3, 'title' => 'Business Plan 2', 'slug' => 'business-plan-2', 'coverage' => 'State', 'price' => 0,'validity_period' => 0,'keywords_limit' => '0', 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['id' => 4, 'title' => 'Business Plan 3', 'slug' => 'business-plan-3', 'coverage' => 'County/Region','validity_period' => 0, 'price' => 0,'keywords_limit' => '0', 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['id' => 5, 'title' => 'Event Plan 1', 'slug' => 'event-plan-1', 'coverage' => 'Country', 'price' => 0,'validity_period' => 0, 'keywords_limit' => '0','is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['id' => 6, 'title' => 'Event Plan 2', 'slug' => 'event-plan-2', 'coverage' => 'State', 'price' => 0,'validity_period' => 0, 'keywords_limit' => '0','is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['id' => 7, 'title' => 'Event Plan 3', 'slug' => 'event-plan-3', 'coverage' => 'County/Region', 'price' => 0,'validity_period' => 0,'keywords_limit' => '0', 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['id' => 8, 'title' => 'Search Plan 1', 'slug' => 'search-plan-1', 'coverage' => 'Country', 'price' => 0,'validity_period' => 0,'keywords_limit' => '5', 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['id' => 9, 'title' => 'Search Plan 2', 'slug' => 'search-plan-2', 'coverage' => 'State', 'price' => 0,'validity_period' => 0,'keywords_limit' => '10', 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['id' => 10, 'title' => 'Search Plan 3', 'slug' => 'search-plan-3', 'coverage' => 'County/Region', 'price' => 0,'validity_period' => 0,'keywords_limit' => '15', 'is_blocked' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
    	]);
    }
}