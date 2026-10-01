@extends('layouts.app')

@section('judul', 'Total SKS Mata Kuliah (Invokable Controller)')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Kalkulasi Total SKS Kurikulum</h1>
            <p class="page-subtitle">Demonstrasi Single Action / Invokable Controller (Praktikum 3 Tugas Mandiri)</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('matakuliah.index') }}" class="btn btn-secondary">&laquo; Lihat Semua Mata Kuliah</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Dashboard Admin</a>
        </div>
    </div>

    <!-- Alert Edukasi Invokable Controller -->
    <div class="card" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(14, 165, 233, 0.05)); border-color: rgba(79, 70, 229, 0.2); margin-bottom: 24px;">
        <h4 style="color: var(--primary); font-size: 1rem; margin-bottom: 8px;">💡 Konsep Invokable Controller</h4>
        <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 8px;">
            Controller ini diimplementasikan menggunakan <strong>Single Action Controller (Invokable)</strong> dengan method magic PHP <code>__invoke()</code>.
            Pendekatan ini sangat tepat untuk aksi controller yang hanya memiliki satu tanggung jawab tunggal tanpa memerlukan banyak method CRUD.
        </p>
        <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
            File Controller: <code>app/Http/Controllers/HitungTotalSksController.php</code> &bull; Rute: <code>Route::get('/matakuliah-total-sks', HitungTotalSksController::class);</code>
        </p>
    </div>

    <!-- Metric Cards -->
    <div class="grid-3" style="margin-bottom: 24px;">
        <div class="card stat-card">
            <div class="stat-icon" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                📊
            </div>
            <div class="stat-value" style="color: var(--primary);">{{ $totalSks }}</div>
            <div class="stat-label">Total SKS Tersedia</div>
            <small style="color: var(--text-muted); font-size: 0.8rem; margin-top: 6px; display: block;">
                Hasil query: <code>Matakuliah::sum('sks')</code>
            </small>
        </div>

        <div class="card stat-card">
            <div class="stat-icon" style="background: rgba(14, 165, 233, 0.1); color: var(--secondary);">
                📚
            </div>
            <div class="stat-value" style="color: var(--secondary);">{{ $jumlahMatakuliah }}</div>
            <div class="stat-label">Jumlah Mata Kuliah</div>
            <small style="color: var(--text-muted); font-size: 0.8rem; margin-top: 6px; display: block;">
                Hasil query: <code>Matakuliah::count()</code>
            </small>
        </div>

        <div class="card stat-card">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success);">
                🎯
            </div>
            <div class="stat-value" style="color: var(--success);">{{ number_format($rataSks, 1) }}</div>
            <div class="stat-label">Rata-rata SKS / Matkul</div>
            <small style="color: var(--text-muted); font-size: 0.8rem; margin-top: 6px; display: block;">
                Hasil query: <code>Matakuliah::avg('sks')</code>
            </small>
        </div>
    </div>

    <!-- Penjelasan Teknis & Kode Controller -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">💻 Implementasi Kode Controller</h3>
            <span class="badge badge-info">PHP 8.4 &amp; Laravel 13</span>
        </div>
        <div class="query-box">
            <pre style="margin: 0; color: #cbd5e1; font-family: monospace; font-size: 0.85rem;">
namespace App\Http\Controllers;

use App\Models\Matakuliah;

class HitungTotalSksController extends Controller
{
    public function __invoke()
    {
        $totalSks = Matakuliah::sum('sks');
        $jumlahMatakuliah = Matakuliah::count();
        $rataSks = Matakuliah::avg('sks');

        return view('matakuliah.total-sks', compact('totalSks', 'jumlahMatakuliah', 'rataSks'));
    }
}</pre>
        </div>
        <div style="margin-top: 16px; display: flex; justify-content: flex-end;">
            <a href="{{ route('matakuliah.index') }}" class="btn btn-primary">Kelola Mata Kuliah &rarr;</a>
        </div>
    </div>
@endsection
