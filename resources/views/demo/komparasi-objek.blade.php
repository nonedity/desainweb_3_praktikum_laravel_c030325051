@extends('layouts.app')

@section('judul', 'Komparasi Objek: stdClass vs Eloquent Model')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Komparasi Objek: stdClass vs Eloquent Model</h1>
            <p class="page-subtitle">Demonstrasi Praktikum 6: Membandingkan Tipe Data Kembalian Query Builder dan Model Eloquent</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('demo.qb.komparasi') }}" class="btn btn-secondary">&laquo; Komparasi Database</a>
            <a href="{{ route('demo.eloquent.eager') }}" class="btn btn-primary">Demo Eager Loading &rarr;</a>
        </div>

    </div>

    <!-- Alert Edukasi Praktikum 6 -->
    <div class="card" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(14, 165, 233, 0.05)); border-color: rgba(79, 70, 229, 0.2); margin-bottom: 24px;">
        <h4 style="color: var(--primary); font-size: 1rem; margin-bottom: 8px;">💡 Inti Perbedaan Return Value</h4>
        <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 8px;">
            Ketika menggunakan <strong>Query Builder</strong> (<code>DB::table('mahasiswas')->first()</code>), Laravel mengembalikan objek generik bawaan PHP yaitu <code>stdClass</code>. Objek ini hanyalah penampung nilai kolom tanpa method atau kecerdasan bisnis.
        </p>
        <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 0;">
            Sebaliknya, <strong>Eloquent ORM</strong> (<code>Mahasiswa::first()</code>) mengembalikan instance objek yang mewarisi <code>Illuminate\Database\Eloquent\Model</code>. Objek ini kaya akan fitur: mendukung <em>Accessors/Mutators</em> (seperti <code>$mahasiswa-&gt;status</code>), <em>Relasi</em> (seperti <code>$mahasiswa-&gt;nilai</code>), objek tanggal <em>Carbon</em>, dan <em>Domain Logic</em>.
        </p>
    </div>

    <div class="grid-2" style="align-items: flex-start; margin-bottom: 24px;">
        <!-- Kolom 1: Query Builder stdClass -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">1. Query Builder (DB::table)</h3>
                <span class="badge badge-secondary">stdClass</span>
            </div>

            <div style="padding: 12px; background: #f8fafc; border-radius: var(--radius-sm); border: 1px solid var(--border-color); margin-bottom: 16px;">
                <p style="font-size: 0.85rem; margin: 0; color: var(--text-muted);">
                    Eksekusi: <code>$qbObj = DB::table('mahasiswas')->first();</code>
                </p>
                <p style="font-size: 0.9rem; margin: 6px 0 0 0; color: var(--text-main);">
                    Kelas Objek (<code>get_class</code>): <strong><code>{{ $qbClass }}</code></strong>
                </p>
            </div>

            <h4 style="font-size: 0.95rem; margin-bottom: 8px; color: var(--text-main);">Karakteristik &amp; Keterbatasan:</h4>
            <ul style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 16px; padding-left: 20px;">
                <li>Tipe: <code>stdClass</code> (PHP generic class).</li>
                <li><strong>Tidak memiliki Accessor:</strong> Memanggil <code>$qbObj-&gt;status</code> akan memicu <em>Undefined property error</em>.</li>
                <li><strong>Tidak memiliki Relasi:</strong> Tidak bisa memanggil <code>$qbObj-&gt;nilai</code>.</li>
                <li><strong>Tanggal mentah:</strong> <code>created_at</code> bertipe string mentah (contoh: <code>{{ $qbObj->created_at ?? '-' }}</code>), bukan instance Carbon sehingga tidak bisa diformat langsung dengan <code>-&gt;format('d F Y')</code>.</li>
            </ul>

            <h4 style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 6px;">Dump Properti:</h4>
            <div class="query-box">
                <pre style="margin:0; font-size:0.8rem; color:#cbd5e1;">{{ json_encode($qbObj, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>

        <!-- Kolom 2: Eloquent Model -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">2. Eloquent ORM (Model)</h3>
                <span class="badge badge-success">Eloquent Model</span>
            </div>

            <div style="padding: 12px; background: #f8fafc; border-radius: var(--radius-sm); border: 1px solid var(--border-color); margin-bottom: 16px;">
                <p style="font-size: 0.85rem; margin: 0; color: var(--text-muted);">
                    Eksekusi: <code>$elObj = Mahasiswa::with('nilai.matakuliah')->first();</code>
                </p>
                <p style="font-size: 0.9rem; margin: 6px 0 0 0; color: var(--text-main);">
                    Kelas Objek (<code>get_class</code>): <strong><code>{{ $elClass }}</code></strong>
                </p>
            </div>

            <h4 style="font-size: 0.95rem; margin-bottom: 8px; color: var(--text-main);">Karakteristik &amp; Keunggulan:</h4>
            <ul style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 16px; padding-left: 20px;">
                <li>Tipe: <code>App\Models\Mahasiswa</code> (Active Record Model).</li>
                <li><strong>Dukungan Accessor:</strong> <code>$elObj-&gt;status</code> otomatis menghasilkan string: <span class="badge badge-primary">{{ $elObj->status ?? '-' }}</span>.</li>
                <li><strong>Dukungan Relasi:</strong> <code>$elObj-&gt;nilai-&gt;count()</code> berhasil memuat {{ $elObj->nilai->count() ?? 0 }} relasi nilai.</li>
                <li><strong>Carbon Datetime:</strong> <code>$elObj-&gt;created_at-&gt;format('d F Y')</code> menghasilkan: <strong>{{ $elObj->created_at ? $elObj->created_at->format('d F Y') : '-' }}</strong>.</li>
            </ul>

            <h4 style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 6px;">Uji Coba Fitur Model:</h4>
            <table class="custom-table" style="font-size: 0.85rem;">
                <tbody>
                    <tr>
                        <th>$elObj->nama</th>
                        <td><strong>{{ $elObj->nama }}</strong></td>
                    </tr>
                    <tr>
                        <th>$elObj->status (Accessor)</th>
                        <td><span class="badge badge-info">{{ $elObj->status }}</span></td>
                    </tr>
                    <tr>
                        <th>$elObj->nilai->count()</th>
                        <td><span class="badge badge-success">{{ $elObj->nilai->count() }} Mata Kuliah</span></td>
                    </tr>
                    <tr>
                        <th>$elObj->created_at->diffForHumans()</th>
                        <td>{{ $elObj->created_at ? $elObj->created_at->diffForHumans() : '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
