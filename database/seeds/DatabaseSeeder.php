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
        // $this->call(UsersTableSeeder::class);
        //$this->call(Admin_userTableSeeder::class);
        // $this->call(UserTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
    }
}
