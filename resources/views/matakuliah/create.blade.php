@extends('layouts.app')

@section('judul', 'Tambah Mata Kuliah Baru')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Mata Kuliah Baru</h1>
            <p class="page-subtitle">Formulir penyimpanan data kurikulum menggunakan Eloquent ORM (Praktikum 3 &amp; 7)</p>
        </div>
        <a href="{{ route('matakuliah.index') }}" class="btn btn-secondary">&laquo; Kembali ke Daftar</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 20px;">
            <strong>⚠️ Terjadi Kesalahan Validasi:</strong>
            <ul style="margin: 8px 0 0 20px; font-size: 0.9rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="max-width: 760px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="card-title">📝 Formulir Mata Kuliah</h3>
            <span class="badge badge-primary">Eloquent Create</span>
        </div>

        <form action="{{ route('matakuliah.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="kode_mk">Kode Mata Kuliah <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="kode_mk" name="kode_mk" class="form-control" value="{{ old('kode_mk') }}" placeholder="Contoh: IF201" required>
                    <small style="color: var(--text-muted); font-size: 0.75rem;">Harus unik, huruf kapital &amp; angka.</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="nama_mk">Nama Mata Kuliah <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="nama_mk" name="nama_mk" class="form-control" value="{{ old('nama_mk') }}" placeholder="Contoh: Pemrograman Web Lanjut" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="sks">Bobot SKS <span style="color:var(--danger)">*</span></label>
                    <select id="sks" name="sks" class="form-control" required>
                        <option value="">-- Pilih Bobot SKS --</option>
                        @for ($s = 1; $s <= 6; $s++)
                            <option value="{{ $s }}" {{ old('sks') == $s ? 'selected' : '' }}>{{ $s }} SKS</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="semester">Paket Semester <span style="color:var(--danger)">*</span></label>
                    <select id="semester" name="semester" class="form-control" required>
                        <option value="">-- Pilih Semester --</option>
                        @for ($sem = 1; $sem <= 8; $sem++)
                            <option value="{{ $sem }}" {{ old('semester') == $sem ? 'selected' : '' }}>Semester {{ $sem }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="dosen_pengampu">Dosen Pengampu</label>
                <input type="text" id="dosen_pengampu" name="dosen_pengampu" class="form-control" value="{{ old('dosen_pengampu') }}" placeholder="Contoh: Dr. Ir. Budi Santoso, M.Kom.">
            </div>

            <div class="form-group">
                <label class="form-label" for="deskripsi">Deskripsi Mata Kuliah</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" placeholder="Uraian singkat pokok bahasan dan capaian pembelajaran...">{{ old('deskripsi') }}</textarea>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Simpan Mata Kuliah</button>
                <a href="{{ route('matakuliah.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
