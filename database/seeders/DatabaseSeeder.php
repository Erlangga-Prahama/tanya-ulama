<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

                // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@konsulku.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_verified' => true,
                'verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // Create sample user
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
            ]
        );
        $user->assignRole('user');

        $ustaz = User::firstOrCreate(
            ['email' => 'ustaz@gmail.com'],
            [
                'name' => 'ustaz',
                'password' => Hash::make('ustaz1234'),
                'is_verified' => true,
                'verified_at' => now(),
            ]
        );

        $ustaz->assignRole('ustaz');
    }
}
