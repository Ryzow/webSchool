<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Kelas;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $kelasList = Kelas::all();
        $namaLaki = ['Ahmad', 'Budi', 'Joko', 'Fajar', 'Rudi'];
        $namaPerempuan = ['Siti', 'Ayu', 'Dewi', 'Rina', 'Linda'];

        foreach ($kelasList as $kelas) {
            $tahunAjaran = match($kelas->tingkatan) {
                '10' => '2024/2025',
                '11' => '2023/2024',
                default => '2022/2023',
            };

            $tanggalLahir = match($kelas->tingkatan) {
                '10' => '2009-01-01',
                '11' => '2008-01-01',
                default => '2007-01-01',
            };

            for ($i = 1; $i <= 10; $i++) {
                $isMale = $i % 2 == 1;
                $nama = ($isMale ? $namaLaki[$i % count($namaLaki)] : $namaPerempuan[$i % count($namaPerempuan)]) . " $i";
                $jk = $isMale ? 'Laki-laki' : 'Perempuan';

                Siswa::create([
                    'nama' => $nama,
                    'nis' => '22' . str_pad($kelas->id . $i, 6, '0', STR_PAD_LEFT),
                    'jk' => $jk,
                    'kelas_id' => $kelas->id,
                    'tanggal_lahir' => $tanggalLahir,
                    'tahun_ajaran' => $tahunAjaran,
                ]);
            }
        }
    }
}
