@extends('layouts.app')

@section('judul', 'Beranda - Controller, Query Builder & Eloquent Laravel 13')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Sistem Informasi Akademik (SIAKAD)</h1>
            <p class="page-subtitle">Modul Praktikum: Controller serta Interaksi Database dengan Query Builder &amp; Eloquent pada Laravel 13</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('demo.eloquent.eager') }}" class="btn btn-secondary">⚡ Uji Eager Loading</a>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-primary">Kelola Mahasiswa &rarr;</a>
        </div>
    </div>

    <!-- Quick Database Stats Summary -->
    <div class="grid-4" style="margin-bottom: 28px;">
        <div class="stat-card">
            <div class="stat-icon">👨‍🎓</div>
            <div>
                <div class="stat-number">{{ \App\Models\Mahasiswa::count() }}</div>
                <div class="stat-label">Total Mahasiswa</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:#e0f2fe; color:#0284c7;">📚</div>
            <div>
                <div class="stat-number">{{ \App\Models\Matakuliah::count() }}</div>
                <div class="stat-label">Total Mata Kuliah</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:#fef3c7; color:#d97706;">📝</div>
            <div>
                <div class="stat-number">{{ \App\Models\NilaiMatakuliah::count() }}</div>
                <div class="stat-label">Rekord Nilai Relasi</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:#dcfce7; color:#16a34a;">🎯</div>
            <div>
                <div class="stat-number">7/7</div>
                <div class="stat-label">Praktikum Selesai</div>
            </div>
        </div>
    </div>

    <!-- Diagram Alur Request MVC (Tugas Mandiri Praktikum 1 No. 2) -->
    <div class="card" style="margin-bottom: 28px;">
        <div class="card-header">
            <h2 class="card-title">🔄 Diagram Alur Request-Response &amp; Posisi Controller dalam MVC (Praktikum 1 Mandiri)</h2>
            <span class="badge badge-primary">Arsitektur MVC Laravel</span>
        </div>

        <div style="background:#0f172a; color:#f8fafc; padding:20px; border-radius:var(--radius-sm); font-family:monospace; font-size:0.88rem; line-height:1.7; overflow-x:auto;">
            <span style="color:#38bdf8;">1. Browser (User)</span> ──[ HTTP Request: GET /mahasiswa ]──&gt; <span style="color:#a78bfa;">public/index.php</span> (Front Controller)<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;▼<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#fbbf24;">Router (routes/web.php)</span><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│ Cocokkan URL &amp; Method<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;▼<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong style="color:#4ade80; background:rgba(74,222,128,0.15); padding:2px 8px; border-radius:4px;">[ CONTROLLER: MahasiswaController@index ]</strong><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│ Menerima Request &amp; panggil Model<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;▼<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#f43f5e;">MODEL: Mahasiswa::with('nilai')</span><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│ Eksekusi SQL Query ke DB<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;▼<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#fb7185;">DATABASE (SQLite / MySQL)</span><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│ Kembalikan Dataset Records<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;▼<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong style="color:#4ade80;">[ CONTROLLER ]</strong> ──&gt; view('mahasiswa.index', compact('mahasiswa'))<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│ Meneruskan data ke template<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;▼<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#38bdf8;">VIEW: mahasiswa.index (Blade)</span><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│ Render HTML<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;▼<br>
            <span style="color:#38bdf8;">Browser (User)</span> &lt;─────────────[ HTTP Response: 200 OK (Dokumen HTML) ]─────────────┘
        </div>
    </div>

    <!-- Peta Pengerjaan 3 Bagian Modul -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">📌 Peta Pengerjaan Modul Praktikum (Praktikum 1 s/d 7 &amp; Proyek Akhir)</h2>
            <span class="badge badge-success">100% Selesai Diimplementasikan</span>
        </div>

        <div class="grid-3">
            <!-- Box Bagian 1: Controller -->
            <div style="background:#faf5ff; border:1px solid #e9d5ff; border-radius:var(--radius-sm); padding:18px;">
                <h3 style="color:#6b21a8; font-size:1.05rem; margin-bottom:12px; display:flex; align-items:center; gap:8px;">
                    <span>🎮</span> BAGIAN I — CONTROLLER
                </h3>
                <ul style="padding-left:18px; font-size:0.88rem; line-height:1.8; color:var(--text-main);">
                    <li>
                        <strong>Praktikum 1:</strong> 
                        <a href="{{ route('sapa.closure') }}" target="_blank"><code>/sapa-closure</code></a> vs 
                        <a href="{{ route('sapa.controller') }}" target="_blank"><code>/sapa-controller</code></a> &bull; 
                        <a href="{{ route('latihan.controller') }}" target="_blank"><code>LatihanController</code></a>
                    </li>
                    <li>
                        <strong>Praktikum 2:</strong> 
                        <a href="{{ route('mahasiswa.uji.form') }}">Form Uji Request (@csrf)</a> &bull; 
                        <a href="{{ route('mahasiswa.api') }}" target="_blank">Response JSON</a> &bull; 
                        <a href="{{ route('mahasiswa.cari') }}">Pencarian Query String</a>
                    </li>
                    <li>
                        <strong>Praktikum 3:</strong> 
                        <a href="{{ route('statistik.mahasiswa') }}">Statistik (Invokable)</a> &bull; 
                        <a href="{{ route('matakuliah.total-sks') }}">Total SKS (Invokable)</a> &bull; 
                        <a href="{{ route('admin.dashboard') }}">Admin Dashboard</a> &bull; 
                        <a href="{{ route('laporan.rekap') }}">Laporan Rekap</a>
                    </li>
                </ul>
            </div>

            <!-- Box Bagian 2: Query Builder -->
            <div style="background:#f0f9ff; border:1px solid #bae6fd; border-radius:var(--radius-sm); padding:18px;">
                <h3 style="color:#0369a1; font-size:1.05rem; margin-bottom:12px; display:flex; align-items:center; gap:8px;">
                    <span>🔍</span> BAGIAN II — QUERY BUILDER
                </h3>
                <ul style="padding-left:18px; font-size:0.88rem; line-height:1.8; color:var(--text-main);">
                    <li>
                        <strong>Praktikum 4:</strong> 
                        <a href="{{ route('demo.qb.komparasi') }}">Komparasi 3 Pendekatan (Raw, QB, Eloquent) &amp; Query Log</a>
                    </li>
                    <li>
                        <strong>Praktikum 5 Operasi:</strong> 
                        <a href="{{ route('demo.qb.all') }}">Tampilkan Semua Data</a> &bull; 
                        <a href="{{ route('demo.qb.filter') }}">Filter Semester &gt;= 3</a>
                    </li>
                    <li>
                        <strong>Praktikum 5 Mandiri:</strong> 
                        <a href="{{ route('demo.qb.mandiri.filter') }}">Filter TI &amp; Sem 3-6 (whereBetween)</a> &bull; 
                        <a href="{{ route('demo.qb.statistik') }}">Agregasi Group By Prodi</a> &bull; 
                        <a href="{{ route('demo.qb.paginasi') }}">Paginasi QB paginate(5)</a> &bull; 
                        <a href="{{ route('demo.qb.crud') }}">CRUD Interaktif via QB</a>
                    </li>
                </ul>
            </div>

            <!-- Box Bagian 3: Eloquent ORM -->
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:var(--radius-sm); padding:18px;">
                <h3 style="color:#166534; font-size:1.05rem; margin-bottom:12px; display:flex; align-items:center; gap:8px;">
                    <span>💎</span> BAGIAN III — ELOQUENT ORM
                </h3>
                <ul style="padding-left:18px; font-size:0.88rem; line-height:1.8; color:var(--text-main);">
                    <li>
                        <strong>Praktikum 6:</strong> 
                        <a href="{{ route('demo.eloquent.objek') }}">Perbandingan Objek stdClass vs Model Instance</a>
                    </li>
                    <li>
                        <strong>Praktikum 7 CRUD &amp; Relasi:</strong> 
                        <a href="{{ route('mahasiswa.index') }}">CRUD Mahasiswa (hasMany Nilai)</a> &bull; 
                        <a href="{{ route('matakuliah.index') }}">CRUD Matakuliah (hasMany Mahasiswa)</a>
                    </li>
                    <li>
                        <strong>Praktikum 7 Eager Loading:</strong> 
                        <a href="{{ route('demo.eloquent.eager') }}"><strong>Bukti Komparasi N+1 Lazy vs Eager Loading with()</strong></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Quick Access Cards -->
    <div class="grid-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">👨‍🎓 Modul Mahasiswa (Eloquent &amp; Relasi)</h3>
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-sm btn-primary">Buka Modul &rarr;</a>
            </div>
            <p style="color:var(--text-muted); font-size:0.9rem; margin-bottom:14px;">
                Daftar mahasiswa lengkap dengan operasi CRUD Eloquent, Route Model Binding, status tingkat semester (Accessor), dan daftar nilai mata kuliah (Relasi <code>hasMany</code>).
            </p>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-sm btn-secondary">Lihat Data</a>
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-sm btn-secondary">+ Tambah Mahasiswa</a>
                <a href="{{ route('mahasiswa.cari') }}" class="btn btn-sm btn-secondary">🔍 Cari Mahasiswa</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">📚 Modul Mata Kuliah (Eloquent &amp; Relasi)</h3>
                <a href="{{ route('matakuliah.index') }}" class="btn btn-sm btn-primary">Buka Modul &rarr;</a>
            </div>
            <p style="color:var(--text-muted); font-size:0.9rem; margin-bottom:14px;">
                Daftar kurikulum mata kuliah dengan CRUD Eloquent, perhitungan jumlah peserta via <code>withCount('nilai')</code>, dan daftar peserta per mata kuliah (Relasi <code>hasMany</code>).
            </p>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <a href="{{ route('matakuliah.index') }}" class="btn btn-sm btn-secondary">Lihat Kurikulum</a>
                <a href="{{ route('matakuliah.create') }}" class="btn btn-sm btn-secondary">+ Tambah Matkul</a>
                <a href="{{ route('matakuliah.total-sks') }}" class="btn btn-sm btn-secondary">⚡ Total SKS</a>
            </div>
        </div>
    </div>
@endsection
