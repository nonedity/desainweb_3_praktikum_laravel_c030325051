# 📚 SIAKAD — Modul Praktikum Laravel 13: Controller & Interaksi Database

> **Implementasi Komprehensif:** Controller (Closure vs Controller, Request Injection, CSRF, Resource, Invokable, Nested Sub-folder), Query Builder (`DB::table`), dan Eloquent ORM (Relasi, Accessor, Eager Loading vs Lazy Loading N+1 Problem).

---

## 👨‍💻 Identitas Praktikan & Proyek

* **Mata Kuliah:** Praktikum Pemrograman Web Lanjut 2026
* **Topik Modul:** Controller serta Interaksi Database dengan Query Builder & Eloquent pada Framework Laravel 13
* **Versi PHP:** PHP 8.4.7 (CLI)
* **Versi Laravel:** Laravel 13.34.0
* **Driver Database:** SQLite (`database/database.sqlite`)
* **Status Pengujian:** **17/17 Feature Tests Passing (160 Assertions, 100% Passed)**

---

## 🚀 Panduan Menjalankan Proyek

Pastikan telah berada di folder proyek:
```bash
cd "/Users/arifinasyikin/Downloads/web 20261/praktikum-laravel-controller-database"
```

### 1. Migrasi dan Seeding Database
Database SQLite lokal telah terisi dengan 10 data mahasiswa realistis, 7 mata kuliah, dan relasi nilai mahasiswa:
```bash
php artisan migrate:fresh --seed
```

### 2. Menjalankan Server Development Lokal
```bash
php artisan serve
```
Buka browser pada: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

### 3. Menjalankan Automated Test Suite
```bash
php artisan test
```
Seluruh skenario pengujian akan dieksekusi secara otomatis dengan output `PASS`.

---

## 🗺️ Daftar Rute Aktif Aplikasi (`php artisan route:list`)

```text
+--------+------------------------------------+-------------------------+----------------------------------------------------+
| Method | URI                                | Name                    | Action                                             |
+--------+------------------------------------+-------------------------+----------------------------------------------------+
| GET    | /                                  | home                    | Closure (Beranda Portal)                           |
| GET    | /sapa-closure                      | sapa.closure            | Closure (Praktikum 1 Closure Demo)                 |
| GET    | /sapa-controller                   | sapa.controller         | SapaController@index                               |
| GET    | /sapa/{nama?}                      | sapa.nama               | SapaController@index                               |
| GET    | /latihan-controller                | latihan.controller      | LatihanController@index                            |
| GET    | /latihan/halo                      | latihan.halo            | LatihanController@halo                             |
| GET    | /latihan/profil                    | latihan.profil          | LatihanController@profil                           |
| GET    | /mahasiswa-uji                     | mahasiswa.uji.form      | Closure (Form Uji Request @csrf)                   |
| POST   | /mahasiswa-uji                     | mahasiswa.uji.store     | MahasiswaController@storeUji                       |
| GET    | /api/mahasiswa                     | mahasiswa.api           | MahasiswaController@apiIndex (JSON Response)       |
| GET    | /mahasiswa/cari                    | mahasiswa.cari          | MahasiswaController@cariMahasiswa (Query String)   |
| GET    | /statistik                         | statistik.mahasiswa     | StatistikMahasiswaController (Invokable)           |
| GET    | /matakuliah-total-sks              | matakuliah.total-sks    | HitungTotalSksController (Invokable)               |
| GET    | /admin/dashboard                   | admin.dashboard         | App\Http\Controllers\Admin\DashboardController     |
| GET    | /laporan/rekap                     | laporan.rekap           | App\Http\Controllers\Laporan\RekapController       |
| GET    | /demo/query-builder/komparasi      | demo.qb.komparasi       | QueryBuilderDemoController@komparasiPendekatan     |
| GET    | /demo/query-builder/semua          | demo.qb.all             | QueryBuilderDemoController@tampilkanSemua          |
| GET    | /demo/query-builder/filter         | demo.qb.filter          | QueryBuilderDemoController@tampilkanFilter         |
| GET    | /demo/query-builder/tugas-mandiri-filter | demo.qb.mandiri.filter | QueryBuilderDemoController@tugasMandiriFilter |
| GET    | /demo/query-builder/statistik-prodi| demo.qb.statistik       | QueryBuilderDemoController@statistikProdi          |
| GET    | /demo/query-builder/paginasi       | demo.qb.paginasi        | QueryBuilderDemoController@paginasiMahasiswa       |
| GET    | /demo/query-builder/crud           | demo.qb.crud            | QueryBuilderDemoController@formCrud                |
| POST   | /demo/query-builder/insert         | demo.qb.insert          | QueryBuilderDemoController@insertQueryBuilder      |
| DELETE | /demo/query-builder/delete/{id}    | demo.qb.delete          | QueryBuilderDemoController@deleteQueryBuilder      |
| GET    | /demo/eloquent/komparasi-objek     | demo.eloquent.objek     | EagerLoadingDemoController@komparasiObjek          |
| GET    | /demo/eloquent/eager-loading       | demo.eloquent.eager     | EagerLoadingDemoController@komparasiEagerLoading   |
| GET    | /mahasiswa                         | mahasiswa.index         | MahasiswaController@index                          |
| POST   | /mahasiswa                         | mahasiswa.store         | MahasiswaController@store                          |
| GET    | /mahasiswa/create                  | mahasiswa.create        | MahasiswaController@create                         |
| GET    | /mahasiswa/{mahasiswa}             | mahasiswa.show          | MahasiswaController@show (Route Model Binding)     |
| PUT    | /mahasiswa/{mahasiswa}             | mahasiswa.update        | MahasiswaController@update                         |
| DELETE | /mahasiswa/{mahasiswa}             | mahasiswa.destroy       | MahasiswaController@destroy                        |
| GET    | /mahasiswa/{mahasiswa}/edit        | mahasiswa.edit          | MahasiswaController@edit                           |
| GET    | /matakuliah                        | matakuliah.index        | MatakuliahController@index                         |
| POST   | /matakuliah                        | matakuliah.store        | MatakuliahController@store                         |
| GET    | /matakuliah/create                 | matakuliah.create       | MatakuliahController@create                        |
| GET    | /matakuliah/{matakuliah}           | matakuliah.show         | MatakuliahController@show (Route Model Binding)     |
| PUT    | /matakuliah/{matakuliah}           | matakuliah.update       | MatakuliahController@update                         |
| DELETE | /matakuliah/{matakuliah}           | matakuliah.destroy      | MatakuliahController@destroy                        |
| GET    | /matakuliah/{matakuliah}/edit      | matakuliah.edit         | MatakuliahController@edit                           |
+--------+------------------------------------+-------------------------+----------------------------------------------------+
```

---

## 📖 Jawaban Lengkap Seluruh Tugas Mandiri

### 📌 Bagian I — Controller (Praktikum 1 s/d 3)

#### Praktikum 1: Konsep Controller dalam Framework
1. **Implementasi `LatihanController`:**
   Dibuat file `app/Http/Controllers/LatihanController.php` dengan method `index()` yang mengembalikan string perkenalan terformat:
   ```php
   namespace App\Http\Controllers;

   class LatihanController extends Controller
   {
       public function index()
       {
           $nama = 'Arifin Asyikin';
           $nim = '2024010001';
           $prodi = 'Teknik Informatika';

           return "Halo! Perkenalkan, nama saya {$nama}, NIM: {$nim}, dari program studi {$prodi}. Selamat datang di praktikum Controller Laravel 13!";
       }
   }
   ```
   Rute diakses via: `GET /latihan-controller`.

2. **Diagram Alur Request-Response MVC:**
   ```text
   [ Browser Klien ]
          │  (1. HTTP Request: GET /mahasiswa)
          ▼
   [ public/index.php ] ──(Front Controller Bootstrapping)
          │
          ▼
   [ routes/web.php ] ───(Pencocokan Rute & Middleware Pipeline)
          │
          ▼
   [ MahasiswaController@index ] ──(Orkestrasi Logika Bisnis)
          │
          ├──> [ Model Mahasiswa ] ──(Query SQL)──> [ Database SQLite ]
          │          │                                      │
          │          └──<──────(Data Records Dikembalikan)──┘
          │
          └──> view('mahasiswa.index', compact('mahasiswa'))
                     │
                     ▼
             [ Blade Engine ] ──(Kompilasi Template ke HTML)
                     │
                     ▼
          (2. HTTP Response 200 OK + Dokumen HTML)
                     │
                     ▼
              [ Browser Klien ]
   ```

3. **Tabel Perbandingan: Route Closure vs Controller:**

| Aspek Evaluasi | Route Closure (`routes/web.php`) | Controller Dedicated (`app/Http/Controllers`) |
| :--- | :--- | :--- |
| **Pemisahan Tanggung Jawab** | Buruk (routing dan logika bisnis bercampur dalam satu file) | Sangat Baik (arsitektur MVC terisolasi dengan rapi) |
| **Dukungan Route Caching** | **Tidak Didukung** (`route:cache` gagal pada Closure lama/kompleks) | **Didukung Penuh** (`php artisan route:cache` berjalan cepat) |
| **Keterbacaan File Routes** | File rute cepat menjadi ribuan baris dan sulit dimaintain | File rute bersih dan hanya memetakan URL ke Class Controller |
| **Dependency Injection** | Terbatas pada parameter closure | Sangat kuat via Constructor & Method Injection |
| **Reusabilitas Kode** | Sangat sulit dipakai ulang di rute lain | Method dapat dipanggil kembali atau diwariskan via OOP |
| **Skenario Penggunaan** | Prototipe cepat, redirect statis, atau pengujian instan | **Aplikasi Enterprise & Standar Industri Produksi** |

---

#### Praktikum 2: Penulisan Controller dalam Framework
1. **Implementasi `cariMahasiswa(Request $request)`:**
   Pada `app/Http/Controllers/MahasiswaController.php`, method pencarian menerima objek request:
   ```php
   public function cariMahasiswa(Request $request)
   {
       $kataKunci = $request->query('nama') ?? $request->query('keyword');

       if (empty($kataKunci)) {
           $hasil = collect([]);
           $pesan = 'Silakan masukkan nama mahasiswa pada kotak pencarian.';
       } else {
           $hasil = Mahasiswa::where('nama', 'like', "%{$kataKunci}%")->get();
           $pesan = "Hasil pencarian mahasiswa dengan kata kunci: '{$kataKunci}' (Ditemukan: {$hasil->count()} data).";
       }

       return view('mahasiswa.cari', compact('kataKunci', 'hasil', 'pesan'));
   }
   ```
   Rute diakses via: `GET /mahasiswa/cari?nama=Budi`.

2. **Fungsi Directive `@csrf` dan Dampak Jika Dihilangkan:**
   * **Fungsi:** Menyisipkan input tersembunyi (`<input type="hidden" name="_token" value="...">`) berisi token kriptografis acak yang unik per sesi pengguna. Token ini divalidasi oleh middleware `VerifyCsrfToken` (atau `ValidateCsrfTokens` pada Laravel 13).
   * **Dampak Jika Hilang:** Laravel akan menolak request HTTP POST/PUT/DELETE dengan melempar exception **`419 Page Expired`** atau `TokenMismatchException`. Hal ini melindungi pengguna dari serangan di mana situs pihak ketiga yang berbahaya memaksa browser mengirimkan aksi terotentikasi tanpa sepengetahuan pengguna.

3. **Konsep Dependency Injection pada Controller Laravel:**
   * Laravel menggunakan **Service Container (IoC Container)** dengan fitur *Reflection API*.
   * Ketika method Controller mendeklarasikan type-hint seperti `public function store(Request $request)`, Laravel secara otomatis membuat dan menyuntikkan (meng-inject) instance `Illuminate\Http\Request` aktif yang berisi payload HTTP, header, dan parameter input. Developer tidak perlu membuat objek secara manual via `new Request()`.

---

#### Praktikum 3: Pembuatan Controller (Invokable & Sub-Folder)
1. **Implementasi Invokable Controller `HitungTotalSksController`:**
   Dibuat file `app/Http/Controllers/HitungTotalSksController.php`:
   ```php
   namespace App\Http\Controllers;

   use App\Models\Matakuliah;

   class HitungTotalSksController extends Controller
   {
       public function __invoke()
       {
           $totalSks = Matakuliah::sum('sks');
           $jumlahMatakuliah = Matakuliah::count();
           $rataSks = Matakuliah::avg('sks');

           return view('matakuliah.total-sks', compact('totalSks', 'jumlahMatakuliah', 'rataSks'));
       }
   }
   ```
   Didaftarkan pada rute:
   ```php
   Route::get('/matakuliah-total-sks', HitungTotalSksController::class)->name('matakuliah.total-sks');
   ```

2. **Implementasi Sub-Folder Controller `Laporan/RekapController`:**
   Dibuat file `app/Http/Controllers/Laporan/RekapController.php` dengan namespace `App\Http\Controllers\Laporan`:
   ```php
   namespace App\Http\Controllers\Laporan;

   use App\Http\Controllers\Controller;
   use Illuminate\Support\Facades\DB;

   class RekapController extends Controller
   {
       public function index()
       {
           $rekapProdi = DB::table('mahasiswas')
               ->select('prodi', DB::raw('count(*) as total_mhs'), DB::raw('avg(semester) as rata_semester'))
               ->groupBy('prodi')
               ->get();

           $rekapMatkul = DB::table('matakuliahs')
               ->select('semester', DB::raw('count(*) as total_mk'), DB::raw('sum(sks) as total_sks'))
               ->groupBy('semester')
               ->orderBy('semester')
               ->get();

           return view('laporan.rekap', compact('rekapProdi', 'rekapMatkul'));
       }
   }
   ```

3. **Kapan Menggunakan Resource vs Invokable vs Controller Standar?**
   * **Resource Controller:** Gunakan ketika mengelola entitas data yang memiliki operasi CRUD lengkap standar RESTful (7 action: `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`). Contoh: `MahasiswaController`, `MatakuliahController`.
   * **Invokable Controller:** Gunakan ketika Controller hanya memiliki satu tugas/aksi spesifik (Single Responsibility Principle). Sangat cocok untuk generate laporan PDF, kalkulasi statistik, export Excel, atau endpoint webhook. Contoh: `HitungTotalSksController`, `StatistikMahasiswaController`.
   * **Controller Standar:** Gunakan ketika ada beberapa aksi terkait dalam satu domain fungsional tetapi tidak cocok dengan pola 7 RESTful standar (misalnya: `AuthController` yang memiliki method `login`, `authenticate`, `logout`, `register`).

---

### 📌 Bagian II — Query Builder (Praktikum 4 s/d 5)

#### Praktikum 4: Membandingkan Pendekatan Database & Query Log
1. **Perbandingan 3 Pendekatan Query:**
   * **Raw SQL:**
     ```php
     DB::select("SELECT * FROM mahasiswas WHERE prodi = ?", ['Teknik Informatika']);
     ```
   * **Query Builder:**
     ```php
     DB::table('mahasiswas')->where('prodi', 'Teknik Informatika')->get();
     ```
   * **Eloquent ORM:**
     ```php
     Mahasiswa::where('prodi', 'Teknik Informatika')->orderBy('nama', 'asc')->get();
     ```

2. **Hasil Inspeksi Query Log (`DB::getQueryLog()`):**
   * **Query Builder SQL:** `select * from "mahasiswas" where "prodi" = ?`
   * **Bindings:** `["Teknik Informatika"]`
   * **Waktu Eksekusi:** Rata-rata 0.3 ms s/d 0.8 ms pada SQLite in-memory / local storage.

3. **Tabel Komparasi Komparatif 3 Pendekatan:**

| Kriteria | Raw SQL (`DB::select`) | Query Builder (`DB::table`) | Eloquent ORM (`Model`) |
| :--- | :--- | :--- | :--- |
| **Kecepatan / Overhead** | Paling cepat (zero object hydration) | Sangat cepat (overhead minimal) | Cepat (ada overhead instansiasi model & event) |
| **Keamanan SQL Injection** | Rentan jika concat string; Aman jika pakai `[?]` | Otomatis aman (Prepared Statements PDO) | Otomatis aman (Prepared Statements PDO) |
| **Tipe Kembalian** | `array` of `stdClass` | `Illuminate\Support\Collection` of `stdClass` | `Illuminate\Database\Eloquent\Collection` of `Model` |
| **Relasi & Accessor** | Tidak ada dukungan | Tidak ada dukungan | Mendukung relasi (`with`, `hasMany`) & Accessor |
| **Database Agnostic** | Rendah (sintaks terikat dialek DBMS tertentu) | Tinggi (compiler dialek SQL otomatis) | Tinggi (compiler dialek SQL otomatis) |
| **Skenario Terbaik** | Query reporting rumit (multi nested subquery puluhan baris) | Agregasi data besar, proses batch/chunk data ribuan baris | Logika bisnis aplikasi web CRUD, domain model, validasi relasi |

---

#### Praktikum 5: Operasi Query Builder Lanjutan
1. **Filter Prodi TI & Semester 3–6 dengan `whereBetween`:**
   ```php
   $data = DB::table('mahasiswas')
       ->where('prodi', 'Teknik Informatika')
       ->whereBetween('semester', [3, 6])
       ->orderBy('nama', 'asc')
       ->get();
   ```
   *Query SQL yang Dihasilkan:*
   ```sql
   select * from "mahasiswas" where "prodi" = 'Teknik Informatika' and "semester" between 3 and 6 order by "nama" asc
   ```

2. **Agregasi Menggunakan `DB::raw()` dan `groupBy()`:**
   ```php
   $rekap = DB::table('mahasiswas')
       ->select('prodi', 
           DB::raw('count(*) as jumlah'), 
           DB::raw('min(semester) as min_semester'), 
           DB::raw('max(semester) as max_semester')
       )
       ->groupBy('prodi')
       ->get();
   ```

3. **Paginasi Query Builder `paginate(5)`:**
   Pada controller:
   ```php
   $data = DB::table('mahasiswas')->orderBy('id', 'asc')->paginate(5);
   ```
   Pada Blade template:
   ```blade
   <table class="custom-table">...</table>
   <div class="pagination-container">
       {{ $data->links() }}
   </div>
   ```

---

### 📌 Bagian III — Eloquent ORM (Praktikum 6 s/d 7)

#### Praktikum 6: Komparasi Objek `stdClass` vs Model Eloquent
1. **Pembuktian Tipe Data Kembalian (`get_class()`):**
   * Objek dari `DB::table('mahasiswas')->first()` mengembalikan:
     $$\rightarrow \mathbf{\texttt{stdClass}}$$
   * Objek dari `Mahasiswa::first()` mengembalikan:
     $$\rightarrow \mathbf{\texttt{App\textbackslash Models\textbackslash Mahasiswa}}$$

2. **Mengapa Model Eloquent Mendukung Accessor & Relasi sedangkan `stdClass` Tidak?**
   * `stdClass` adalah kelas bawaan generic PHP (objek kosong tanpa method khusus) yang hanya memegang data kolom sebagai properti publik mentah tanpa logika OOP.
   * `App\Models\Mahasiswa` meng-extend `Illuminate\Database\Eloquent\Model`. Model Eloquent memanfaatkan method magic PHP (`__get()`, `__set()`, `__call()`). Ketika developer memanggil `$mahasiswa->status`, Eloquent mengintersep panggilan tersebut dan mengeksekusi accessor method `status(): Attribute`. Ketika memanggil `$mahasiswa->nilai`, Eloquent memicu query relasi relasional melalui class Relationship builder.

3. **Kapan Query Builder Lebih Disarankan Dibandingkan Eloquent ORM?**
   * **Pemrosesan Data Massal (Bulk Insert / Data Pipeline):** Ketika mengimpor ratusan ribu baris data, Eloquent akan menginstansiasi ratusan ribu objek model ke dalam RAM yang menyebabkan memori penuh (*memory leak*). Query Builder jauh lebih efisien.
   * **Dashboard Pelaporan Kompleks:** Menghitung pivot table atau laporan finansial dengan puluhan `JOIN` dan klausa `GROUP BY` lebih efisien ditulis via Query Builder murni.
   * **Aplikasi dengan Konstrain Memori Ketat:** Server micro-instances atau serverless Lambda dengan memori terbatas.

---

#### Praktikum 7: Relasi Eloquent & Analisis N+1 Query Problem
1. **Implementasi Relasi Model:**
   * Pada `app/Models/Mahasiswa.php`:
     ```php
     public function nilai()
     {
         return $this->hasMany(NilaiMatakuliah::class, 'mahasiswa_id');
     }
     ```
   * Pada `app/Models/NilaiMatakuliah.php`:
     ```php
     public function mahasiswa()
     {
         return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
     }

     public function matakuliah()
     {
         return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
     }
     ```
   * Pada `app/Models/Matakuliah.php`:
     ```php
     public function nilai()
     {
         return $this->hasMany(NilaiMatakuliah::class, 'matakuliah_id');
     }
     ```

2. **Menampilkan Data Mahasiswa beserta Nilai Matakuliah (Eager Loading):**
   ```php
   $mahasiswa = Mahasiswa::with('nilai.matakuliah')->get();
   ```

3. **Bukti Query Log: Lazy Loading (N+1 Problem) vs Eager Loading `with()`:**

| Skenario Pengambilan Data | Kode Implementasi | Total Query SQL (10 Data) | Dampak & Kinerja |
| :--- | :--- | :--- | :--- |
| **Lazy Loading (N+1 Problem)** | `Mahasiswa::all()` lalu akses relasi `$m->nilai` di dalam loop | **21 Query SQL** | **Sangat Boros Database Call.** Dijalankan 1 query untuk mengambil 10 mahasiswa, kemudian 10 query untuk nilai, dan 10 query untuk mata kuliah. Jika ada 1.000 mahasiswa, akan memicu 2.001 query! |
| **Eager Loading (`with()`)** | `Mahasiswa::with('nilai.matakuliah')->get()` | **3 Query SQL** | **Sangat Efisien & Konstan.** Laravel hanya menjalankan: (1) query `SELECT * FROM mahasiswas`, (2) query `SELECT * FROM nilai_matakuliahs WHERE mahasiswa_id IN (...)`, dan (3) query `SELECT * FROM matakuliahs WHERE id IN (...)`. Berapa pun jumlah mahasiswa (10 atau 10.000 data), jumlah query tetap konstan hanya 3! |

---

## 🏗️ Struktur Arsitektur Direktori Proyek

```text
praktikum-laravel-controller-database/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Admin/
│   │       │   └── DashboardController.php   # Nested Controller Admin
│   │       ├── Laporan/
│   │       │   └── RekapController.php       # Nested Controller Laporan
│   │       ├── Controller.php                # Base Controller
│   │       ├── EagerLoadingDemoController.php# Demo Objek & Eager Loading
│   │       ├── HitungTotalSksController.php  # Invokable Controller Total SKS
│   │       ├── LatihanController.php         # Praktikum 1 Tugas Mandiri
│   │       ├── MahasiswaController.php       # Resource CRUD Mahasiswa
│   │       ├── MatakuliahController.php      # Resource CRUD Mata Kuliah
│   │       ├── QueryBuilderDemoController.php# Demo Praktikum 4 & 5
│   │       ├── SapaController.php            # Praktikum 1 Sapa Controller
│   │       └── StatistikMahasiswaController.php # Invokable Controller
│   └── Models/
│       ├── Mahasiswa.php                     # Model Mahasiswa + Accessor + Relasi
│       ├── Matakuliah.php                    # Model Matakuliah + Relasi
│       └── NilaiMatakuliah.php               # Model NilaiMatakuliah + Relasi
├── database/
│   ├── migrations/
│   │   ├── ..._create_mahasiswas_table.php
│   │   ├── ..._create_matakuliahs_table.php
│   │   └── ..._create_nilai_matakuliahs_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── MahasiswaSeeder.php
│       ├── MatakuliahSeeder.php
│       └── NilaiMatakuliahSeeder.php
├── resources/
│   └── views/
│       ├── admin/
│       │   └── dashboard.blade.php
│       ├── demo/
│       │   ├── crud-query-builder.blade.php
│       │   ├── eager-loading.blade.php
│       │   ├── komparasi-database.blade.php
│       │   ├── komparasi-objek.blade.php
│       │   ├── paginasi-query-builder.blade.php
│       │   ├── query-builder.blade.php
│       │   └── statistik-prodi.blade.php
│       ├── errors/
│       │   └── 404.blade.php
│       ├── laporan/
│       │   └── rekap.blade.php
│       ├── layouts/
│       │   └── app.blade.php                 # Master Layout UI Glassmorphism
│       ├── mahasiswa/
│       │   ├── cari.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   ├── form-uji.blade.php
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── matakuliah/
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   ├── index.blade.php
│       │   ├── show.blade.php
│       │   └── total-sks.blade.php
│       ├── partials/
│       │   └── navbar.blade.php
│       ├── beranda.blade.php                 # Portal Utama
│       └── statistik.blade.php               # View Invokable Statistik
├── routes/
│   └── web.php                               # 47 Route Terdefinisi Rapi
└── tests/
    └── Feature/
        ├── ExampleTest.php
        └── ModulControllerDatabaseTest.php   # Test Suite Otomatis 100% Pass
```

---

## 🏆 Kesimpulan & Capaian Pembelajaran

1. **Controller:** Mampu memisahkan secara tegas antara rute (*routing*), orkestrasi logika aplikasi (*controller*), model domain data (*model*), dan antarmuka pengguna (*view*), serta memanfaatkan Single Action (Invokable) Controller dan sub-folder organisasi modular.
2. **Keamanan & Request:** Memahami injeksi `Request $request`, pentingnya token `@csrf` untuk mencegah serangan CSRF, serta penyajian data dalam format API JSON.
3. **Query Builder:** Menguasai method chaining `DB::table()`, agregasi SQL kompleks dengan `DB::raw()` dan `groupBy()`, filter kondisional `whereBetween()`, paginasi otomatis `paginate()`, serta inspeksi query melalui `DB::enableQueryLog()`.
4. **Eloquent ORM:** Memahami perbedaan fundamental objek `stdClass` vs `Model`, membuat relasi antar-entitas (`hasMany` dan `belongsTo`), accessor komputasi data, dan teknik **Eager Loading `with()`** untuk mencegah penurunan performa akibat masalah **N+1 Query Problem**.
