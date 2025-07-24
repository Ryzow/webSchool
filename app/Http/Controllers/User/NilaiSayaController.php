<?php
// app/Http/Controllers/User/NilaiSayaController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Nilai;

class NilaiSayaController extends Controller
{
    public function index()
    {
        $kelasList = Kelas::orderBy('nama')->get();
        return view('school.user.nilai.index', compact('kelasList'));
    }

    public function cari(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'nama' => 'required|string'
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);
        $siswa = Siswa::where('kelas_id', $kelas->id)
                      ->where('nama', 'like', '%' . $request->nama . '%')
                      ->first();

        if (!$siswa) {
            return back()->with('error', 'Siswa tidak ditemukan di kelas ini.');
        }

        $nilais = Nilai::with('mapel')->where('siswa_id', $siswa->id)->get();

        return view('school.user.nilai.hasil', compact('siswa', 'kelas', 'nilais'));
    }
}
