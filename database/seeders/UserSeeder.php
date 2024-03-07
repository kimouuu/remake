<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John',
            'email' => 'organizer@gmail.com',
            'phone' => '1234567890',
            'password' => bcrypt('password'),
            'role' => 'organizer',
        ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '1239567890',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'member',
            'email' => 'member@gmail.com',
            'phone' => '163876324789',
            'password' => bcrypt('password'),
            'role' => 'member',
        ]);
    }
}
