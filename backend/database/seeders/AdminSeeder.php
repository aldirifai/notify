<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = [
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'phone' => '081234567890',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ];

        \App\Models\User::create($admin);
    }
}
