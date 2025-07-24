<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    \App\Models\User::factory()->create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('123123123'),
        'role' => 'admin',
    ]);

    $this->call([
        categorySeeder::class, // ✅ panggil di sini, bukan di dalam class categorySeeder
    ]);
    $this->call([
        bookSeeder::class, // ✅ panggil di sini, bukan di dalam class categorySeeder
    ]);

    $this->call([
        GuruSeeder::class,
        KelasSeeder::class,
        SiswaSeeder::class,
    ]);
    $this->call([
        AdminSeeder::class,
        GuruSeeder::class,
        KegiatanSeeder::class,
        FeedbackSeeder::class,
    ]);


}

}
