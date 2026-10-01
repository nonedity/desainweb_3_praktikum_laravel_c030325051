<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;

class StatistikMahasiswaController extends Controller
{
    /**
     * Handle the incoming request (Praktikum 3: Single Action / Invokable Controller).
     */
    public function __invoke()
    {
        $total = Mahasiswa::count();
        $perProdi = Mahasiswa::selectRaw('prodi, count(*) as jumlah')
                             ->groupBy('prodi')
                             ->get();

        return view('statistik', compact('total', 'perProdi'));
    }
}
