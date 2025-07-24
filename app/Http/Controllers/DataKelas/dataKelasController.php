<?php

namespace App\Http\Controllers\DataKelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Guru;

class DataKelasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $kelas = Kelas::with(['wali_kelas', 'siswas'])
            ->when($search, function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        $gurus = Guru::all();

        // Statistik
        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        $totalAngkatan = Kelas::distinct('tingkatan')->count();
        $totalSiswaX = Siswa::whereHas('kelas', fn($q) => $q->where('tingkatan', 10))->count();
        $totalSiswaXI = Siswa::whereHas('kelas', fn($q) => $q->where('tingkatan', 11))->count();
        $totalSiswaXII = Siswa::whereHas('kelas', fn($q) => $q->where('tingkatan', 12))->count();


        return view('school.kelas.kelas', compact(
            'kelas', 'gurus',
            'totalSiswa', 'totalKelas', 'totalAngkatan',
            'totalSiswaX', 'totalSiswaXI', 'totalSiswaXII'
        ));

    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tingkatan' => 'required',
            'jurusan' => 'required',
            'tahun_ajaran' => 'required',
            'wali_kelas_id' => 'nullable|exists:gurus,id',
        ]);


        Kelas::create($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'tingkatan' => 'required',
            'jurusan' => 'required',
            'tahun_ajaran' => 'required',
            'wali_kelas_id' => 'nullable|exists:gurus,id',
        ]);


        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diupdate');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus');
    }
}
