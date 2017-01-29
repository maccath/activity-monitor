<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
          'name' => env('ADMIN_NAME', str_random(10)),
          'email' => env('ADMIN_EMAIL', str_random(10) . '@example.com'),
          'password' => bcrypt('secret'),
        ]);
    }
}
