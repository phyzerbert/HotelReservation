<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'General Manager',
            'email' => 'gm1@gmail.com',
            'password' => bcrypt('123456'),
            'role_id' => 1
        ]);

        User::create([
            'name' => 'Office Manager',
            'email' => 'om1@gmail.com',
            'password' => bcrypt('123456'),
            'role_id' => 2
        ]);

        User::create([
            'name' => 'Data Editor',
            'email' => 'editor1@gmail.com',
            'password' => bcrypt('123456'),
            'role_id' => 3
        ]);
    }
}
