<?php
// database/seeders/KegiatanSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kegiatan;
use Carbon\Carbon;

class kegiatanSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh data statis
        $kegiatanTetap = [
            [
                'nama'       => 'Peringatan Hari Guru Nasional',
                'tanggal'    => Carbon::create(2025, 11, 25),
                'deskripsi'  => 'Upacara bendera dan pemberian penghargaan guru berprestasi.'
            ],
            [
                'nama'       => 'Lomba 17 Agustus',
                'tanggal'    => Carbon::create(2025, 8, 17),
                'deskripsi'  => 'Berbagai perlombaan antar‑kelas menyambut HUT RI.'
            ],
        ];

        foreach ($kegiatanTetap as $k) {
            Kegiatan::create($k);
        }

        // Tambahan data acak
        \App\Models\Kegiatan::factory()
            ->count(8)          // total 8 kegiatan acak
            ->create();
    }
}
