@extends('layouts.app')

@section('judul', 'Daftar Mata Kuliah - Eloquent ORM')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Kurikulum &amp; Daftar Mata Kuliah</h1>
            <p class="page-subtitle">Modul Controller &amp; Database: Pengelolaan Kurikulum dengan Resource Controller &amp; Eloquent ORM</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('matakuliah.total-sks') }}" class="btn btn-secondary">
                ⚡ Total SKS (Praktikum 3)
            </a>
            <a href="{{ route('matakuliah.create') }}" class="btn btn-primary">
                + Tambah Mata Kuliah
            </a>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="card" style="padding: 16px 20px; margin-bottom: 20px;">
        <form action="{{ route('matakuliah.index') }}" method="GET" style="display:flex; gap:14px; flex-wrap:wrap; align-items:flex-end;">
            <div style="flex: 2; min-width: 220px;">
                <label class="form-label" style="font-size: 0.8rem; margin-bottom: 4px;">Cari Nama / Kode MK:</label>
                <input type="text" name="cari" class="form-control" placeholder="Ketik nama atau kode..." value="{{ request('cari') }}">
            </div>

            <div style="flex: 1; min-width: 140px;">
                <label class="form-label" style="font-size: 0.8rem; margin-bottom: 4px;">Semester:</label>
                <select name="semester" class="form-control">
                    <option value="">-- Semua Semester --</option>
                    @for ($s = 1; $s <= 8; $s++)
                        <option value="{{ $s }}" {{ request('semester') == $s ? 'selected' : '' }}>Semester {{ $s }}</option>
                    @endfor
                </select>
            </div>

            <div style="display:flex; gap: 8px;">
                <button type="submit" class="btn btn-primary">Filter</button>
                @if (request()->hasAny(['cari', 'semester']))
                    <a href="{{ route('matakuliah.index') }}" class="btn btn-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Matakuliah -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📚 Daftar Mata Kuliah (Eloquent Dataset)</h3>
            <span class="badge badge-primary">Total: {{ $matakuliah->total() }} Mata Kuliah</span>
        </div>

        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th>Bobot SKS</th>
                        <th>Semester</th>
                        <th>Dosen Pengampu</th>
                        <th>Mahasiswa Mengambil</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($matakuliah as $mk)
                        <tr class="{{ $loop->even ? 'baris-genap' : 'baris-ganjil' }}">
                            <td><strong>{{ $matakuliah->firstItem() + $loop->index }}</strong></td>
                            <td><code>{{ $mk->kode_mk }}</code></td>
                            <td><strong>{{ $mk->nama_mk }}</strong></td>
                            <td>
                                <span class="badge badge-info">{{ $mk->sks }} SKS</span>
                            </td>
                            <td>Semester {{ $mk->semester }}</td>
                            <td>{{ $mk->dosen_pengampu ?? 'Tim Dosen' }}</td>
                            <td>
                                <span class="badge badge-purple">{{ $mk->nilai_count }} Mahasiswa</span>
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="{{ route('matakuliah.show', $mk->id) }}" class="btn btn-sm btn-secondary" title="Lihat Detail & Mahasiswa Peserta">
                                    Detail
                                </a>
                                <a href="{{ route('matakuliah.edit', $mk->id) }}" class="btn btn-sm btn-secondary" title="Edit Data">
                                    Edit
                                </a>
                                <form action="{{ route('matakuliah.destroy', $mk->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px 20px; color: var(--text-muted);">
                                <div style="font-size: 2.5rem; margin-bottom: 8px;">📖</div>
                                <h4>Data Mata Kuliah Tidak Ditemukan</h4>
                                <p style="font-size: 0.9rem;">Tidak ada rekaman mata kuliah yang sesuai.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $matakuliah->links() }}
        </div>
    </div>
@endsection
