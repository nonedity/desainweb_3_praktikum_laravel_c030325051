@extends('layouts.app')

@section('judul', 'Edit Mahasiswa - ' . $mahasiswa->nama)

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Data Mahasiswa</h1>
            <p class="page-subtitle">Pembaruan Data Menggunakan Method Eloquent <code>$mahasiswa-&gt;update()</code> (Praktikum 7)</p>
        </div>
        <div>
            <a href="{{ route('mahasiswa.show', $mahasiswa->id) }}" class="btn btn-secondary">&laquo; Kembali</a>
        </div>
    </div>

    <div class="card" style="max-width: 650px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="card-title">✏️ Perbarui Data: {{ $mahasiswa->nama }}</h3>
        </div>

        <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nim" class="form-label">Nomor Induk Mahasiswa (NIM) <span style="color:var(--danger)">*</span></label>
                <input type="text" id="nim" name="nim" class="form-control" value="{{ old('nim', $mahasiswa->nim) }}" required>
                @error('nim')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama" class="form-label">Nama Lengkap <span style="color:var(--danger)">*</span></label>
                <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', $mahasiswa->nama) }}" required>
                @error('nama')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $mahasiswa->email) }}">
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="prodi" class="form-label">Program Studi <span style="color:var(--danger)">*</span></label>
                <select id="prodi" name="prodi" class="form-control" required>
                    @foreach (['Teknik Informatika', 'Sistem Informasi', 'Teknologi Informasi', 'Ilmu Komputer'] as $prodi)
                        <option value="{{ $prodi }}" {{ old('prodi', $mahasiswa->prodi) == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                    @endforeach
                </select>
                @error('prodi')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="semester" class="form-label">Semester <span style="color:var(--danger)">*</span></label>
                <select id="semester" name="semester" class="form-control" required>
                    @for ($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ old('semester', $mahasiswa->semester) == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                    @endfor
                </select>
                @error('semester')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display:flex; justify-content: flex-end; gap: 10px; margin-top: 24px;">
                <a href="{{ route('mahasiswa.show', $mahasiswa->id) }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan (Eloquent)</button>
            </div>
        </form>
    </div>
@endsection
