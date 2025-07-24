<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function kelola($kelasId, $mapelId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        $mapel = Mapel::findOrFail($mapelId);
        $siswas = Siswa::where('kelas_id', $kelasId)->get();

        $nilaiMap = Nilai::whereIn('siswa_id', $siswas->pluck('id'))
            ->where('mapel_id', $mapelId)
            ->get()
            ->keyBy('siswa_id');

        return view('school.nilai.kelola', compact('kelas', 'mapel', 'siswas', 'nilaiMap'));
    }

    public function simpan(Request $request, $kelasId, $mapelId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        $mapel = Mapel::findOrFail($mapelId);
        foreach ($request->nilai as $siswaId => $nilaiInput) {
            Nilai::updateOrCreate(
                ['siswa_id' => $siswaId, 'mapel_id' => $mapel->id],
                [
                    'harian' => $nilaiInput['harian'] ?? null,
                    'tugas' => $nilaiInput['tugas'] ?? null,
                    'uts' => $nilaiInput['uts'] ?? null,
                    'uas' => $nilaiInput['uas'] ?? null,
                ]
            );
        }


        return redirect()->route('nilai.kelola', [$kelasId, $mapelId])->with('success', 'Nilai berhasil disimpan');
    }
}
