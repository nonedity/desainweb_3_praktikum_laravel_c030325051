@extends('layouts.app')

@section('judul', '404 - Halaman Tidak Ditemukan')

@section('konten')
    <div style="text-align: center; padding: 60px 20px;">
        <div style="font-size: 5rem; font-weight: 900; color: var(--primary); line-height: 1; margin-bottom: 16px;">
            404
        </div>
        <h2 style="font-size: 1.75rem; color: var(--text-main); margin-bottom: 12px;">Halaman Tidak Ditemukan</h2>
        <p style="color: var(--text-muted); max-width: 500px; margin: 0 auto 24px; font-size: 0.95rem; line-height: 1.6;">
            Mohon maaf, halaman atau data entitas yang Anda cari tidak tersedia atau rute URL salah.
        </p>
        <div style="display: flex; justify-content: center; gap: 12px;">
            <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Data Mahasiswa</a>
        </div>
    </div>
@endsection
