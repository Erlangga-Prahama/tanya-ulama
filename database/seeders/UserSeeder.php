<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Ahmad Rizki', 'email' => 'ahmad.rizki@example.com'],
            ['name' => 'Budi Santoso', 'email' => 'budi.santoso@example.com'],
            ['name' => 'Citra Dewi', 'email' => 'citra.dewi@example.com'],
            ['name' => 'Dian Pratama', 'email' => 'dian.pratama@example.com'],
            ['name' => 'Eka Putri', 'email' => 'eka.putri@example.com'],
            ['name' => 'Fajar Nugroho', 'email' => 'fajar.nugroho@example.com'],
            ['name' => 'Gilang Ramadhan', 'email' => 'gilang.ramadhan@example.com'],
            ['name' => 'Hani Safitri', 'email' => 'hani.safitri@example.com'],
            ['name' => 'Irfan Maulana', 'email' => 'irfan.maulana@example.com'],
            ['name' => 'Jihan Amelia', 'email' => 'jihan.amelia@example.com'],
        ];

        foreach ($users as $data) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make('password'),
            ]);

            $user->assignRole('user');
        }
    }
}