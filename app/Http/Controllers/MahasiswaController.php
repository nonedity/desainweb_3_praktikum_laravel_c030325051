<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource (Praktikum 3, 6, 7).
     */
    public function index(Request $request)
    {
        $query = Mahasiswa::query();

        // Fitur pencarian kata kunci nama atau NIM
        if ($request->filled('cari')) {
            $keyword = $request->cari;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('nim', 'like', "%{$keyword}%");
            });
        }

        // Fitur filter berdasarkan Program Studi
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        // Fitur filter berdasarkan Semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Eager load relasi nilai untuk mencegah N+1 problem (Praktikum 7)
        $mahasiswa = $query->with('nilai.matakuliah')->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage (Praktikum 2 & 7).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswas,nim',
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'prodi' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        // Praktikum 7: Menggunakan Eloquent ::create()
        Mahasiswa::create($validated);

        return redirect()->route('mahasiswa.index')->with('pesan', 'Data mahasiswa berhasil ditambahkan melalui Eloquent ORM!');
    }

    /**
     * Display the specified resource using Route Model Binding (Praktikum 3, 6, 7).
     */
    public function show(Mahasiswa $mahasiswa)
    {
        // Praktikum 7: Eager load relasi nilai beserta data matakuliahnya
        $mahasiswa->load('nilai.matakuliah');

        return view('mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    /**
     * Update the specified resource in storage using Eloquent (Praktikum 7).
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswas,nim,' . $mahasiswa->id,
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'prodi' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        $mahasiswa->update($validated);

        return redirect()->route('mahasiswa.index')->with('pesan', 'Data mahasiswa berhasil diperbarui melalui Eloquent ORM!');
    }

    /**
     * Remove the specified resource from storage using Eloquent (Praktikum 7).
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')->with('pesan', 'Data mahasiswa berhasil dihapus melalui Eloquent ORM!');
    }

    /**
     * Praktikum 2: Mengembalikan response dalam bentuk JSON
     */
    public function apiIndex()
    {
        $mahasiswa = Mahasiswa::all();

        return response()->json([
            'status' => 'sukses',
            'total' => $mahasiswa->count(),
            'pesan' => 'Ini adalah contoh response JSON dari Controller (Praktikum 2)',
            'data' => $mahasiswa,
        ]);
    }

    /**
     * Praktikum 2 Tugas Mandiri:
     * Method pencarian mahasiswa melalui query string (?nama=...)
     */
    public function cariMahasiswa(Request $request)
    {
        $kataKunci = $request->query('nama') ?? $request->query('keyword');

        if (empty($kataKunci)) {
            $hasil = collect([]);
            $pesan = 'Silakan masukkan nama mahasiswa pada kotak pencarian.';
        } else {
            $hasil = Mahasiswa::where('nama', 'like', "%{$kataKunci}%")->get();
            $pesan = "Hasil pencarian mahasiswa dengan kata kunci: '{$kataKunci}' (Ditemukan: {$hasil->count()} data).";
        }

        return view('mahasiswa.cari', compact('kataKunci', 'hasil', 'pesan'));
    }


    /**
     * Praktikum 2: Method store sederhana untuk pengujian form uji
     */
    public function storeUji(Request $request)
    {
        $nama = $request->input('nama');
        $nim  = $request->input('nim');

        return "Data yang diterima via Request -> NIM: {$nim}, Nama: {$nama} (Berhasil diverifikasi dengan proteksi @csrf).";
    }
}
