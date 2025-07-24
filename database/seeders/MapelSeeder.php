<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mapel;
use Illuminate\Support\Facades\DB;  // Jangan lupa import DB

class MapelSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Mapel::truncate();

        // Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $mapelNames = [
            'Matematika',
            'Fisika',
            'Kimia',
            'Biologi',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Sejarah',
            'Geografi',
            'Ekonomi',
            'Seni Budaya',
            'Pendidikan Jasmani',
            'TIK',
        ];

        $tingkatanList = ['10', '11', '12'];

        foreach ($mapelNames as $namaMapel) {
            foreach ($tingkatanList as $tingkatan) {

                $words = explode(' ', $namaMapel);
                $initials = '';

                foreach ($words as $w) {
                    $initials .= strtoupper(substr($w, 0, 1));
                }

                if (count($words) === 1) {
                    $kodeAwal = strtoupper(substr($namaMapel, 0, 3));
                } else {
                    $kodeAwal = strtoupper(substr($initials, 0, 3));
                }

                $kode = $kodeAwal . $tingkatan;

                Mapel::create([
                    'nama' => $namaMapel,
                    'kode' => $kode,
                    'tingkatan' => $tingkatan,
                ]);
            }
        }
    }
}
