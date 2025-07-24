<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Guru;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $tingkatans = ['10', '11', '12'];
        $jurusans = ['IPA', 'IPS'];
        $paralel = ['1', '2', '3'];
        $tahunAjaran = date('Y') . '/' . (date('Y') + 1);

        $guruIds = Guru::pluck('id')->toArray();
        $guruIndex = 0;

        foreach ($tingkatans as $tingkatan) {
            foreach ($jurusans as $jurusan) {
                foreach ($paralel as $p) {
                    Kelas::create([
                        'nama' => "{$tingkatan} {$jurusan} {$p}",
                        'tingkatan' => $tingkatan,
                        'jurusan' => $jurusan,
                        'tahun_ajaran' => $tahunAjaran,
                        'wali_kelas_id' => $guruIds[$guruIndex % count($guruIds)],
                    ]);
                    $guruIndex++;
                }
            }
        }
    }
}
