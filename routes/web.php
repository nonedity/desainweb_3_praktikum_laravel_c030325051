<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\EagerLoadingDemoController;
use App\Http\Controllers\HitungTotalSksController;
use App\Http\Controllers\Laporan\RekapController;
use App\Http\Controllers\LatihanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\QueryBuilderDemoController;
use App\Http\Controllers\SapaController;
use App\Http\Controllers\StatistikMahasiswaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Modul Praktikum Laravel 13
| Controller serta Interaksi Database dengan Query Builder & Eloquent
|--------------------------------------------------------------------------
*/

// =========================================================================
// BERANDA / PORTAL UTAMA
// =========================================================================
Route::get('/', function () {
    return view('beranda');
})->name('home');


// =========================================================================
// PRAKTIKUM 1: KONSEP CONTROLLER DALAM FRAMEWORK
// =========================================================================
// 1. Route dengan Closure sederhana
Route::get('/sapa-closure', function () {
    $nama = 'Ahmad Fauzi';
    return "Halo, {$nama}! Ini adalah response yang ditulis langsung di dalam Closure Route (Praktikum 1).";
})->name('sapa.closure');

// 2. Route yang mengarah ke Controller
Route::get('/sapa-controller', [SapaController::class, 'index'])->name('sapa.controller');
Route::get('/sapa/{nama?}', [SapaController::class, 'index'])->name('sapa.nama');

// 3. Tugas Mandiri 1: LatihanController perkenalan diri
Route::get('/latihan-controller', [LatihanController::class, 'index'])->name('latihan.controller');
Route::get('/latihan/halo', [LatihanController::class, 'halo'])->name('latihan.halo');
Route::get('/latihan/profil', [LatihanController::class, 'profil'])->name('latihan.profil');


// =========================================================================
// PRAKTIKUM 2: PENULISAN CONTROLLER DALAM FRAMEWORK
// =========================================================================
// Form uji pengiriman data Request sederhana dengan proteksi @csrf
Route::get('/mahasiswa-uji', function () {
    return view('mahasiswa.form-uji');
})->name('mahasiswa.uji.form');
Route::get('/mahasiswa/form-uji', function () {
    return view('mahasiswa.form-uji');
})->name('mahasiswa.formUji');

Route::post('/mahasiswa-uji', [MahasiswaController::class, 'storeUji'])->name('mahasiswa.uji.store');
Route::post('/mahasiswa/form-uji', [MahasiswaController::class, 'storeUji']);

// Response dalam format JSON dari Controller
Route::get('/api/mahasiswa', [MahasiswaController::class, 'apiIndex'])->name('mahasiswa.api');

// Tugas Mandiri 2: Form & Method pencarian mahasiswa via query string (?nama=...)
Route::get('/mahasiswa/cari', [MahasiswaController::class, 'cariMahasiswa'])->name('mahasiswa.cari');


// =========================================================================
// PRAKTIKUM 3: PEMBUATAN CONTROLLER (Invokable & Sub-folder)
// =========================================================================
// 1. Single action controller (Invokable) Statistik Mahasiswa
Route::get('/statistik', StatistikMahasiswaController::class)->name('statistik.mahasiswa');
Route::get('/statistik-mahasiswa', StatistikMahasiswaController::class)->name('statistik');

// 2. Tugas Mandiri 3: Single action controller Hitung Total SKS
Route::get('/matakuliah-total-sks', HitungTotalSksController::class)->name('matakuliah.total-sks');

// 3. Controller di dalam sub-folder Admin/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

// 4. Tugas Mandiri 3: Controller di dalam sub-folder Laporan/
Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/rekap', [RekapController::class, 'index'])->name('rekap');
});


// =========================================================================
// PRAKTIKUM 4 & 5: QUERY BUILDER (DB::table())
// =========================================================================
Route::prefix('demo/query-builder')->name('demo.qb.')->group(function () {
    // Praktikum 4: Komparasi 3 pendekatan (Raw SQL, Query Builder, Eloquent) + Query Log
    Route::get('/komparasi', [QueryBuilderDemoController::class, 'komparasiPendekatan'])->name('komparasi');

    // Praktikum 5: Tampilkan semua data via Query Builder
    Route::get('/semua', [QueryBuilderDemoController::class, 'tampilkanSemua'])->name('all');

    // Praktikum 5: Filter kondisional
    Route::get('/filter', [QueryBuilderDemoController::class, 'tampilkanFilter'])->name('filter');

    // Praktikum 5 Tugas Mandiri 1: Filter Prodi TI & Semester 3-6 dengan whereBetween
    Route::get('/tugas-mandiri-filter', [QueryBuilderDemoController::class, 'tugasMandiriFilter'])->name('mandiri.filter');

    // Praktikum 5 Langkah 4 & Tugas Mandiri 2: Agregasi jumlah mahasiswa per prodi
    Route::get('/statistik-prodi', [QueryBuilderDemoController::class, 'statistikProdi'])->name('statistik');

    // Praktikum 5 Tugas Mandiri 3: Paginasi dengan Query Builder
    Route::get('/paginasi', [QueryBuilderDemoController::class, 'paginasiMahasiswa'])->name('paginasi');

    // Praktikum 5 Langkah 5: Operasi CRUD interaktif menggunakan Query Builder
    Route::get('/crud', [QueryBuilderDemoController::class, 'formCrud'])->name('crud');
    Route::post('/insert', [QueryBuilderDemoController::class, 'insertQueryBuilder'])->name('insert');
    Route::delete('/delete/{id}', [QueryBuilderDemoController::class, 'deleteQueryBuilder'])->name('delete');
});


// =========================================================================
// PRAKTIKUM 6 & 7: ELOQUENT ORM & EAGER LOADING
// =========================================================================
Route::prefix('demo/eloquent')->name('demo.eloquent.')->group(function () {
    // Praktikum 6: Komparasi objek stdClass vs Model Eloquent
    Route::get('/komparasi-objek', [EagerLoadingDemoController::class, 'komparasiObjek'])->name('objek');

    // Praktikum 7 & Proyek Akhir: Bukti Query Log N+1 Problem vs Eager Loading with()
    Route::get('/eager-loading', [EagerLoadingDemoController::class, 'komparasiEagerLoading'])->name('eager');
});


// =========================================================================
// PRAKTIKUM 3, 6, 7 & PROYEK AKHIR: RESOURCE ROUTE CRUD UTUH
// =========================================================================
// Resource Controller Mahasiswa (7 route RESTful standar)
Route::resource('mahasiswa', MahasiswaController::class);

// Resource Controller Matakuliah (7 route RESTful standar)
Route::resource('matakuliah', MatakuliahController::class);


// =========================================================================
// FALLBACK ROUTE: Penanganan 404 Kustom
// =========================================================================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
