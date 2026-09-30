<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => '1234567890'
            ],
            [
                'username' => 'cylock',
                'email' => 'cylock@gmail.com',
                'password' => 'mypassword1234'
            ]
        ]);
    }
}
