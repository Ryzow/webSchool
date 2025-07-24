<?php
// database/seeders/FeedbackSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;

class feedbackSeeder extends Seeder   // <‑‑ perbaiki huruf besar
{
    public function run(): void
    {
        // Data contoh manual
        Feedback::create([
            'nama'  => 'Rina Siswa',
            'email' => 'rina@example.com',
            'pesan' => 'Aplikasinya membantu sekali untuk cek nilai, terima kasih!'
        ]);

        Feedback::create([
            'nama'  => 'Pak Joko Guru',
            'email' => 'joko.guru@example.com',
            'pesan' => 'Mohon ditambah fitur rekap presensi.'
        ]);

        // Data faker (butuh factory)
        Feedback::factory()
            ->count(20)
            ->create();
    }
}
