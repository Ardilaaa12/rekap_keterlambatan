<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => "Admin",
            'email' => "admin1@gmail.com",
            'role' => "admin",
            "password" => Hash::make("admin1")
        ]);

        User::create([
            'name' => "ps Cisarua 1",
            'email' => "psCisarua1@gmail.com",
            'role' => "ps",
            "password" => Hash::make("psCis")
        ]);
    }
}
