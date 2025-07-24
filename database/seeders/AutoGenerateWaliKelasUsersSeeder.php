<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\WaliKelasUser;
use Illuminate\Support\Facades\Hash;

class AutoGenerateWaliKelasUsersSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = Kelas::with('wali_kelas')->get();

        foreach ($kelas as $k) {
            if ($k->wali_kelas && !WaliKelasUser::where('guru_id', $k->wali_kelas->id)->exists()) {
                WaliKelasUser::create([
                    'username' => strtolower(str_replace(' ', '', $k->wali_kelas->nama)),
                    'password' => Hash::make('password123'),
                    'guru_id' => $k->wali_kelas->id,
                ]);
            }
        }
    }
}
