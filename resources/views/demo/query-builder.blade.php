@extends('layouts.app')

@section('judul', $judul)

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Demo Query Builder Laravel</h1>
            <p class="page-subtitle">Eksplorasi Method Chaining, Kondisional Filtering, dan Agregasi (Praktikum 5)</p>
        </div>
        <a href="{{ route('demo.qb.komparasi') }}" class="btn btn-secondary">&laquo; Komparasi 3 Pendekatan</a>
    </div>

    <!-- Quick Navigation Sub-menu -->
    <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 24px;">
        <a href="{{ route('demo.qb.all') }}" class="btn {{ request()->routeIs('demo.qb.all') ? 'btn-primary' : 'btn-secondary' }}">
            1. Tampilkan Semua (get)
        </a>
        <a href="{{ route('demo.qb.filter') }}" class="btn {{ request()->routeIs('demo.qb.filter') ? 'btn-primary' : 'btn-secondary' }}">
            2. Filter Semester &gt;= 3
        </a>
        <a href="{{ route('demo.qb.mandiri.filter') }}" class="btn {{ request()->routeIs('demo.qb.mandiri.filter') ? 'btn-primary' : 'btn-secondary' }}">
            3. Tugas Mandiri 1 (whereBetween)
        </a>
        <a href="{{ route('demo.qb.statistik') }}" class="btn btn-secondary">
            4. Agregasi per Prodi
        </a>

        <a href="{{ route('demo.qb.paginasi') }}" class="btn btn-secondary">
            5. Paginasi QB (paginate)
        </a>
        <a href="{{ route('demo.qb.crud') }}" class="btn btn-secondary">
            6. Interactive CRUD
        </a>
    </div>

    @if (isset($queryLog) && !empty($queryLog))
        <div class="card" style="margin-bottom: 20px; border-left: 4px solid var(--primary);">
            <div class="card-header">
                <h3 class="card-title">🔍 Query Log yang Dieksekusi</h3>
                <span class="badge badge-info">whereBetween</span>
            </div>
            <div class="query-box">
                @foreach ($queryLog as $log)
                    <div><strong>SQL:</strong> {{ $log['query'] }}</div>
                    <div><strong>Bindings:</strong> {{ json_encode($log['bindings']) }}</div>
                    <div><strong>Waktu Eksekusi:</strong> <span style="color:#38bdf8;">{{ $log['time'] }} ms</span></div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $judul }}</h3>
            <span class="badge badge-primary">{{ count($data) }} Mahasiswa Ditemukan</span>
        </div>

        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Program Studi</th>
                        <th>Semester</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr class="{{ $loop->even ? 'baris-genap' : 'baris-ganjil' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td><code>{{ $item->nim }}</code></td>
                            <td><strong>{{ $item->nama }}</strong></td>
                            <td>{{ $item->email ?? '-' }}</td>
                            <td>{{ $item->prodi }}</td>
                            <td><span class="badge badge-info">Semester {{ $item->semester }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 24px; color: var(--text-muted);">
                                Tidak ada data mahasiswa yang memenuhi kriteria filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
