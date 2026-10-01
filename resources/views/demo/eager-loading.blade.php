@extends('layouts.app')

@section('judul', 'Komparasi Eager Loading vs Lazy Loading (N+1 Problem)')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Inspeksi Query Log: Eager vs Lazy Loading</h1>
            <p class="page-subtitle">Demonstrasi Praktikum 7 Langkah Kerja 6 &amp; Tugas Mandiri No. 3 (Pencegahan Masalah N+1 Query)</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('demo.eloquent.objek') }}" class="btn btn-secondary">&laquo; stdClass vs Model</a>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-primary">Data Mahasiswa &rarr;</a>
        </div>
    </div>

    <!-- Mode Toggle Controls -->
    <div class="card" style="margin-bottom: 24px; background: #ffffff; border: 2px solid {{ $mode === 'lazy' ? 'var(--danger)' : 'var(--success)' }};">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div>
                <h3 style="font-size: 1.1rem; color: var(--text-main); margin-bottom: 4px;">
                    Mode Aktif: 
                    @if ($mode === 'lazy')
                        <span class="badge badge-danger" style="font-size: 0.95rem;">⚠️ LAZY LOADING (Memicu N+1 Query)</span>
                    @else
                        <span class="badge badge-success" style="font-size: 0.95rem;">⚡ EAGER LOADING with('nilai.matakuliah')</span>
                    @endif
                </h3>
                <p style="font-size: 0.88rem; color: var(--text-muted); margin: 0;">
                    {{ $penjelasan }}
                </p>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="{{ route('demo.eloquent.eager', ['mode' => 'lazy']) }}" class="btn {{ $mode === 'lazy' ? 'btn-danger' : 'btn-secondary' }}">
                    Uji Mode: Lazy Loading (N+1)
                </a>
                <a href="{{ route('demo.eloquent.eager', ['mode' => 'eager']) }}" class="btn {{ $mode === 'eager' ? 'btn-success' : 'btn-secondary' }}">
                    Uji Mode: Eager Loading (Optimasi)
                </a>
            </div>

        </div>
    </div>

    <!-- Live Performance Metric Cards -->
    <div class="grid-3" style="margin-bottom: 24px;">
        <div class="card stat-card" style="border-top: 4px solid {{ $mode === 'lazy' ? 'var(--danger)' : 'var(--success)' }};">
            <div class="stat-icon" style="background: {{ $mode === 'lazy' ? 'rgba(239, 68, 68, 0.1)' : 'rgba(16, 185, 129, 0.1)' }}; color: {{ $mode === 'lazy' ? 'var(--danger)' : 'var(--success)' }};">
                ⚡
            </div>
            <div class="stat-value" style="color: {{ $mode === 'lazy' ? 'var(--danger)' : 'var(--success)' }};">
                {{ $totalQueries }}
            </div>
            <div class="stat-label">Total Query SQL Dijalankan</div>
            <small style="color: var(--text-muted); font-size: 0.8rem; margin-top: 6px; display: block;">
                @if ($mode === 'lazy')
                    Membengkak akibat N query di dalam perulangan
                @else
                    Konstan hanya 3 query berkat eager loading
                @endif
            </small>
        </div>

        <div class="card stat-card">
            <div class="stat-icon" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                👨‍🎓
            </div>
            <div class="stat-value" style="color: var(--primary);">{{ $mahasiswa->count() }}</div>
            <div class="stat-label">Mahasiswa Diambil</div>
            <small style="color: var(--text-muted); font-size: 0.8rem; margin-top: 6px; display: block;">
                Sample dataset: 10 data mahasiswa
            </small>
        </div>

        <div class="card stat-card">
            <div class="stat-icon" style="background: rgba(14, 165, 233, 0.1); color: var(--secondary);">
                ⏱️
            </div>
            @php
                $totalTime = array_sum(array_column($queryLogs, 'time'));
            @endphp
            <div class="stat-value" style="color: var(--secondary);">{{ number_format($totalTime, 2) }} ms</div>
            <div class="stat-label">Total Database Execution Time</div>
            <small style="color: var(--text-muted); font-size: 0.8rem; margin-top: 6px; display: block;">
                Waktu eksekusi SQLite query log
            </small>
        </div>
    </div>

    <!-- Live Query Log Panel -->
    <div class="card" style="margin-bottom: 24px;">
        <div class="card-header">
            <h3 class="card-title">📜 Daftar Lengkap Query Log (DB::getQueryLog())</h3>
            <span class="badge {{ $mode === 'lazy' ? 'badge-danger' : 'badge-success' }}">{{ $totalQueries }} Query Recorded</span>
        </div>

        <div class="query-box" style="max-height: 280px; overflow-y: auto;">
            @foreach ($queryLogs as $index => $q)
                <div style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px dashed rgba(255,255,255,0.15);">
                    <div style="display:flex; justify-content:space-between;">
                        <span style="color: #fbbf24; font-weight: bold;">#{{ $index + 1 }}</span>
                        <span style="color: #38bdf8;">{{ $q['time'] }} ms</span>
                    </div>
                    <div style="color: #f1f5f9; margin-top: 2px;">{{ $q['query'] }}</div>
                    @if (!empty($q['bindings']))
                        <div style="color: #94a3b8; font-size: 0.75rem;">Bindings: {{ json_encode($q['bindings']) }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Render Tabel Hasil Pengambilan Relasi -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📊 Data Hasil Pengambilan Relasi Mahasiswa &amp; Nilai</h3>
        </div>

        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Program Studi</th>
                        <th>Semester</th>
                        <th>Mata Kuliah Diambil (Relasi)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswa as $m)
                        <tr class="{{ $loop->even ? 'baris-genap' : 'baris-ganjil' }}">
                            <td><code>{{ $m->nim }}</code></td>
                            <td><strong>{{ $m->nama }}</strong></td>
                            <td>{{ $m->prodi }}</td>
                            <td><span class="badge badge-info">Sem {{ $m->semester }}</span></td>
                            <td>
                                @if (isset($rekapNilai[$m->id]) && count($rekapNilai[$m->id]) > 0)
                                    <div style="display: flex; flex-direction: column; gap: 4px;">
                                        @foreach ($rekapNilai[$m->id] as $mk)
                                            <span style="font-size: 0.85rem;">
                                                &bull; {{ $mk['matakuliah'] }} 
                                                <strong style="color: var(--primary);">({{ $mk['nilai'] }})</strong> 
                                                <span class="badge badge-sm badge-success">{{ $mk['grade'] }}</span>
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span style="color: var(--text-muted); font-size: 0.85rem;">Belum ada nilai terdaftar</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
