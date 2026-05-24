<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@uoms.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Lab Manager User
        User::create([
            'name' => 'Lab Manager',
            'email' => 'user@uoms.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create additional test users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@uoms.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@uoms.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
