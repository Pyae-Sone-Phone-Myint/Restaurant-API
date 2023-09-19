<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            "name" => "Admin Kyaw Gyi",
            "email" => "admin@gmail.com",
            "password" => Hash::make("asdffdsa"),
            "role_id" => 1,
            "banned" => false,
            "gender" => 'male'
        ]);

        User::factory()->create([
            "name" => "Hla Hla",
            "phone" => "09777888666",
            "date_of_birth" => "4.9.1998",
            "gender" => "female",
            "address" => "nay yar ma thi",
            "role_id" => 4,
            "banned" => false,
            "email" => "hh@gmail.com",
            "password" => Hash::make("asdffdsa"),
        ]);

        User::factory()->create([
            "name" => "Mg Aung",
            "phone" => "09777888666",
            "date_of_birth" => "4.9.1998",
            "gender" => "male",
            "address" => "nay yar ma thi",
            "role_id" => 5,
            "banned" => false,
            "email" => "ma@gmail.com",
            "password" => Hash::make("asdffdsa"),
        ]);
    }
}
