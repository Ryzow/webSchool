<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan Mapel tersedia
        if (Mapel::count() === 0) {
            Mapel::insert([
                ['nama' => 'Matematika', 'kode' => 'MAT10', 'tingkatan' => '10'],
                ['nama' => 'Bahasa Indonesia', 'kode' => 'BINDO11', 'tingkatan' => '11'],
                ['nama' => 'Fisika', 'kode' => 'FIS12', 'tingkatan' => '12'],
                ['nama' => 'Kimia', 'kode' => 'KIM11', 'tingkatan' => '11'],
                ['nama' => 'Biologi', 'kode' => 'BIO12', 'tingkatan' => '12'],
                ['nama' => 'Sejarah', 'kode' => 'SEJ10', 'tingkatan' => '10'],
                ['nama' => 'Sosiologi', 'kode' => 'SOS11', 'tingkatan' => '11'],
            ]);
        }

        $mapels = Mapel::pluck('id')->toArray();
        $names = [
            'Ahmad', 'Siti', 'Budi', 'Ayu', 'Joko', 'Rina', 'Bayu', 'Dewi', 'Rudi', 'Ani',
            'Fajar', 'Linda', 'Agus', 'Nina', 'Eko', 'Tari', 'Dani', 'Yuni', 'Rahmat', 'Tina',
            'Hendra', 'Putri', 'Iqbal', 'Maya', 'Ardi', 'Desi', 'Andi', 'Vina', 'Hadi', 'Lina'
        ];
        $gender = ['Laki-laki', 'Perempuan'];

        foreach ($names as $i => $nama) {
            Guru::create([
                'nama' => $nama . ' ' . Str::random(5),
                'nip' => '1980' . str_pad((string)($i + 1), 4, '0', STR_PAD_LEFT),
                'mapel_id' => $mapels[array_rand($mapels)],
                'jk' => $gender[$i % 2],
                'password' => Hash::make('12345'), // default password
                'mengajar_sejak' => rand(2005, date('Y')),
                'foto' => null // bisa isi 'default.jpg' jika perlu
            ]);
        }
    }
}
