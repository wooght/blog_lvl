<?php

use Illuminate\Database\Seeder;

class Admin_userTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory('App\Admin_users',3)->create(['password' => bcrypt('123456')]);
    }
}