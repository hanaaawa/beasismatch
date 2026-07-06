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
        $user = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password'), 'role' => 'admin']
        );
        $user->assignRole('super_admin');

        $user = User::updateOrCreate(
            ['email' => 'admin@beasismatch.test'],
            ['name' => 'Admin BeasisMatch', 'password' => Hash::make('password'), 'role' => 'admin']
        );
        $user->assignRole('super_admin');

        $user = User::updateOrCreate(
            ['email' => 'user@admin.com'],
            ['name' => 'User Account', 'password' => Hash::make('password')]
        );
        $user->assignRole('user');
    }
}
