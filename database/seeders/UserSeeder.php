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
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'password' => Hash::make('password')],
            );

            $user->syncRoles('user');
        }

        // Admin: hanya dibuat kalau ADMIN_EMAIL & ADMIN_PASSWORD diset
        if (config('app.admin_email') && config('app.admin_password')) {
            $admin = User::firstOrCreate(
                ['email' => config('app.admin_email')],
                ['name' => 'Admin', 'password' => Hash::make(config('app.admin_password'))],
            );

            $admin->syncRoles('admin');
        }
    }
}