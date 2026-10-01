@extends('layouts.app')

@section('judul', 'Form Uji Request & Proteksi @csrf - Praktikum 2')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Form Uji Penerimaan Request</h1>
            <p class="page-subtitle">Demonstrasi Praktikum 2: Dependency Injection <code>Request $request</code> &amp; Proteksi Wajib <code>@@csrf</code></p>
        </div>
        <div>
            <a href="{{ route('home') }}" class="btn btn-secondary">&laquo; Beranda</a>
        </div>
    </div>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="card-title">🛡️ Uji Request POST dengan Directive @@csrf</h3>
            <span class="badge badge-success">CSRF Protection Active</span>
        </div>

        <div style="background: var(--info-bg); border-left: 4px solid var(--info); padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px; font-size: 0.88rem; color: #075985;">
            <strong>Mengapa directive <code>@@csrf</code> wajib?</strong><br>
            Directive ini menyisipkan hidden input berisi token acak yang diverifikasi oleh middleware Laravel untuk mencegah serangan <em>Cross-Site Request Forgery</em> dari situs pihak ketiga yang berniat jahat.
        </div>

        <form action="{{ route('mahasiswa.uji.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nim" class="form-label">Nomor Induk Mahasiswa (NIM)</label>
                <input type="text" id="nim" name="nim" class="form-control" placeholder="Masukkan NIM (contoh: 2024010099)" required>
            </div>

            <div class="form-group">
                <label for="nama" class="form-label">Nama Mahasiswa</label>
                <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap" required>
            </div>

            <div style="margin-top: 20px; display:flex; justify-content:flex-end;">
                <button type="submit" class="btn btn-primary">Kirim Request POST</button>
            </div>
        </form>
    </div>
@endsection
