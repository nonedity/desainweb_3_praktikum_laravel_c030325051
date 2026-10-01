@extends('layouts.app')

@section('judul', 'Laporan Rekapitulasi Akademik')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Rekapitulasi Laporan Akademik</h1>
            <p class="page-subtitle">Demonstrasi Nested Controller di Sub-folder <code>app/Http/Controllers/Laporan/RekapController.php</code> (Praktikum 3 Tugas Mandiri)</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">&laquo; Dashboard Admin</a>
            <a href="{{ route('demo.qb.statistik') }}" class="btn btn-primary">Lihat Demo Agregasi QB &rarr;</a>
        </div>

    </div>

    <!-- Alert Edukasi Nested Controller Laporan -->
    <div class="card" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(14, 165, 233, 0.05)); border-color: rgba(79, 70, 229, 0.2); margin-bottom: 24px;">
        <h4 style="color: var(--primary); font-size: 1rem; margin-bottom: 8px;">📑 Sub-Folder Controller: Laporan\RekapController</h4>
        <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 8px;">
            Halaman ini memproses rekapitulasi data agregat mahasiswa per program studi dan rekapitulasi mata kuliah per semester menggunakan <code>DB::table()</code> dengan fungsi agregat SQL <code>count()</code>, <code>avg()</code>, dan <code>sum()</code>.
        </p>
        <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
            File: <code>app/Http/Controllers/Laporan/RekapController.php</code> &bull; Rute: <code>Route::get('/laporan/rekap', [App\Http\Controllers\Laporan\RekapController::class, 'index'])->name('laporan.rekap');</code>
        </p>
    </div>

    <div class="grid-2" style="align-items: flex-start; margin-bottom: 24px;">
        <!-- Tabel 1: Rekap Mahasiswa per Program Studi -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">👥 Rekap Mahasiswa per Prodi</h3>
                <span class="badge badge-primary">{{ $rekapProdi->count() }} Prodi</span>
            </div>

            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Program Studi</th>
                            <th>Total Mahasiswa</th>
                            <th>Rata-rata Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekapProdi as $p)
                            <tr class="{{ $loop->even ? 'baris-genap' : 'baris-ganjil' }}">
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $p->prodi }}</strong></td>
                                <td><span class="badge badge-info">{{ $p->total_mhs }} Orang</span></td>
                                <td>Semester {{ number_format($p->rata_semester, 1) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 20px; color: var(--text-muted);">
                                    Belum ada data rekap program studi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel 2: Rekap Mata Kuliah per Semester -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">📚 Rekap Kurikulum per Semester</h3>
                <span class="badge badge-success">{{ $rekapMatkul->count() }} Paket Semester</span>
            </div>

            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Semester</th>
                            <th>Jumlah Mata Kuliah</th>
                            <th>Total Beban SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekapMatkul as $m)
                            <tr class="{{ $loop->even ? 'baris-genap' : 'baris-ganjil' }}">
                                <td><span class="badge badge-primary">Semester {{ $m->semester }}</span></td>
                                <td><strong>{{ $m->total_mk }} Mata Kuliah</strong></td>
                                <td><span class="badge badge-info">{{ $m->total_sks }} SKS</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 20px; color: var(--text-muted);">
                                    Belum ada data rekap mata kuliah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
