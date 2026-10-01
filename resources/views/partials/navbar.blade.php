<nav class="navbar">
    <div class="navbar-container">
        <a href="{{ route('home') }}" class="navbar-brand">
            <span class="brand-icon">⚡</span>
            <span class="brand-text">SIAKAD <strong>Controller &amp; DB</strong></span>
        </a>

        <div class="nav-links">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <span class="nav-icon">🏠</span> Beranda
            </a>
            <a href="{{ route('mahasiswa.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.*') && !request()->routeIs('mahasiswa.uji.*') && !request()->routeIs('mahasiswa.cari') ? 'active' : '' }}">
                <span class="nav-icon">👨‍🎓</span> Mahasiswa
            </a>
            <a href="{{ route('matakuliah.index') }}" class="nav-link {{ request()->routeIs('matakuliah.*') && !request()->routeIs('matakuliah.total-sks') ? 'active' : '' }}">
                <span class="nav-icon">📚</span> Mata Kuliah
            </a>
            <a href="{{ route('demo.qb.komparasi') }}" class="nav-link {{ request()->routeIs('demo.qb.*') ? 'active' : '' }}">
                <span class="nav-icon">🔍</span> Query Builder
            </a>
            <a href="{{ route('demo.eloquent.eager') }}" class="nav-link {{ request()->routeIs('demo.eloquent.*') ? 'active' : '' }}">
                <span class="nav-icon">🚀</span> Eager Loading
            </a>
            <a href="{{ route('statistik.mahasiswa') }}" class="nav-link {{ request()->routeIs('statistik.mahasiswa') ? 'active' : '' }}">
                <span class="nav-icon">📊</span> Statistik
            </a>
            <a href="{{ route('laporan.rekap') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <span class="nav-icon">📑</span> Laporan
            </a>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                <span class="nav-icon">⚙️</span> Admin
            </a>
        </div>

        <div class="nav-actions">
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-sm btn-primary">
                + Mahasiswa
            </a>
        </div>
    </div>
</nav>
