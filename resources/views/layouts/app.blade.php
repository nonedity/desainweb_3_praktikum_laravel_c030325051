<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Modul Praktikum Laravel 13 - Controller serta Interaksi Database dengan Query Builder & Eloquent">
    <meta name="author" content="Mahasiswa Pemrograman Web">
    <title>@yield('judul', 'SIAKAD Controller & Database') | Laravel 13</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Modern Vanilla CSS Design System -->
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #e0e7ff;
            --secondary: #06b6d4;
            --accent: #8b5cf6;
            --bg-body: #f8fafc;
            --bg-surface: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --border-color: #e2e8f0;
            --success: #10b981;
            --success-bg: #ecfdf5;
            --warning: #f59e0b;
            --warning-bg: #fffbeb;
            --danger: #ef4444;
            --danger-bg: #fef2f2;
            --info: #0284c7;
            --info-bg: #f0f9ff;
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-full: 9999px;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(6, 182, 212, 0.06) 0px, transparent 50%);
            background-attachment: fixed;
        }

        /* Top Announcement Bar */
        .topbar {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            color: #ffffff;
            padding: 10px 24px;
            font-size: 0.85rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar-badge {
            background: rgba(255, 255, 255, 0.16);
            padding: 3px 10px;
            border-radius: var(--radius-full);
            font-weight: 700;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-sm);
        }
        .navbar-container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 24px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text-main);
            font-size: 1.15rem;
            font-weight: 700;
        }
        .navbar-brand strong {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .brand-icon {
            font-size: 1.5rem;
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.88rem;
            font-weight: 500;
            transition: var(--transition);
        }
        .nav-link:hover {
            color: var(--primary);
            background: var(--primary-light);
        }
        .nav-link.active {
            color: var(--primary);
            background: var(--primary-light);
            font-weight: 700;
        }
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Main Container */
        .main-content {
            flex: 1;
            max-width: 1240px;
            width: 100%;
            margin: 0 auto;
            padding: 32px 24px;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 16px;
        }
        .page-title {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
        }
        .page-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-top: 4px;
        }

        /* Cards */
        .card {
            background: var(--bg-surface);
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            padding: 24px;
            margin-bottom: 24px;
            transition: var(--transition);
        }
        .card:hover {
            box-shadow: var(--shadow-md);
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border-color);
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 18px;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: var(--radius-sm);
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
            font-family: inherit;
        }
        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
        }
        .btn-primary {
            background: var(--primary);
            color: #ffffff;
        }
        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
        }
        .btn-secondary {
            background: #ffffff;
            color: var(--text-main);
            border-color: var(--border-color);
        }
        .btn-secondary:hover {
            background: #f1f5f9;
            color: var(--primary);
        }
        .btn-danger {
            background: var(--danger);
            color: #ffffff;
        }
        .btn-danger:hover {
            background: #dc2626;
        }
        .btn-info {
            background: var(--info);
            color: #ffffff;
        }
        .btn-success {
            background: var(--success);
            color: #ffffff;
        }

        /* Tables */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-color);
        }
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.92rem;
        }
        .custom-table th {
            background-color: #f8fafc;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 14px 16px;
            border-bottom: 2px solid var(--border-color);
        }
        .custom-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            color: var(--text-main);
        }
        .custom-table tr:last-child td {
            border-bottom: none;
        }
        .custom-table tr:hover {
            background-color: #f8fafc !important;
        }
        .baris-genap {
            background-color: #f8fafc;
        }
        .baris-ganjil {
            background-color: #ffffff;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 700;
            line-height: 1;
        }
        .badge-primary {
            background: var(--primary-light);
            color: var(--primary);
        }
        .badge-success {
            background: var(--success-bg);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        .badge-warning {
            background: var(--warning-bg);
            color: #b45309;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }
        .badge-info {
            background: var(--info-bg);
            color: var(--info);
            border: 1px solid rgba(2, 132, 199, 0.2);
        }
        .badge-purple {
            background: #f3e8ff;
            color: #7e22ce;
            border: 1px solid rgba(126, 34, 206, 0.2);
        }
        .badge-danger {
            background: var(--danger-bg);
            color: var(--danger);
        }

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.92rem;
            border-left: 4px solid transparent;
        }
        .alert-success {
            background: var(--success-bg);
            color: #065f46;
            border-left-color: var(--success);
        }
        .alert-info {
            background: var(--info-bg);
            color: #075985;
            border-left-color: var(--info);
        }
        .alert-warning {
            background: var(--warning-bg);
            color: #92400e;
            border-left-color: var(--warning);
        }
        .alert-danger {
            background: var(--danger-bg);
            color: #991b1b;
            border-left-color: var(--danger);
        }

        /* Forms */
        .form-group {
            margin-bottom: 18px;
        }
        .form-label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-main);
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-color);
            background: #ffffff;
            font-family: inherit;
            font-size: 0.92rem;
            color: var(--text-main);
            transition: var(--transition);
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }
        .form-error {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 4px;
        }

        /* Grid */
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
        }
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
        }
        .grid-4 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        /* Stat Widget */
        .stat-card {
            background: var(--bg-surface);
            border-radius: var(--radius-md);
            padding: 20px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: var(--primary-light);
            color: var(--primary);
        }
        .stat-number {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.2;
        }
        .stat-label {
            font-size: 0.82rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Query Log Box */
        .query-log-box {
            background: #0f172a;
            color: #f8fafc;
            padding: 16px 20px;
            border-radius: var(--radius-sm);
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.86rem;
            line-height: 1.5;
            overflow-x: auto;
            border-left: 4px solid var(--secondary);
            margin-top: 14px;
        }
        .query-log-item {
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .query-log-item:last-child {
            border-bottom: none;
        }
        .query-sql {
            color: #38bdf8;
        }
        .query-time {
            color: #fbbf24;
            font-size: 0.78rem;
        }

        /* Footer */
        .footer {
            background: #ffffff;
            border-top: 1px solid var(--border-color);
            padding: 24px;
            margin-top: auto;
            color: var(--text-muted);
            font-size: 0.85rem;
        }
        .footer-container {
            max-width: 1240px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }
        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            margin-left: 16px;
            transition: var(--transition);
        }
        .footer-links a:hover {
            color: var(--primary);
        }

        /* Code & Pre */
        code {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.85em;
            color: #c026d3;
        }
        pre {
            background: #0f172a;
            color: #f8fafc;
            padding: 16px;
            border-radius: var(--radius-sm);
            overflow-x: auto;
            font-size: 0.88rem;
            line-height: 1.5;
        }

        /* Pagination custom style */
        .pagination {
            display: flex;
            gap: 6px;
            list-style: none;
            margin-top: 20px;
            justify-content: center;
        }
        .pagination li a, .pagination li span {
            padding: 8px 14px;
            border: 1px solid var(--border-color);
            background: #ffffff;
            color: var(--text-main);
            text-decoration: none;
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            font-weight: 600;
        }
        .pagination li.active span {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="topbar">
        <div style="display:flex; align-items:center; gap: 12px;">
            <span class="topbar-badge">MODUL 4</span>
            <span>Pemrograman Web: <strong>Controller, Query Builder, dan Eloquent ORM (Laravel 13)</strong></span>
        </div>
        <div>
            <span>PHP {{ PHP_VERSION }} | Laravel {{ app()->version() }}</span>
        </div>
    </div>

    {{-- Master Navbar via @include --}}
    @include('partials.navbar')

    <!-- Main Content Slot via @yield('konten') -->
    <main class="main-content">
        {{-- Flash Notification --}}
        @if (session('pesan'))
            <div class="alert alert-success">
                <span>✅ {{ session('pesan') }}</span>
                <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;font-size:1.1rem;color:inherit;">&times;</button>
            </div>
        @endif

        @yield('konten')
    </main>

    <!-- Master Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div>
                <p>&copy; {{ date('Y') }} <strong>SIAKAD Controller &amp; Database</strong> — Modul Praktikum Laravel 13</p>
                <p style="font-size: 0.78rem; color: var(--text-light); margin-top: 4px;">
                    Dikerjakan komprehensif mencakup Praktikum 1 s/d 7 &amp; Proyek Akhir (Controller, Query Builder, Eloquent).
                </p>
            </div>
            <div class="footer-links">
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('mahasiswa.index') }}">Mahasiswa</a>
                <a href="{{ route('matakuliah.index') }}">Mata Kuliah</a>
                <a href="{{ route('demo.qb.komparasi') }}">Query Builder</a>
                <a href="{{ route('demo.eloquent.eager') }}">Eager Loading</a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
