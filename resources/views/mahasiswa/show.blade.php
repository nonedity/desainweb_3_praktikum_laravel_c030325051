@extends('layouts.app')

@section('judul', 'Detail Mahasiswa - ' . $mahasiswa->nama)

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Mahasiswa &amp; Kartu Hasil Studi</h1>
            <p class="page-subtitle">Demonstrasi Route Model Binding, Accessor Status, dan Relasi Eloquent hasMany (Praktikum 3 &amp; 7)</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">&laquo; Kembali ke Daftar</a>
            <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-primary">Edit Mahasiswa</a>
        </div>
    </div>

    <div class="grid-3" style="align-items: flex-start; margin-bottom: 24px;">
        <!-- Card 1: Biodata Mahasiswa -->
        <div class="card" style="grid-column: span 1;">
            <div class="card-header">
                <h3 class="card-title">👤 Profil Akademik</h3>
                @if ($mahasiswa->semester >= 7)
                    <span class="badge badge-warning">{{ $mahasiswa->status }}</span>
                @elseif ($mahasiswa->semester <= 2)
                    <span class="badge badge-success">{{ $mahasiswa->status }}</span>
                @else
                    <span class="badge badge-primary">{{ $mahasiswa->status }}</span>
                @endif
            </div>

            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                <div style="width: 64px; height: 64px; border-radius: var(--radius-sm); background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 800;">
                    {{ substr($mahasiswa->nama, 0, 1) }}
                </div>
                <div>
                    <h3 style="font-size: 1.15rem; color: var(--text-main); line-height: 1.2;">{{ $mahasiswa->nama }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 4px;">NIM: <code>{{ $mahasiswa->nim }}</code></p>
                </div>
            </div>

            <table class="custom-table" style="font-size: 0.88rem;">
                <tbody>
                    <tr>
                        <th style="width: 40%;">Program Studi</th>
                        <td>{{ $mahasiswa->prodi }}</td>
                    </tr>
                    <tr>
                        <th>Semester</th>
                        <td><span class="badge badge-info">Semester {{ $mahasiswa->semester }}</span></td>
                    </tr>
                    <tr>
                        <th>Status Tingkat</th>
                        <td><strong>{{ $mahasiswa->status }}</strong> (via Accessor)</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $mahasiswa->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Terdaftar Sejak</th>
                        <td>{{ $mahasiswa->created_at ? $mahasiswa->created_at->format('d M Y') : '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Card 2: Relasi Nilai Mata Kuliah (Praktikum 7) -->
        <div class="card" style="grid-column: span 2;">
            <div class="card-header">
                <h3 class="card-title">📖 Nilai Mata Kuliah yang Diambil (Relasi hasMany)</h3>
                <span class="badge badge-primary">{{ $mahasiswa->nilai->count() }} Mata Kuliah</span>
            </div>

            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 16px;">
                Data di bawah ini diambil melalui pemanggilan relasi Eloquent: <code>$mahasiswa-&gt;nilai</code> yang di-eager load dengan <code>load('nilai.matakuliah')</code>.
            </p>

            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode MK</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Dosen Pengampu</th>
                            <th>Nilai Angka</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mahasiswa->nilai as $n)
                            <tr class="{{ $loop->even ? 'baris-genap' : 'baris-ganjil' }}">
                                <td>{{ $loop->iteration }}</td>
                                <td><code>{{ $n->matakuliah->kode_mk ?? '-' }}</code></td>
                                <td>
                                    <strong>{{ $n->matakuliah->nama_mk ?? '-' }}</strong>
                                </td>
                                <td>{{ $n->matakuliah->sks ?? 0 }} SKS</td>
                                <td><small>{{ $n->matakuliah->dosen_pengampu ?? '-' }}</small></td>
                                <td><strong>{{ number_format($n->nilai, 1) }}</strong></td>
                                <td>
                                    @if ($n->grade == 'A' || $n->grade == 'A-')
                                        <span class="badge badge-success">{{ $n->grade }}</span>
                                    @elseif (str_starts_with($n->grade, 'B'))
                                        <span class="badge badge-info">{{ $n->grade }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ $n->grade }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 24px; color: var(--text-muted);">
                                    Belum ada data nilai mata kuliah untuk mahasiswa ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($mahasiswa->nilai->isNotEmpty())
                <div style="margin-top: 16px; padding: 12px 16px; background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-sm); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <div>
                        <span style="font-size: 0.88rem; color: var(--text-muted);">Total SKS Diambil:</span>
                        <strong style="color: var(--primary); font-size: 1.05rem; margin-left: 6px;">
                            {{ $mahasiswa->nilai->sum(fn($n) => $n->matakuliah->sks ?? 0) }} SKS
                        </strong>
                    </div>
                    <div>
                        <span style="font-size: 0.88rem; color: var(--text-muted);">Rata-rata Nilai:</span>
                        <strong style="color: var(--success); font-size: 1.05rem; margin-left: 6px;">
                            {{ number_format($mahasiswa->nilai->avg('nilai'), 2) }}
                        </strong>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
