<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\NilaiMatakuliah;

class DashboardController extends Controller
{
    /**
     * Praktikum 3: Controller di dalam sub-folder (Nested Controller: Admin/DashboardController)
     */
    public function index()
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalMatakuliah = Matakuliah::count();
        $totalNilai = NilaiMatakuliah::count();

        return view('admin.dashboard', compact('totalMahasiswa', 'totalMatakuliah', 'totalNilai'));
    }
}
