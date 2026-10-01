<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EagerLoadingDemoController extends Controller
{
    /**
     * Praktikum 6: Perbandingan Objek stdClass (Query Builder) vs Model (Eloquent)
     */
    public function komparasiObjek()
    {
        $qbObj = DB::table('mahasiswas')->first();
        $elObj = Mahasiswa::with('nilai.matakuliah')->first();

        $qbClass = $qbObj ? get_class($qbObj) : 'null';
        $elClass = $elObj ? get_class($elObj) : 'null';

        return view('demo.komparasi-objek', compact('qbObj', 'elObj', 'qbClass', 'elClass'));
    }

    /**
     * Praktikum 7 Langkah Kerja 6 & Tugas Mandiri No. 3:
     * Bukti Perbandingan Query Log: Lazy Loading (N+1 Problem) vs Eager Loading (with())
     */
    public function komparasiEagerLoading(Request $request)
    {
        $mode = $request->query('mode', 'eager'); // default eager

        if ($mode === 'lazy') {
            // Skenario 1: TANPA with() (Menyebabkan N+1 Query Problem)
            DB::flushQueryLog();
            DB::enableQueryLog();

            $mahasiswa = Mahasiswa::take(10)->get();

            // Akses relasi di dalam loop tanpa eager loading
            $rekapNilai = [];
            foreach ($mahasiswa as $mhs) {
                $rekapNilai[$mhs->id] = $mhs->nilai->map(function ($n) {
                    return [
                        'matakuliah' => $n->matakuliah->nama_mk ?? '-',
                        'nilai' => $n->nilai,
                        'grade' => $n->grade,
                    ];
                });
            }

            $queryLogs = DB::getQueryLog();
            $totalQueries = count($queryLogs);
            $penjelasan = "Mode Lazy Loading: Dijalankan 1 query untuk mengambil mahasiswa, ditambah 1 query nilai dan 1 query matakuliah untuk SETIAP baris mahasiswa (N+1 problem). Total query membengkak menjadi {$totalQueries} query.";
        } else {
            // Skenario 2: DENGAN eager loading with('nilai.matakuliah')
            DB::flushQueryLog();
            DB::enableQueryLog();

            $mahasiswa = Mahasiswa::with('nilai.matakuliah')->take(10)->get();

            $rekapNilai = [];
            foreach ($mahasiswa as $mhs) {
                $rekapNilai[$mhs->id] = $mhs->nilai->map(function ($n) {
                    return [
                        'matakuliah' => $n->matakuliah->nama_mk ?? '-',
                        'nilai' => $n->nilai,
                        'grade' => $n->grade,
                    ];
                });
            }

            $queryLogs = DB::getQueryLog();
            $totalQueries = count($queryLogs);
            $penjelasan = "Mode Eager Loading with('nilai.matakuliah'): Hanya dijalankan 3 query SQL secara keseluruhan (1 untuk mahasiswa, 1 untuk semua nilai_matakuliahs terkait, 1 untuk semua matakuliahs terkait) berapa pun jumlah datanya! Total query tetap hemat: {$totalQueries} query.";
        }

        return view('demo.eager-loading', compact('mode', 'mahasiswa', 'rekapNilai', 'queryLogs', 'totalQueries', 'penjelasan'));
    }
}
