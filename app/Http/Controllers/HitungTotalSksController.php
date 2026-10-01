<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;

class HitungTotalSksController extends Controller
{
    /**
     * Handle the incoming request (Praktikum 3 Tugas Mandiri: Invokable Controller).
     * Menghitung dan menampilkan jumlah total SKS dari seluruh mata kuliah di database.
     */
    public function __invoke()
    {
        $totalSks = Matakuliah::sum('sks');
        $jumlahMatakuliah = Matakuliah::count();
        $rataSks = Matakuliah::avg('sks');

        return view('matakuliah.total-sks', compact('totalSks', 'jumlahMatakuliah', 'rataSks'));
    }
}
