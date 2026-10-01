@extends('layouts.app')

@section('judul', 'Statistik Mahasiswa (Invokable Controller)')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Statistik Mahasiswa per Program Studi</h1>
            <p class="page-subtitle">Demonstrasi Single Action / Invokable Controller (Praktikum 3 Langkah Kerja 4)</p>
        </div>
        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">&laquo; Kembali ke Data Mahasiswa</a>
    </div>

    <!-- Alert Edukasi Invokable Controller -->
    <div class="card" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(14, 165, 233, 0.05)); border-color: rgba(79, 70, 229, 0.2); margin-bottom: 24px;">
        <h4 style="color: var(--primary); font-size: 1rem; margin-bottom: 8px;">💡 Konsep Single Action (Invokable) Controller</h4>
        <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 8px;">
            Controller yang hanya memiliki satu aksi didefinisikan dengan method <code>__invoke()</code>. Pada file route, kita cukup mendaftarkan nama class controller tanpa menyebutkan method:
        </p>
        <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
            File: <code>app/Http/Controllers/StatistikMahasiswaController.php</code> &bull; Rute: <code>Route::get('/statistik-mahasiswa', StatistikMahasiswaController::class);</code>
        </p>
    </div>

    <div class="grid-3" style="align-items: flex-start; margin-bottom: 24px;">
        <!-- Card 1: Total Mahasiswa -->
        <div class="card stat-card" style="grid-column: span 1;">
            <div class="stat-icon" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                🎓
            </div>
            <div class="stat-value" style="color: var(--primary);">{{ $total }}</div>
            <div class="stat-label">Total Mahasiswa Terdaftar</div>
            <small style="color: var(--text-muted); font-size: 0.8rem; margin-top: 6px; display: block;">
                Hasil query: <code>Mahasiswa::count()</code>
            </small>
        </div>

        <!-- Card 2: Rincian Distribusi Prodi -->
        <div class="card" style="grid-column: span 2;">
            <div class="card-header">
                <h3 class="card-title">📊 Distribusi Mahasiswa per Program Studi</h3>
                <span class="badge badge-primary">{{ $perProdi->count() }} Program Studi</span>
            </div>

            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Program Studi</th>
                            <th>Jumlah Mahasiswa</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($perProdi as $item)
                            @php
                                $persen = $total > 0 ? round(($item->jumlah / $total) * 100, 1) : 0;
                            @endphp
                            <tr class="{{ $loop->even ? 'baris-genap' : 'baris-ganjil' }}">
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $item->prodi }}</strong></td>
                                <td><span class="badge badge-info">{{ $item->jumlah }} Mahasiswa</span></td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="flex: 1; height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                                            <div style="width: {{ $persen }}%; height: 100%; background: linear-gradient(90deg, var(--primary), var(--secondary)); border-radius: 4px;"></div>
                                        </div>
                                        <span style="font-size: 0.8rem; font-weight: 600; width: 45px; text-align: right;">{{ $persen }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 24px; color: var(--text-muted);">
                                    Belum ada data statistik mahasiswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
