<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // cek jika sudah ada
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'), // ganti password sesuai kebutuhan
                'email_verified_at' => now(),
            ]
        );
    }
}
