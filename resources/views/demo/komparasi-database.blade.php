@extends('layouts.app')

@section('judul', 'Komparasi 3 Pendekatan Database Laravel')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Komparasi 3 Pendekatan Akses Database</h1>
            <p class="page-subtitle">Perbandingan Raw SQL, Query Builder, dan Eloquent ORM dengan Inspeksi DB Query Log (Praktikum 4)</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('demo.qb.all') }}" class="btn btn-secondary">Demo Query Builder &rarr;</a>
            <a href="{{ route('demo.eloquent.objek') }}" class="btn btn-primary">stdClass vs Model &rarr;</a>
        </div>

    </div>

    <!-- Tabel Analisis Komparatif -->
    <div class="card" style="margin-bottom: 24px;">
        <div class="card-header">
            <h3 class="card-title">📊 Matriks Evaluasi: Raw SQL vs Query Builder vs Eloquent ORM</h3>
            <span class="badge badge-primary">Analisis Praktikum 4</span>
        </div>
        <div class="table-responsive">
            <table class="custom-table" style="font-size: 0.9rem;">
                <thead>
                    <tr>
                        <th>Fitur / Kriteria</th>
                        <th>1. Raw SQL (DB::select)</th>
                        <th>2. Query Builder (DB::table)</th>
                        <th>3. Eloquent ORM (Model)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Sintaksis</strong></td>
                        <td>SQL murni berbentuk string: <code>SELECT * FROM...</code></td>
                        <td>Method chaining terstruktur: <code>DB::table()->where()</code></td>
                        <td>Object-Relational Mapping: <code>Mahasiswa::where()</code></td>
                    </tr>
                    <tr>
                        <td><strong>Keamanan SQL Injection</strong></td>
                        <td>Rentan jika di-concat string; Aman jika pakai PDO bindings <code>[?]</code></td>
                        <td>Otomatis terlindungi menggunakan PDO Prepared Statements</td>
                        <td>Otomatis terlindungi menggunakan PDO Prepared Statements</td>
                    </tr>
                    <tr>
                        <td><strong>Tipe Return Objek</strong></td>
                        <td><code>array</code> berisi objek generik <code>stdClass</code></td>
                        <td><code>Illuminate\Support\Collection</code> berisi <code>stdClass</code></td>
                        <td><code>Illuminate\Database\Eloquent\Collection</code> berisi <code>Model</code></td>
                    </tr>
                    <tr>
                        <td><strong>Dukungan Relasi</strong></td>
                        <td>Manual via SQL <code>JOIN</code> query</td>
                        <td>Manual via <code>->join()</code> / <code>->leftJoin()</code></td>
                        <td>Otomatis via method Model: <code>hasMany</code>, <code>belongsTo</code>, <code>with()</code></td>
                    </tr>
                    <tr>
                        <td><strong>Fitur Lanjutan</strong></td>
                        <td>Tidak ada (hanya query langsung)</td>
                        <td>Chunking, Aggregates, Pagination</td>
                        <td>Accessors, Mutators, Events, Observers, Soft Deletes</td>
                    </tr>
                    <tr>
                        <td><strong>Performa Eksekusi</strong></td>
                        <td><span class="badge badge-success">Paling Cepat</span> (zero overhead)</td>
                        <td><span class="badge badge-primary">Sangat Cepat</span> (overhead minimal)</td>
                        <td><span class="badge badge-info">Cepat</span> (ada sedikit overhead hidrasi model)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3 Kolom Pendekatan -->
    <div class="grid-3" style="align-items: flex-start; margin-bottom: 24px;">
        <!-- 1. Raw SQL -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">1. Raw SQL</h3>
                <span class="badge badge-secondary">{{ count($rawSqlData) }} Data</span>
            </div>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 12px;">
                Menggunakan <code>DB::select("SELECT * FROM mahasiswas WHERE prodi = ?", ['Teknik Informatika'])</code>
            </p>

            <h4 style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 6px;">🔍 Query Log:</h4>
            <div class="query-box" style="margin-bottom: 16px;">
                @foreach ($rawSqlLog as $log)
                    <div><strong>Query:</strong> {{ $log['query'] }}</div>
                    <div><strong>Bindings:</strong> {{ json_encode($log['bindings']) }}</div>
                    <div><strong>Time:</strong> <span style="color:#38bdf8;">{{ $log['time'] }} ms</span></div>
                @endforeach
            </div>

            <h4 style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 6px;">📋 Sampel Output Data:</h4>
            <ul style="padding-left: 20px; font-size: 0.85rem; margin: 0; color: var(--text-main);">
                @foreach ($rawSqlData as $item)
                    <li style="margin-bottom: 4px;">{{ $item->nim }} - {{ $item->nama }} (Sem {{ $item->semester }})</li>
                @endforeach
            </ul>
        </div>

        <!-- 2. Query Builder -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">2. Query Builder</h3>
                <span class="badge badge-primary">{{ count($queryBuilderData) }} Data</span>
            </div>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 12px;">
                Menggunakan <code>DB::table('mahasiswas')->where('prodi', 'Teknik Informatika')->get()</code>
            </p>

            <h4 style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 6px;">🔍 Query Log:</h4>
            <div class="query-box" style="margin-bottom: 16px;">
                @foreach ($queryBuilderLog as $log)
                    <div><strong>Query:</strong> {{ $log['query'] }}</div>
                    <div><strong>Bindings:</strong> {{ json_encode($log['bindings']) }}</div>
                    <div><strong>Time:</strong> <span style="color:#38bdf8;">{{ $log['time'] }} ms</span></div>
                @endforeach
            </div>

            <h4 style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 6px;">📋 Sampel Output Data:</h4>
            <ul style="padding-left: 20px; font-size: 0.85rem; margin: 0; color: var(--text-main);">
                @foreach ($queryBuilderData as $item)
                    <li style="margin-bottom: 4px;">{{ $item->nim }} - {{ $item->nama }} (Sem {{ $item->semester }})</li>
                @endforeach
            </ul>
        </div>

        <!-- 3. Eloquent ORM -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">3. Eloquent ORM</h3>
                <span class="badge badge-success">{{ count($eloquentData) }} Data</span>
            </div>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 12px;">
                Menggunakan <code>Mahasiswa::where('prodi', 'Teknik Informatika')->orderBy('nama', 'asc')->get()</code>
            </p>

            <h4 style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 6px;">🔍 Query Log:</h4>
            <div class="query-box" style="margin-bottom: 16px;">
                @foreach ($eloquentLog as $log)
                    <div><strong>Query:</strong> {{ $log['query'] }}</div>
                    <div><strong>Bindings:</strong> {{ json_encode($log['bindings']) }}</div>
                    <div><strong>Time:</strong> <span style="color:#38bdf8;">{{ $log['time'] }} ms</span></div>
                @endforeach
            </div>

            <h4 style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 6px;">📋 Sampel Output Data:</h4>
            <ul style="padding-left: 20px; font-size: 0.85rem; margin: 0; color: var(--text-main);">
                @foreach ($eloquentData as $item)
                    <li style="margin-bottom: 4px;">
                        {{ $item->nim }} - {{ $item->nama }}
                        <span class="badge badge-sm badge-info">{{ $item->status }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
