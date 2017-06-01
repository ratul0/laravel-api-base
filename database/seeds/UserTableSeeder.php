<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
           'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('a')
        ]);

        User::create([
            'name' => 'user',
            'email' => 'user@test.com',
            'password' => bcrypt('a')
        ]);
    }
}
