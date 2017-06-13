<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserRolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(BussinessCategoriesTableSeeder::class);
        $this->call(SubscriptionPlansTableSeeder::class);
        $this->call(CmsPagesTableSeeder::class);
        $this->call(CountryListsTableSeeder::class);
        $this->call(EventSeatingPlanSeeder::class);
        $this->call(UserBusinessesTableSeeder::class);
        $this->call(SubscriptionPlansTableSeeder::class);
        $this->call(SecurityQuestionsTableSeeder::class);
        $this->call(EventCategorySeeder::class);
        $this->call(UserPortfoliosSeeder::class);
        $this->call(UserBusinessEventCategorySeeder::class);
        $this->call(UserBusinessEventSeeder::class);
        $this->call(UserBusinessFollowersSeeder::class);
        $this->call(UserBusinessLikesSeeder::class);
        $this->call(UserBusinessProductsSeeder::class);
        $this->call(UserBusinessRatingssSeeder::class);
        $this->call(UserBusinessReviewsSeeder::class);
        $this->call(UserBusinessServicesSeeder::class);
    }
}
