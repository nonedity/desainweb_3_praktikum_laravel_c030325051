@extends('layouts.app')

@section('judul', 'Agregasi Data Mahasiswa via Query Builder')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Agregasi Query Builder: DB::raw &amp; groupBy</h1>
            <p class="page-subtitle">Demonstrasi Praktikum 5 Langkah Kerja 4 &amp; Tugas Mandiri No. 2</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('demo.qb.all') }}" class="btn btn-secondary">&laquo; Kembali ke Demo QB</a>
            <a href="{{ route('demo.qb.paginasi') }}" class="btn btn-primary">Demo Paginasi QB &rarr;</a>
        </div>

    </div>

    <!-- Alert Edukasi Query Builder Aggregation -->
    <div class="card" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(14, 165, 233, 0.05)); border-color: rgba(79, 70, 229, 0.2); margin-bottom: 24px;">
        <h4 style="color: var(--primary); font-size: 1rem; margin-bottom: 8px;">💡 Query Agregasi dengan DB::raw()</h4>
        <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 8px;">
            Untuk menjalankan fungsi agregat kompleks SQL (seperti <code>count(*)</code>, <code>min()</code>, <code>max()</code>, atau <code>avg()</code>) yang digabungkan dengan <code>groupBy()</code>, Laravel menyediakan method <code>DB::raw()</code> di dalam klausa <code>select()</code>.
        </p>
        <div class="query-box">
            <pre style="margin: 0; color: #cbd5e1; font-family: monospace; font-size: 0.85rem;">
$rekap = DB::table('mahasiswas')
    ->select('prodi', 
        DB::raw('count(*) as jumlah'), 
        DB::raw('min(semester) as min_semester'), 
        DB::raw('max(semester) as max_semester')
    )
    ->groupBy('prodi')
    ->get();</pre>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📊 Hasil Agregasi Mahasiswa per Program Studi</h3>
            <span class="badge badge-primary">{{ $rekap->count() }} Program Studi</span>
        </div>

        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Program Studi</th>
                        <th>Total Mahasiswa (count)</th>
                        <th>Semester Terendah (min)</th>
                        <th>Semester Tertinggi (max)</th>
                        <th>Rentang Angkatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekap as $item)
                        <tr class="{{ $loop->even ? 'baris-genap' : 'baris-ganjil' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td><strong style="color: var(--primary); font-size: 1rem;">{{ $item->prodi }}</strong></td>
                            <td><span class="badge badge-info">{{ $item->jumlah }} Mahasiswa</span></td>
                            <td>Semester {{ $item->min_semester }}</td>
                            <td>Semester {{ $item->max_semester }}</td>
                            <td>
                                <span class="badge badge-secondary">
                                    Semester {{ $item->min_semester }} s/d {{ $item->max_semester }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 24px; color: var(--text-muted);">
                                Belum ada data agregasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
