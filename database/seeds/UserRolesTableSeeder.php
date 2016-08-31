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
            ['name' => 'admin', 'created_at' => $dt, 'updated_at' => $dt],
            ['name' => 'regular', 'created_at' => $dt, 'updated_at' => $dt],
            ['name' => 'bussiness', 'created_at' => $dt, 'updated_at' => $dt],
        ]);
    }
}
