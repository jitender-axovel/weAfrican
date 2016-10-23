<?php

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->delete();
    	$dt = new DateTime();
	    $dt = $dt->format('Y-m-d H:i:s');
        
        DB::table('user_roles')->delete();
        DB::table('user_roles')->insert([
            ['name' => 'SuperAdmin', 'created_at' => $dt, 'updated_at' => $dt],
            ['name' => 'Admin', 'created_at' => $dt, 'updated_at' => $dt],
            ['name' => 'BussinessUser', 'created_at' => $dt, 'updated_at' => $dt],
            ['name' => 'EndUser', 'created_at' => $dt, 'updated_at' => $dt],
        ]);
    }
}
