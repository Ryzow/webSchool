<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\siswa;
use App\Models\guru;
use App\Models\kelas;
use App\Models\mapel;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jumlahSiswa = siswa::count();
        $jumlahGuru = guru::count();
        $jumlahKelas = kelas::count();
        $jumlahMapel = mapel::count(); // jika kamu ingin pakai
        $chartData = [
            'labels' => ['Siswa', 'Guru', 'Kelas', 'Mapel'],
            'data' => [$jumlahSiswa, $jumlahGuru, $jumlahKelas, $jumlahMapel]
        ];

        return view('school.dashboard', compact('jumlahSiswa', 'jumlahGuru', 'jumlahKelas', 'jumlahMapel', 'chartData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
