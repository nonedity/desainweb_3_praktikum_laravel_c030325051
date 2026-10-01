@extends('layouts.app')

@section('judul', 'Tambah Mahasiswa - Eloquent ORM')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Mahasiswa Baru</h1>
            <p class="page-subtitle">Penyimpanan Data Menggunakan Method Eloquent <code>Mahasiswa::create()</code> (Praktikum 7)</p>
        </div>
        <div>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">&laquo; Kembali</a>
        </div>
    </div>

    <div class="card" style="max-width: 650px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="card-title">📝 Formulir Data Mahasiswa Baru</h3>
        </div>

        <form action="{{ route('mahasiswa.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nim" class="form-label">Nomor Induk Mahasiswa (NIM) <span style="color:var(--danger)">*</span></label>
                <input type="text" id="nim" name="nim" class="form-control" value="{{ old('nim') }}" placeholder="Contoh: 2024010015" required>
                @error('nim')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama" class="form-label">Nama Lengkap <span style="color:var(--danger)">*</span></label>
                <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Contoh: Muhammad Rizky" required>
                @error('nama')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Contoh: rizky@kampus.ac.id">
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="prodi" class="form-label">Program Studi <span style="color:var(--danger)">*</span></label>
                <select id="prodi" name="prodi" class="form-control" required>
                    <option value="">-- Pilih Program Studi --</option>
                    @foreach (['Teknik Informatika', 'Sistem Informasi', 'Teknologi Informasi', 'Ilmu Komputer'] as $prodi)
                        <option value="{{ $prodi }}" {{ old('prodi') == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                    @endforeach
                </select>
                @error('prodi')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="semester" class="form-label">Semester <span style="color:var(--danger)">*</span></label>
                <select id="semester" name="semester" class="form-control" required>
                    <option value="">-- Pilih Semester --</option>
                    @for ($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                    @endfor
                </select>
                @error('semester')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display:flex; justify-content: flex-end; gap: 10px; margin-top: 24px;">
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Mahasiswa (Eloquent)</button>
            </div>
        </form>
    </div>
@endsection
