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
            'department' => 'Administration',
        ]);

        // Create Lab Manager User
        User::create([
            'name' => 'Lab Manager',
            'email' => 'labmanager@uoms.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'department' => 'Computer Lab',
            'phone' => '1234567890',
        ]);
    }
}
