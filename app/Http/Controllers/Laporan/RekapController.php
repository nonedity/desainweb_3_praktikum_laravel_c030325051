<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    /**
     * Praktikum 3 Tugas Mandiri:
     * Controller di dalam sub-folder Laporan/ (Laporan/RekapController)
     */
    public function index()
    {
        // Rekap per prodi
        $rekapProdi = DB::table('mahasiswas')
            ->select('prodi', DB::raw('count(*) as total_mhs'), DB::raw('avg(semester) as rata_semester'))
            ->groupBy('prodi')
            ->get();

        // Rekap mata kuliah per semester
        $rekapMatkul = DB::table('matakuliahs')
            ->select('semester', DB::raw('count(*) as total_mk'), DB::raw('sum(sks) as total_sks'))
            ->groupBy('semester')
            ->orderBy('semester')
            ->get();

        return view('laporan.rekap', compact('rekapProdi', 'rekapMatkul'));
    }
}
