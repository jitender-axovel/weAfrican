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
        $this->call(EventCategoriesSeeder::class);
        $this->call(BusinessEventsSeeder::class);
        $this->call(BusinessFollowersSeeder::class);
        $this->call(BusinessLikesSeeder::class);
        $this->call(BusinessProductsSeeder::class);
        $this->call(BusinessRatingssSeeder::class);
        $this->call(BusinessReviewsSeeder::class);
        $this->call(BusinessServicesSeeder::class);
    }
}
