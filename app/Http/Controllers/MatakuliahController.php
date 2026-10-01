<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    /**
     * Display a listing of the resource (Praktikum 3 & 7).
     */
    public function index(Request $request)
    {
        $query = Matakuliah::query();

        if ($request->filled('cari')) {
            $keyword = $request->cari;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_mk', 'like', "%{$keyword}%")
                  ->orWhere('kode_mk', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $matakuliah = $query->withCount('nilai')->orderBy('kode_mk')->paginate(10)->withQueryString();

        return view('matakuliah.index', compact('matakuliah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('matakuliah.create');
    }

    /**
     * Store a newly created resource in storage using Eloquent (Praktikum 7 Tugas Mandiri).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mk' => 'required|string|max:20|unique:matakuliahs,kode_mk',
            'nama_mk' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:8',
            'semester' => 'required|integer|min:1|max:8',
            'dosen_pengampu' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Matakuliah::create($validated);

        return redirect()->route('matakuliah.index')->with('pesan', 'Mata kuliah baru berhasil ditambahkan melalui Eloquent ORM!');
    }

    /**
     * Display the specified resource using Route Model Binding.
     * Praktikum 7 Tugas Mandiri No. 2: Menampilkan daftar mahasiswa yang mengambil mata kuliah ini via relasi.
     */
    public function show(Matakuliah $matakuliah)
    {
        // Eager load relasi nilai beserta data mahasiswanya
        $matakuliah->load('nilai.mahasiswa');

        return view('matakuliah.show', compact('matakuliah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matakuliah $matakuliah)
    {
        return view('matakuliah.edit', compact('matakuliah'));
    }

    /**
     * Update the specified resource in storage using Eloquent.
     */
    public function update(Request $request, Matakuliah $matakuliah)
    {
        $validated = $request->validate([
            'kode_mk' => 'required|string|max:20|unique:matakuliahs,kode_mk,' . $matakuliah->id,
            'nama_mk' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:8',
            'semester' => 'required|integer|min:1|max:8',
            'dosen_pengampu' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $matakuliah->update($validated);

        return redirect()->route('matakuliah.index')->with('pesan', 'Data mata kuliah berhasil diperbarui melalui Eloquent ORM!');
    }

    /**
     * Remove the specified resource from storage using Eloquent.
     */
    public function destroy(Matakuliah $matakuliah)
    {
        $matakuliah->delete();

        return redirect()->route('matakuliah.index')->with('pesan', 'Mata kuliah berhasil dihapus melalui Eloquent ORM!');
    }
}
