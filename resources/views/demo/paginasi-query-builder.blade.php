@extends('layouts.app')

@section('judul', 'Paginasi Data Mahasiswa via Query Builder')

@section('konten')
    <div class="page-header">
        <div>
            <h1 class="page-title">Paginasi Query Builder: ->paginate(5)</h1>
            <p class="page-subtitle">Demonstrasi Praktikum 5 Tugas Mandiri No. 3</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('demo.qb.all') }}" class="btn btn-secondary">&laquo; Kembali ke Demo QB</a>
            <a href="{{ route('demo.qb.crud') }}" class="btn btn-primary">Demo CRUD QB &rarr;</a>
        </div>

    </div>

    <!-- Alert Edukasi Query Builder Pagination -->
    <div class="card" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(14, 165, 233, 0.05)); border-color: rgba(79, 70, 229, 0.2); margin-bottom: 24px;">
        <h4 style="color: var(--primary); font-size: 1rem; margin-bottom: 8px;">📄 Pagination Query Builder Otomatis</h4>
        <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 8px;">
            Laravel Query Builder mendukung paginasi data secara otomatis dengan memanggil <code>-&gt;paginate(5)</code>.
            Laravel otomatis meng-handle perhitungan SQL <code>LIMIT 5 OFFSET ...</code> serta total records SQL <code>COUNT(*)</code>.
            Di Blade, kita merender navigasi halaman menggunakan sintaks: <code>&#123;&#123; $data-&gt;links() &#125;&#125;</code>.
        </p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📋 Daftar Mahasiswa (Halaman {{ $data->currentPage() }} dari {{ $data->lastPage() }})</h3>
            <span class="badge badge-info">Total: {{ $data->total() }} Mahasiswa</span>
        </div>

        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Program Studi</th>
                        <th>Semester</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr class="{{ $loop->even ? 'baris-genap' : 'baris-ganjil' }}">
                            <td>{{ $data->firstItem() + $loop->index }}</td>
                            <td><code>{{ $item->nim }}</code></td>
                            <td><strong>{{ $item->nama }}</strong></td>
                            <td>{{ $item->email ?? '-' }}</td>
                            <td>{{ $item->prodi }}</td>
                            <td><span class="badge badge-primary">Semester {{ $item->semester }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 24px; color: var(--text-muted);">
                                Belum ada data mahasiswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Render Laravel Pagination Links -->
        <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <div style="color: var(--text-muted); font-size: 0.88rem;">
                Menampilkan data <strong>{{ $data->firstItem() ?? 0 }}</strong> sampai <strong>{{ $data->lastItem() ?? 0 }}</strong> dari total <strong>{{ $data->total() }}</strong> mahasiswa
            </div>
            <div>
                {{ $data->links() }}
            </div>
        </div>
    </div>
@endsection
