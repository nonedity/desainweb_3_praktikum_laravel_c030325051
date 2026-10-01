@extends('layouts.app')

@section('judul', 'Pencarian Mahasiswa via Query String - Praktikum 2')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Pencarian Mahasiswa via Query String</h1>
            <p class="page-subtitle">Tugas Mandiri Praktikum 2: Input Parameter <code>?nama=...</code> &amp; Method <code>cariMahasiswa(Request $request)</code></p>
        </div>
        <div>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">&laquo; Daftar Mahasiswa</a>
        </div>
    </div>

    <!-- Form Pencarian (Method GET) -->
    <div class="card" style="max-width: 650px; margin: 0 auto 24px;">
        <div class="card-header">
            <h3 class="card-title">🔍 Form Pencarian Mahasiswa (Method GET)</h3>
        </div>

        <form action="{{ route('mahasiswa.cari') }}" method="GET">
            <div class="form-group">
                <label for="nama" class="form-label">Nama Mahasiswa yang Dicari:</label>
                <div style="display:flex; gap:10px;">
                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Contoh: Ahmad / Budi / Siti" value="{{ $kataKunci }}" required>
                    <button type="submit" class="btn btn-primary" style="white-space:nowrap;">Cari Data</button>
                </div>
                <small style="color:var(--text-muted); display:block; margin-top:6px;">
                    Data dikirimkan ke URL menggunakan query string: <code>/mahasiswa/cari?nama={{ urlencode($kataKunci ?: 'kata_kunci') }}</code>
                </small>
            </div>
        </form>
    </div>

    @if ($kataKunci)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">📋 {{ $pesan }}</h3>
                <span class="badge badge-primary">Total: {{ $hasil->count() }} Data</span>
            </div>

            @if ($hasil->isNotEmpty())
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama Lengkap</th>
                                <th>Program Studi</th>
                                <th>Semester</th>
                                <th style="text-align:right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasil as $mhs)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><code>{{ $mhs->nim }}</code></td>
                                    <td><strong>{{ $mhs->nama }}</strong></td>
                                    <td>{{ $mhs->prodi }}</td>
                                    <td><span class="badge badge-info">Semester {{ $mhs->semester }}</span></td>
                                    <td style="text-align:right;">
                                        <a href="{{ route('mahasiswa.show', $mhs->id) }}" class="btn btn-sm btn-secondary">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align:center; padding:30px; color:var(--text-muted);">
                    <p>Tidak ditemukan data mahasiswa dengan nama yang mengandung '{{ $kataKunci }}'.</p>
                </div>
            @endif
        </div>
    @endif
@endsection
