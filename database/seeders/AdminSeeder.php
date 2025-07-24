<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            ['nama' => 'Admin 1', 'username' => 'admin1', 'password' => 'admin123'],
            ['nama' => 'Admin 2', 'username' => 'admin2', 'password' => 'admin123'],
            ['nama' => 'Admin 3', 'username' => 'admin3', 'password' => 'admin123'],
            ['nama' => 'Admin 4', 'username' => 'admin4', 'password' => 'admin123'],
        ];

        foreach ($admins as $admin) {
            Admin::create([
                'nama' => $admin['nama'],
                'username' => $admin['username'],
                'password' => Hash::make($admin['password']),
            ]);
        }
    }
}
