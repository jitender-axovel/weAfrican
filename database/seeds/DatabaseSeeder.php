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
        $this->call(CountryListTableSeeder::class);
        $this->call(EventSeatingPlanSeeder::class);
        $this->call(UserBusinessesTableSeeder::class);
        $this->call(SubscriptionPlansTableSeeder::class);
        $this->call(SecurityQuestionsTableSeeder::class);
        $this->call(EventCategorySeeder::class);
    }
}
