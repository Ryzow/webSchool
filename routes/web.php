
<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\bookCatalogueController;
use App\Http\Controllers\bookController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\Dashboard\dashboardController;
use App\Http\Controllers\DataGuru\GuruController;
use App\Http\Controllers\DataMapel\DataMapelController;
use App\Http\Controllers\DataKelas\dataKelasController;
use App\Http\Controllers\DataSiswa\dataSiswaController;
use App\Http\Controllers\User\NilaiSayaController;
use App\Http\Controllers\NilaiController;
use App\Http\Middleware\NoLogin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\DataKegiatan\KegiatanController;
use Illuminate\Support\Facades\DB;





Route::get('/', function () {
    return view('screen.home');
});

Route::middleware([NoLogin::class])->group(function(){
    Route::controller(authController::class)->group(function(){

        Route::get('/login', 'index_login')->name('login');
        Route::post('/login', 'store_login');


        Route::get('/register', 'index_register');
        Route::post('/register', 'store_register');

    });
});


Route::get('/book', [bookCatalogueController::class, 'index']);

Route::middleware(['auth', 'cekRole:admin,user'])->group(function(){

     Route::get('/logout', [authController::class, '_logout']);


     Route::controller(categoryController::class)->group(function(){

        Route::get('/category', 'index');
        Route::post('/category', 'store');
        Route::put('/category/{id}', 'update');
        Route::delete('/category/{id}', 'destroy');


    });

    Route::controller(bookController::class)->group(function(){

        Route::get('/books', 'index');

        Route::get('/books/add', 'create');
        Route::post('/books/add', 'store');
        Route::delete('/books/{id}', 'destroy');

        Route::get('/books/edit/{id}', 'edit');
        Route::put('/books/edit/{id}', 'update');
    });
});

Route::resource('/data/mapel', DataMapelController::class)->names('mapel');
Route::resource('/data/guru', GuruController::class)->names('guru');
Route::resource('/data/kelas', dataKelasController::class)->names('kelas');
Route::resource('/data/siswa', dataSiswaController::class)->names('siswa');

Route::middleware(['auth'])->group(function () {
    Route::get('/user/nilai', [NilaiSayaController::class, 'index'])->name('nilai');
});

Route::resource('/dashboard', dashboardController::class)->names('dashboard');



Route::get('/data/guru', [GuruController::class, 'index'])->name('guru.index');
Route::post('/data/guru/login', [GuruController::class, 'login'])->name('guru.login');
Route::post('/data/guru/logout', [GuruController::class, 'logout'])->name('guru.logout');


Route::post('/guru-relasi', function (Illuminate\Http\Request $request) {
    $request->validate([
        'guru_id' => 'required|exists:gurus,id',
        'mapel_id' => 'required|exists:mapels,id',
        'kelas_id' => 'required|exists:kelas,id',
    ]);

    $exists = DB::table('kelas_mapel_guru')
        ->where('mapel_id', $request->mapel_id)
        ->where('kelas_id', $request->kelas_id)
        ->exists();

    if ($exists) {
        return back()->with('login_error', 'Mapel ini sudah diajar oleh guru lain di kelas tersebut.');
    }

    DB::table('kelas_mapel_guru')->insert([
        'guru_id' => $request->guru_id,
        'mapel_id' => $request->mapel_id,
        'kelas_id' => $request->kelas_id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return back()->with('success', 'Relasi guru – kelas – mapel berhasil ditambahkan');
})->name('guru.relasimapel');

Route::middleware('auth')->group(function () {
    Route::get('/nilai/kelola/{kelas}/{mapel}', [NilaiController::class, 'kelola'])->name('nilai.kelola');
    Route::post('/nilai/kelola/{kelas}/{mapel}', [NilaiController::class, 'simpan'])->name('nilai.simpan');
});
Route::resource('/kegiatan', KegiatanController::class)->names('kegiatan');
Route::resource('admin/feedback', \App\Http\Controllers\Admin\FeedbackController::class)->names('feedback');


Route::get('/user/nilai', [NilaiSayaController::class, 'index'])->name('user.nilai.index');
Route::post('/user/nilai', [NilaiSayaController::class, 'cari'])->name('user.nilai.cari');
