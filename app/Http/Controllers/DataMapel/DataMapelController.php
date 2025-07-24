<?php

namespace App\Http\Controllers\DataMapel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;

class DataMapelController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'nama');
        $direction = $request->get('direction', 'asc');
        $search = $request->get('search');

        $allowedSorts = ['nama', 'kode', 'tingkatan'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'nama';
        }

        if (!in_array(strtolower($direction), ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $query = Mapel::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                ->orWhere('kode', 'like', '%' . $search . '%');
            });
        }

        $mapels = $query->orderBy($sort, $direction)->paginate(10)->withQueryString();

        return view('school.mapel.mapel', compact('mapels', 'sort', 'direction'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:255|unique:mapels,kode',
            'tingkatan' => 'required|string|in:10,11,12',
        ]);

        $validated['kode']= strtoupper($validated['kode']).$validated['tingkatan'];

        Mapel::create($validated);

        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil ditambahkan');
    }

    public function create()
    {
        return view('school.mapel.create');
    }

    public function edit($id)
    {
        $mapel = Mapel::findOrFail($id);
        return view('school.mapel.edit', compact('mapel'));
    }

    public function update(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'tingkatan' => 'required|string|in:10,11,12',
        ]);


        $mapel->update($validated);

        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil diupdate');
    }


    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->delete();

        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil dihapus');
    }
}
