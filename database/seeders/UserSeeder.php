<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@email.com',
            'password' => Hash::make('test1234'),
            'role' => 'admin',
        ]);

        // Buat User Biasa
        User::create([
            'name' => 'Regular User',
            'email' => 'user@email.com',
            'password' => Hash::make('test1234'),
            'role' => 'user',
        ]);
    }
}
