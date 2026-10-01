@extends('layouts.app')

@section('judul', 'CRUD Interaktif via Query Builder')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">CRUD Interaktif via Query Builder (DB::table)</h1>
            <p class="page-subtitle">Demonstrasi Praktikum 5 Langkah Kerja 5: Insert &amp; Delete Data Mahasiswa Menggunakan Query Builder Murni</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('demo.qb.all') }}" class="btn btn-secondary">&laquo; Menu Query Builder</a>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-primary">CRUD Eloquent ORM &rarr;</a>
        </div>

    </div>

    @if (session('pesan'))
        <div class="alert alert-success" style="margin-bottom: 20px;">
            ✅ {{ session('pesan') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 20px;">
            <strong>⚠️ Validasi Gagal:</strong>
            <ul style="margin: 8px 0 0 20px; font-size: 0.9rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid-3" style="align-items: flex-start; margin-bottom: 24px;">
        <!-- Form Insert Query Builder -->
        <div class="card" style="grid-column: span 1;">
            <div class="card-header">
                <h3 class="card-title">➕ Tambah Mahasiswa</h3>
                <span class="badge badge-primary">DB::table()-&gt;insert()</span>
            </div>

            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 16px;">
                Data disisipkan ke tabel <code>mahasiswas</code> langsung melalui method <code>DB::table('mahasiswas')->insert([...])</code> tanpa melalui Model Eloquent.
            </p>

            <form action="{{ route('demo.qb.insert') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="nim">NIM Mahasiswa <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="nim" name="nim" class="form-control" value="{{ old('nim') }}" placeholder="Contoh: 20261199" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="nama">Nama Lengkap <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Contoh: Zaskia Adya" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="zaskia@example.com">
                </div>

                <div class="form-group">
                    <label class="form-label" for="prodi">Program Studi <span style="color:var(--danger)">*</span></label>
                    <select id="prodi" name="prodi" class="form-control" required>
                        <option value="">-- Pilih Program Studi --</option>
                        <option value="Teknik Informatika" {{ old('prodi') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                        <option value="Sistem Informasi" {{ old('prodi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                        <option value="Teknologi Informasi" {{ old('prodi') == 'Teknologi Informasi' ? 'selected' : '' }}>Teknologi Informasi</option>
                        <option value="Ilmu Komputer" {{ old('prodi') == 'Ilmu Komputer' ? 'selected' : '' }}>Ilmu Komputer</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="semester">Semester <span style="color:var(--danger)">*</span></label>
                    <select id="semester" name="semester" class="form-control" required>
                        @for ($s = 1; $s <= 8; $s++)
                            <option value="{{ $s }}" {{ old('semester') == $s ? 'selected' : '' }}>Semester {{ $s }}</option>
                        @endfor
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">
                    Simpan via Query Builder
                </button>
            </form>
        </div>

        <!-- Tabel Data & Tombol Hapus Query Builder -->
        <div class="card" style="grid-column: span 2;">
            <div class="card-header">
                <h3 class="card-title">📋 Data Tabel Mahasiswa (Diurutkan Terkini)</h3>
                <span class="badge badge-info">{{ $mahasiswa->count() }} Data</span>
            </div>

            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Sem</th>
                            <th style="text-align: center;">Aksi (Delete QB)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mahasiswa as $item)
                            <tr class="{{ $loop->even ? 'baris-genap' : 'baris-ganjil' }}">
                                <td>{{ $item->id }}</td>
                                <td><code>{{ $item->nim }}</code></td>
                                <td><strong>{{ $item->nama }}</strong></td>
                                <td>{{ $item->prodi }}</td>
                                <td><span class="badge badge-primary">Sem {{ $item->semester }}</span></td>
                                <td style="text-align: center;">
                                    <form action="{{ route('demo.qb.delete', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa {{ $item->nama }} via Query Builder?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus QB</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 24px; color: var(--text-muted);">
                                    Belum ada data mahasiswa dalam tabel.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
