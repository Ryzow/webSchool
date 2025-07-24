<?php

namespace App\Http\Controllers\DataSiswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class dataSiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $siswas = Siswa::with('kelas')
            ->when($search, fn($q) =>
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%')
            )
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        $kelases = Kelas::all();

        return view('school.siswa.siswa', compact('siswas', 'kelases'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:20|unique:siswas',
            'jk' => 'required|in:Laki-laki,Perempuan',
            'kelas_id' => 'nullable|exists:kelas,id',
            'tanggal_lahir' => 'required|date',
            'tahun_ajaran' => 'required|string'
        ]);

        Siswa::create($validated);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:20|unique:siswas,nis,' . $siswa->id,
            'jk' => 'required|in:Laki-laki,Perempuan',
            'kelas_id' => 'nullable|exists:kelas,id',
            'tanggal_lahir' => 'required|date',
            'tahun_ajaran' => 'required|string'
        ]);

        $siswa->update($validated);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus');
    }
}
