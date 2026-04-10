<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $users = [
            [
                "name" => "John Doe",
                "email" => "john.doe@example.com",
                "password" => bcrypt("password123")
            ],
            [
                "name" => "Aicha Diagne",
                "email" => "aicha.diagne@example.com",
                "password" => bcrypt("password123")
            ],
            [
                "name" => "Aly Tall Niang",
                "email" => "aly.tall.niang@example.com",
                "password" => bcrypt("password123")
            ],

        ];


        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
