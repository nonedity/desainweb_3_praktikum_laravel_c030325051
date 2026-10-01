@extends('layouts.app')

@section('judul', 'Daftar Mahasiswa - Eloquent ORM')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Daftar Mahasiswa</h1>
            <p class="page-subtitle">Modul Controller &amp; Database: Pengelolaan Data Mahasiswa Menggunakan Eloquent ORM</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('mahasiswa.cari') }}" class="btn btn-secondary">
                🔍 Fitur Pencarian (Praktikum 2)
            </a>
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">
                + Tambah Mahasiswa
            </a>
        </div>
    </div>

    <!-- Filter & Pencarian Box -->
    <div class="card" style="padding: 16px 20px; margin-bottom: 20px;">
        <form action="{{ route('mahasiswa.index') }}" method="GET" style="display:flex; gap:14px; flex-wrap:wrap; align-items:flex-end;">
            <div style="flex: 2; min-width: 220px;">
                <label class="form-label" style="font-size: 0.8rem; margin-bottom: 4px;">Cari Nama / NIM:</label>
                <input type="text" name="cari" class="form-control" placeholder="Ketik nama atau NIM..." value="{{ request('cari') }}">
            </div>

            <div style="flex: 1; min-width: 180px;">
                <label class="form-label" style="font-size: 0.8rem; margin-bottom: 4px;">Program Studi:</label>
                <select name="prodi" class="form-control">
                    <option value="">-- Semua Prodi --</option>
                    @foreach (['Teknik Informatika', 'Sistem Informasi', 'Teknologi Informasi', 'Ilmu Komputer'] as $p)
                        <option value="{{ $p }}" {{ request('prodi') == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <div style="flex: 1; min-width: 140px;">
                <label class="form-label" style="font-size: 0.8rem; margin-bottom: 4px;">Semester:</label>
                <select name="semester" class="form-control">
                    <option value="">-- Semua --</option>
                    @for ($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div style="display:flex; gap: 8px;">
                <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                @if (request()->hasAny(['cari', 'prodi', 'semester']))
                    <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Mahasiswa -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">👨‍🎓 Data Mahasiswa Terdaftar (Eloquent Dataset)</h3>
            <span class="badge badge-primary">Total: {{ $mahasiswa->total() }} Mahasiswa</span>
        </div>

        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Program Studi</th>
                        <th>Semester</th>
                        <th>Status (Accessor)</th>
                        <th>Mata Kuliah Terdaftar</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswa as $mhs)
                        <tr class="{{ $loop->even ? 'baris-genap' : 'baris-ganjil' }}">
                            <td><strong>{{ $mahasiswa->firstItem() + $loop->index }}</strong></td>
                            <td><code>{{ $mhs->nim }}</code></td>
                            <td>
                                <strong>{{ $mhs->nama }}</strong>
                                @if ($mhs->email)
                                    <br><small style="color:var(--text-muted);">{{ $mhs->email }}</small>
                                @endif
                            </td>
                            <td>{{ $mhs->prodi }}</td>
                            <td><span class="badge badge-info">Semester {{ $mhs->semester }}</span></td>
                            <td>
                                {{-- Praktikum 7: Accessor status --}}
                                @if ($mhs->semester >= 7)
                                    <span class="badge badge-warning">{{ $mhs->status }}</span>
                                @elseif ($mhs->semester <= 2)
                                    <span class="badge badge-success">{{ $mhs->status }}</span>
                                @else
                                    <span class="badge badge-purple">{{ $mhs->status }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-primary">{{ $mhs->nilai->count() }} Mata Kuliah</span>
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="{{ route('mahasiswa.show', $mhs->id) }}" class="btn btn-sm btn-secondary" title="Lihat Detail & Nilai">
                                    Detail
                                </a>
                                <a href="{{ route('mahasiswa.edit', $mhs->id) }}" class="btn btn-sm btn-secondary" title="Edit Data">
                                    Edit
                                </a>
                                <form action="{{ route('mahasiswa.destroy', $mhs->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mahasiswa ini?');">
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
                                <div style="font-size: 2.5rem; margin-bottom: 8px;">📭</div>
                                <h4>Data Mahasiswa Tidak Ditemukan</h4>
                                <p style="font-size: 0.9rem;">Tidak ada rekaman data mahasiswa yang sesuai dengan filter pencarian.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div style="margin-top: 20px;">
            {{ $mahasiswa->links() }}
        </div>
    </div>
@endsection
