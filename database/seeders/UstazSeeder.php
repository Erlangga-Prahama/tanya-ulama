<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UstazSeeder extends Seeder
{
    public function run(): void
    {
        $ustazList = [
            ['name' => 'Ahmad Fauzi', 'gender' => 'L'],
            ['name' => 'Muhammad Ridwan', 'gender' => 'L'],
            ['name' => 'Abdullah Syukri', 'gender' => 'L'],
            ['name' => 'Hasan Basri', 'gender' => 'L'],
            ['name' => 'Umar Faruq', 'gender' => 'L'],
            ['name' => 'Ibrahim Khalil', 'gender' => 'L'],
            ['name' => 'Yusuf Mansur', 'gender' => 'L'],
            ['name' => 'Ismail Harun', 'gender' => 'L'],
            ['name' => 'Zainul Arifin', 'gender' => 'L'],
            ['name' => 'Abdul Ghani', 'gender' => 'L'],
            ['name' => 'Musa Karim', 'gender' => 'L'],
            ['name' => 'Dawud Salim', 'gender' => 'L'],
            ['name' => 'Isa Anwar', 'gender' => 'L'],
            ['name' => 'Fatimah Zahra', 'gender' => 'P'],
            ['name' => 'Aisyah Rahmah', 'gender' => 'P'],
            ['name' => 'Khadijah Sholihah', 'gender' => 'P'],
            ['name' => 'Maryam Nurul', 'gender' => 'P'],
            ['name' => 'Zainab Firdaus', 'gender' => 'P'],
            ['name' => 'Hafsah Mutmainnah', 'gender' => 'P'],
            ['name' => 'Ruqayyah Safira', 'gender' => 'P'],
            ['name' => 'Ummu Kultsum', 'gender' => 'P'],
            ['name' => 'Asma Wulandari', 'gender' => 'P'],
            ['name' => 'Nailah Husna', 'gender' => 'P'],
            ['name' => 'Shafiyyah Nur', 'gender' => 'P'],
            ['name' => 'Juwairiyah Salma', 'gender' => 'P'],
        ];

        foreach ($ustazList as $index => $data) {
            $role = $data['gender'] === 'L' ? 'ustaz' : 'ustazah';
            $email = strtolower(str_replace(' ', '.', $data['name'])) . '@example.com';

            $user = User::create([
                'name'                  => $data['name'],
                'email'                 => $email,
                'gender'                => $data['gender'],
                'password'              => Hash::make('password'),
                'profession'            => $role,
                'verification_document' => null,
                'is_verified'           => true,
                'verified_at'           => now(),
            ]);

            $user->assignRole($role);
        }
    }
}