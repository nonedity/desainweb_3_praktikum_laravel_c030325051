<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryBuilderDemoController extends Controller
{
    /**
     * Praktikum 4: Membandingkan 3 Pendekatan Database (Raw SQL, Query Builder, Eloquent)
     * beserta inspeksi Query Log.
     */
    public function komparasiPendekatan()
    {
        // 1. Raw SQL (Tugas Mandiri 4: filter prodi Teknik Informatika)
        DB::enableQueryLog();
        $rawSqlData = DB::select("SELECT * FROM mahasiswas WHERE prodi = ?", ['Teknik Informatika']);
        $rawSqlLog = DB::getQueryLog();

        // 2. Query Builder
        DB::flushQueryLog();
        $queryBuilderData = DB::table('mahasiswas')->where('prodi', 'Teknik Informatika')->get();
        $queryBuilderLog = DB::getQueryLog();

        // 3. Eloquent ORM (Tugas Mandiri 4: dengan where dan orderBy)
        DB::flushQueryLog();
        $eloquentData = Mahasiswa::where('prodi', 'Teknik Informatika')->orderBy('nama', 'asc')->get();
        $eloquentLog = DB::getQueryLog();

        return view('demo.komparasi-database', compact(
            'rawSqlData',
            'rawSqlLog',
            'queryBuilderData',
            'queryBuilderLog',
            'eloquentData',
            'eloquentLog'
        ));
    }

    /**
     * Praktikum 5: Tampilkan Semua Data Mahasiswa via Query Builder
     */
    public function tampilkanSemua()
    {
        $data = DB::table('mahasiswas')->get();
        $judul = 'Daftar Seluruh Mahasiswa (Query Builder: DB::table()->get())';

        return view('demo.query-builder', compact('data', 'judul'));
    }

    /**
     * Praktikum 5: Filter Kondisional
     */
    public function tampilkanFilter()
    {
        $data = DB::table('mahasiswas')
            ->where('semester', '>=', 3)
            ->orderBy('nama', 'asc')
            ->get();
        $judul = 'Filter Mahasiswa: Semester >= 3, Diurutkan Berdasarkan Nama';

        return view('demo.query-builder', compact('data', 'judul'));
    }

    /**
     * Praktikum 5 Tugas Mandiri No. 1:
     * prodi = 'Teknik Informatika' DAN semester antara 3 sampai 6, orderBy nama A-Z
     */
    public function tugasMandiriFilter()
    {
        DB::enableQueryLog();

        $data = DB::table('mahasiswas')
            ->where('prodi', 'Teknik Informatika')
            ->whereBetween('semester', [3, 6])
            ->orderBy('nama', 'asc')
            ->get();

        $queryLog = DB::getQueryLog();
        $judul = 'Tugas Mandiri 5 No. 1: Prodi Teknik Informatika, Semester 3 s/d 6 (whereBetween)';

        return view('demo.query-builder', compact('data', 'judul', 'queryLog'));
    }

    /**
     * Praktikum 5 Langkah Kerja 4 & Tugas Mandiri No. 2:
     * Agregasi jumlah mahasiswa per program studi
     */
    public function statistikProdi()
    {
        $rekap = DB::table('mahasiswas')
            ->select('prodi', DB::raw('count(*) as jumlah'), DB::raw('min(semester) as min_semester'), DB::raw('max(semester) as max_semester'))
            ->groupBy('prodi')
            ->get();

        return view('demo.statistik-prodi', compact('rekap'));
    }

    /**
     * Praktikum 5 Tugas Mandiri No. 3:
     * Pagination menggunakan Query Builder ->paginate(5)
     */
    public function paginasiMahasiswa()
    {
        // Pagination bawaan Query Builder
        $data = DB::table('mahasiswas')
            ->orderBy('id', 'asc')
            ->paginate(5);

        return view('demo.paginasi-query-builder', compact('data'));
    }

    /**
     * Praktikum 5 Langkah Kerja 5:
     * Form CRUD interaktif menggunakan Query Builder murni
     */
    public function formCrud()
    {
        $mahasiswa = DB::table('mahasiswas')->orderBy('id', 'desc')->get();
        return view('demo.crud-query-builder', compact('mahasiswa'));
    }

    public function insertQueryBuilder(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswas,nim',
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email',
            'prodi' => 'required|string',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        DB::table('mahasiswas')->insert([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'email' => $request->email,
            'prodi' => $request->prodi,
            'semester' => $request->semester,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('demo.qb.crud')->with('pesan', "Data mahasiswa {$request->nama} berhasil di-INSERT via DB::table('mahasiswas')->insert()!");
    }

    public function deleteQueryBuilder($id)
    {
        DB::table('mahasiswas')->where('id', $id)->delete();

        return redirect()->route('demo.qb.crud')->with('pesan', "Data mahasiswa (ID: {$id}) berhasil di-DELETE via DB::table('mahasiswas')->where()->delete()!");
    }
}
