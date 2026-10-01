@extends('layouts.app')

@section('judul', 'Dashboard Administrator')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Admin Dashboard</h1>
            <p class="page-subtitle">Demonstrasi Nested Controller di Sub-folder <code>app/Http/Controllers/Admin/DashboardController.php</code> (Praktikum 3 Langkah Kerja 5)</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('laporan.rekap') }}" class="btn btn-secondary">Lihat Rekap Laporan &rarr;</a>
        </div>
    </div>

    <!-- Alert Edukasi Nested Controller -->
    <div class="card" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(14, 165, 233, 0.05)); border-color: rgba(79, 70, 229, 0.2); margin-bottom: 24px;">
        <h4 style="color: var(--primary); font-size: 1rem; margin-bottom: 8px;">📁 Konsep Nested / Sub-Namespace Controller</h4>
        <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 8px;">
            Untuk memisahkan logika aplikasi berskala besar (seperti area Admin, API v1, atau Laporan), controller diorganisasikan ke dalam sub-folder. Controller ini menggunakan namespace <code>App\Http\Controllers\Admin</code> dan meng-extend <code>App\Http\Controllers\Controller</code>.
        </p>
        <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
            File: <code>app/Http/Controllers/Admin/DashboardController.php</code> &bull; Rute: <code>Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');</code>
        </p>
    </div>

    <!-- Stats Grid -->
    <div class="grid-3" style="margin-bottom: 24px;">
        <div class="card stat-card">
            <div class="stat-icon" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                👨‍🎓
            </div>
            <div class="stat-value" style="color: var(--primary);">{{ $totalMahasiswa }}</div>
            <div class="stat-label">Total Mahasiswa</div>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-sm btn-outline-primary" style="margin-top: 14px; width: 100%;">Kelola Mahasiswa</a>
        </div>

        <div class="card stat-card">
            <div class="stat-icon" style="background: rgba(14, 165, 233, 0.1); color: var(--secondary);">
                📖
            </div>
            <div class="stat-value" style="color: var(--secondary);">{{ $totalMatakuliah }}</div>
            <div class="stat-label">Total Mata Kuliah</div>
            <a href="{{ route('matakuliah.index') }}" class="btn btn-sm btn-outline-secondary" style="margin-top: 14px; width: 100%;">Kelola Kurikulum</a>
        </div>

        <div class="card stat-card">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success);">
                📝
            </div>
            <div class="stat-value" style="color: var(--success);">{{ $totalNilai }}</div>
            <div class="stat-label">Total Nilai Mahasiswa</div>
            <a href="{{ route('demo.eloquent.eager') }}" class="btn btn-sm btn-outline-success" style="margin-top: 14px; width: 100%;">Inspeksi Relasi Nilai</a>
        </div>

    </div>

    <!-- Quick Actions & System Info -->
    <div class="grid-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">⚡ Pintasan Cepat Sistem</h3>
            </div>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary" style="text-align: left; display: block;">+ Daftarkan Mahasiswa Baru</a>
                <a href="{{ route('matakuliah.create') }}" class="btn btn-secondary" style="text-align: left; display: block;">+ Tambah Mata Kuliah Baru</a>
                <a href="{{ route('mahasiswa.cari') }}" class="btn btn-secondary" style="text-align: left; display: block;">🔍 Pencarian Mahasiswa Interaktif</a>
                <a href="{{ route('laporan.rekap') }}" class="btn btn-secondary" style="text-align: left; display: block;">📊 Rekap Laporan Eksekutif</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">⚙️ Informasi Environment Laravel 13</h3>
            </div>
            <table class="custom-table" style="font-size: 0.88rem;">
                <tbody>
                    <tr>
                        <th>Laravel Framework</th>
                        <td><code>v{{ app()->version() }}</code></td>
                    </tr>
                    <tr>
                        <th>PHP Version</th>
                        <td><code>{{ PHP_VERSION }}</code></td>
                    </tr>
                    <tr>
                        <th>Database Driver</th>
                        <td><code>{{ config('database.default') }} (SQLite)</code></td>
                    </tr>
                    <tr>
                        <th>Environment</th>
                        <td><span class="badge badge-success">{{ app()->environment() }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
