@extends('layouts.app')

@section('judul', 'Detail Mata Kuliah - ' . $matakuliah->nama_mk)

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Mata Kuliah &amp; Mahasiswa Terdaftar</h1>
            <p class="page-subtitle">Demonstrasi Route Model Binding &amp; Relasi Eloquent hasMany nilai.mahasiswa (Praktikum 3 &amp; 7)</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('matakuliah.index') }}" class="btn btn-secondary">&laquo; Kembali ke Daftar</a>
            <a href="{{ route('matakuliah.edit', $matakuliah->id) }}" class="btn btn-primary">Edit Mata Kuliah</a>
        </div>
    </div>

    <div class="grid-3" style="align-items: flex-start; margin-bottom: 24px;">
        <!-- Card 1: Informasi Mata Kuliah -->
        <div class="card" style="grid-column: span 1;">
            <div class="card-header">
                <h3 class="card-title">📚 Info Mata Kuliah</h3>
                <span class="badge badge-info">{{ $matakuliah->sks }} SKS</span>
            </div>

            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                <div style="width: 64px; height: 64px; border-radius: var(--radius-sm); background: linear-gradient(135deg, var(--secondary), var(--primary)); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800;">
                    {{ substr($matakuliah->kode_mk, 0, 2) }}
                </div>
                <div>
                    <h3 style="font-size: 1.15rem; color: var(--text-main); line-height: 1.2;">{{ $matakuliah->nama_mk }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 4px;">Kode: <code>{{ $matakuliah->kode_mk }}</code></p>
                </div>
            </div>

            <table class="custom-table" style="font-size: 0.88rem;">
                <tbody>
                    <tr>
                        <th style="width: 40%;">Bobot SKS</th>
                        <td><strong>{{ $matakuliah->sks }} SKS</strong></td>
                    </tr>
                    <tr>
                        <th>Paket Semester</th>
                        <td><span class="badge badge-primary">Semester {{ $matakuliah->semester }}</span></td>
                    </tr>
                    <tr>
                        <th>Dosen Pengampu</th>
                        <td>{{ $matakuliah->dosen_pengampu ?? 'Belum ditentukan' }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $matakuliah->deskripsi ?? 'Tidak ada ringkasan deskripsi silabus.' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Card 2: Relasi Mahasiswa yang Mengambil Mata Kuliah (Praktikum 7 Tugas Mandiri) -->
        <div class="card" style="grid-column: span 2;">
            <div class="card-header">
                <h3 class="card-title">👥 Mahasiswa Terdaftar (Relasi hasMany nilai &rarr; mahasiswa)</h3>
                <span class="badge badge-success">{{ $matakuliah->nilai->count() }} Mahasiswa</span>
            </div>

            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 16px;">
                Daftar mahasiswa berikut diperoleh melalui relasi Eloquent terbalik: <code>$matakuliah-&gt;nilai</code> yang di-eager load dengan <code>load('nilai.mahasiswa')</code>.
            </p>

            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Program Studi</th>
                            <th>Semester</th>
                            <th>Nilai</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($matakuliah->nilai as $n)
                            <tr class="{{ $loop->even ? 'baris-genap' : 'baris-ganjil' }}">
                                <td>{{ $loop->iteration }}</td>
                                <td><code>{{ $n->mahasiswa->nim ?? '-' }}</code></td>
                                <td>
                                    <a href="{{ isset($n->mahasiswa) ? route('mahasiswa.show', $n->mahasiswa->id) : '#' }}" style="font-weight: 600; color: var(--primary); text-decoration: none;">
                                        {{ $n->mahasiswa->nama ?? 'Mahasiswa tidak ditemukan' }}
                                    </a>
                                </td>
                                <td>{{ $n->mahasiswa->prodi ?? '-' }}</td>
                                <td><span class="badge badge-info">Sem {{ $n->mahasiswa->semester ?? '-' }}</span></td>
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
                                    Belum ada mahasiswa yang mengambil mata kuliah ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($matakuliah->nilai->isNotEmpty())
                <div style="margin-top: 16px; padding: 12px 16px; background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-sm); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <div>
                        <span style="font-size: 0.88rem; color: var(--text-muted);">Total Mahasiswa:</span>
                        <strong style="color: var(--primary); font-size: 1.05rem; margin-left: 6px;">
                            {{ $matakuliah->nilai->count() }} Orang
                        </strong>
                    </div>
                    <div>
                        <span style="font-size: 0.88rem; color: var(--text-muted);">Rata-rata Nilai Kelas:</span>
                        <strong style="color: var(--success); font-size: 1.05rem; margin-left: 6px;">
                            {{ number_format($matakuliah->nilai->avg('nilai'), 2) }}
                        </strong>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
