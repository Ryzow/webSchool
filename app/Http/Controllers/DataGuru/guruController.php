<?php

namespace App\Http\Controllers\DataGuru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'nama');
        $direction = $request->get('direction', 'asc');
        $search = $request->get('search');

        $allowedSorts = ['nama', 'nip', 'mapel_id'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'nama';
        }

        if (!in_array(strtolower($direction), ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $query = Guru::with('mapel');
        $mapels = Mapel::all();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nip', 'like', '%' . $search . '%');
            });
        }

        $gurus = $query->orderBy($sort, $direction)->paginate(10)->withQueryString();


        $kelasMapelGuru = null;
        if (session('guru_id')) {
            $kelasMapelGuru = DB::table('kelas_mapel_guru')
                ->where('guru_id', session('guru_id'))
                ->join('kelas', 'kelas.id', '=', 'kelas_mapel_guru.kelas_id')
                ->join('mapels', 'mapels.id', '=', 'kelas_mapel_guru.mapel_id')
                ->select('kelas.nama as kelas_nama', 'kelas.id as kelas_id', 'mapels.nama as mapel_nama', 'mapels.id as mapel_id')
                ->get()
                ->map(function ($item) {
                    return (object)[
                        'kelas' => (object)['id' => $item->kelas_id, 'nama' => $item->kelas_nama],
                        'mapel' => (object)['id' => $item->mapel_id, 'nama' => $item->mapel_nama],
                    ];
                });
        }

        return view('school.guru.guru', compact('gurus', 'sort', 'direction', 'mapels', 'kelasMapelGuru'));
    }

    public function create()
    {
        $mapels = Mapel::all();
        return view('school.guru.create', compact('mapels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:gurus,nip',
            'mapel_id' => 'required|exists:mapels,id',
            'jk' => 'required|in:Laki-laki,Perempuan',
            'password' => 'required|string|min:4',
            'mengajar_sejak' => 'nullable|numeric|min:2000|max:' . date('Y'),
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('foto', 'public');
            $validated['foto'] = basename($foto);
        }

        Guru::create($validated);
        return redirect()->route('guru.index')->with('success', 'Guru berhasil ditambahkan');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        $mapels = Mapel::all();
        return view('school.guru.edit', compact('guru', 'mapels'));
    }

    public function update(Request $request, $id)
{
    $guru = Guru::findOrFail($id);

    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'nip' => 'required|string|unique:gurus,nip,' . $guru->id,
        'mapel_id' => 'required|exists:mapels,id',
        'jk' => 'required|in:Laki-laki,Perempuan',
        'password' => 'nullable|string|min:4',
        'mengajar_sejak' => 'nullable|numeric|min:2000|max:' . date('Y'),
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Hash password jika diisi
    if ($request->filled('password')) {
        $validated['password'] = bcrypt($request->input('password'));
    } else {
        unset($validated['password']); // Jangan ubah jika kosong
    }

    // Simpan foto jika ada
    if ($request->hasFile('foto')) {
        $foto = $request->file('foto')->store('foto', 'public');
        $validated['foto'] = basename($foto);
    }

    $guru->update($validated);

    return redirect()->route('guru.index')->with('success', 'Guru berhasil diupdate');
}

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Guru berhasil dihapus');
    }

    public function login(Request $request)
    {
        $login = $request->input('login');
        $password = $request->input('password');

        // Cek sebagai admin dulu
        $admin = Admin::where('username', $login)->first();
        if ($admin && Hash::check($password, $admin->password)) {
            session(['admin_id' => $admin->id, 'admin_nama' => $admin->nama]);
            return redirect()->route('guru.index')->with('success', 'Login Admin berhasil');
        }

        // Kalau bukan admin, cek sebagai guru
        $guru = Guru::where('nama', $login)->orWhere('nip', $login)->first();
        if ($guru && Hash::check($password, $guru->password)) {
            session([
                'guru_id' => $guru->id,
                'guru_nama' => $guru->nama,
                'guru_foto' => $guru->foto,
                'guru_sejak' => $guru->mengajar_sejak
            ]);
            return redirect()->route('guru.index')->with('success', 'Login Guru berhasil');
        }

        return redirect()->back()->with('login_error', 'Login gagal');
    }

    public function logout()
    {
        session()->forget(['guru_id', 'guru_nama', 'guru_foto', 'guru_sejak', 'admin_id', 'admin_nama']);
        return redirect()->route('guru.index');
    }
}
