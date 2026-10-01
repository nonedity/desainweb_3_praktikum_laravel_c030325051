<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\NilaiMatakuliah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ModulControllerDatabaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Otomatis jalankan DatabaseSeeder sebelum setiap pengujian.
     */
    protected bool $seed = true;

    /**
     * Test Beranda Portal Utama.
     */
    public function test_beranda_page_returns_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sistem Informasi Akademik (SIAKAD)');
        $response->assertSee('Modul Praktikum: Controller serta Interaksi Database');
    }

    /**
     * Test Praktikum 1: SapaController & Parameter Handling.
     */
    public function test_praktikum_1_sapa_controller(): void
    {
        $responseWithName = $this->get('/sapa/Budi');
        $responseWithName->assertStatus(200);
        $responseWithName->assertSee('Halo, Budi! Selamat datang di Laravel 13.');

        $responseDefault = $this->get('/sapa');
        $responseDefault->assertStatus(200);
        $responseDefault->assertSee('Halo, Mahasiswa! Selamat datang di Laravel 13.');
    }

    /**
     * Test Praktikum 1 Tugas Mandiri: LatihanController.
     */
    public function test_praktikum_1_latihan_controller(): void
    {
        $responseHalo = $this->get('/latihan/halo');
        $responseHalo->assertStatus(200);
        $responseHalo->assertSee('Halo! Selamat belajar Laravel 13 Controller & Database.', false);


        $responseProfil = $this->get('/latihan/profil');
        $responseProfil->assertStatus(200);
        $responseProfil->assertSee('Praktikan Pemrograman Web Lanjut 2026');
    }

    /**
     * Test Praktikum 2: JSON Response API & Query String Search.
     */
    public function test_praktikum_2_mahasiswa_json_api_and_search(): void
    {
        // 1. JSON API response
        $apiResponse = $this->get('/api/mahasiswa');
        $apiResponse->assertStatus(200);
        $apiResponse->assertJsonStructure([
            'status',
            'pesan',
            'total',
            'data' => [
                '*' => ['id', 'nim', 'nama', 'email', 'prodi', 'semester', 'status']
            ]
        ]);

        // 2. Search form
        $searchResponse = $this->get('/mahasiswa/cari');
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Pencarian Mahasiswa via Query String');


        // 3. Search with query string
        $searchResult = $this->get('/mahasiswa/cari?keyword=Ahmad');
        $searchResult->assertStatus(200);
        $searchResult->assertSee('Ahmad');
    }

    /**
     * Test Praktikum 2: Form Uji Request Injection & CSRF.
     */
    public function test_praktikum_2_form_uji_csrf(): void
    {
        $formResponse = $this->get('/mahasiswa/form-uji');
        $formResponse->assertStatus(200);
        $formResponse->assertSee('Form Uji Penerimaan Request');

        $postResponse = $this->post('/mahasiswa/form-uji', [
            'nama' => 'Test Mahasiswa',
            'nim' => '2024019999',
        ]);
        $postResponse->assertStatus(200);
        $postResponse->assertSee('Data yang diterima via Request');
    }


    /**
     * Test Praktikum 3: Mahasiswa Resource Controller CRUD & Route Model Binding.
     */
    public function test_praktikum_3_mahasiswa_resource_crud(): void
    {
        // 1. Index
        $indexResponse = $this->get(route('mahasiswa.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Data Mahasiswa');

        // 2. Create form
        $createResponse = $this->get(route('mahasiswa.create'));
        $createResponse->assertStatus(200);

        // 3. Store new student
        $uniqueNim = 'TEST' . rand(1000, 9999);
        $storeResponse = $this->post(route('mahasiswa.store'), [
            'nim' => $uniqueNim,
            'nama' => 'Testing Candidate',
            'email' => 'testing.' . $uniqueNim . '@example.com',
            'prodi' => 'Teknik Informatika',
            'semester' => 3,
        ]);
        $storeResponse->assertRedirect(route('mahasiswa.index'));
        $this->assertDatabaseHas('mahasiswas', ['nim' => $uniqueNim]);

        $createdMahasiswa = Mahasiswa::where('nim', $uniqueNim)->first();
        $this->assertNotNull($createdMahasiswa);

        // 4. Show with Route Model Binding
        $showResponse = $this->get(route('mahasiswa.show', $createdMahasiswa->id));
        $showResponse->assertStatus(200);
        $showResponse->assertSee($createdMahasiswa->nama);

        // 5. Edit form
        $editResponse = $this->get(route('mahasiswa.edit', $createdMahasiswa->id));
        $editResponse->assertStatus(200);

        // 6. Update student
        $updateResponse = $this->put(route('mahasiswa.update', $createdMahasiswa->id), [
            'nim' => $uniqueNim,
            'nama' => 'Testing Candidate Updated',
            'email' => 'updated.' . $uniqueNim . '@example.com',
            'prodi' => 'Sistem Informasi',
            'semester' => 4,
        ]);
        $updateResponse->assertRedirect(route('mahasiswa.index'));
        $this->assertDatabaseHas('mahasiswas', [
            'nim' => $uniqueNim,
            'nama' => 'Testing Candidate Updated',
            'prodi' => 'Sistem Informasi',
        ]);

        // 7. Destroy student
        $deleteResponse = $this->delete(route('mahasiswa.destroy', $createdMahasiswa->id));
        $deleteResponse->assertRedirect(route('mahasiswa.index'));
        $this->assertDatabaseMissing('mahasiswas', ['id' => $createdMahasiswa->id]);
    }

    /**
     * Test Praktikum 3: Invokable Controllers.
     */
    public function test_praktikum_3_invokable_controllers(): void
    {
        // 1. StatistikMahasiswaController
        $statResponse = $this->get('/statistik-mahasiswa');
        $statResponse->assertStatus(200);
        $statResponse->assertSee('Statistik Mahasiswa per Program Studi');

        // 2. HitungTotalSksController (Tugas Mandiri)
        $sksResponse = $this->get('/matakuliah-total-sks');
        $sksResponse->assertStatus(200);
        $sksResponse->assertSee('Kalkulasi Total SKS Kurikulum');
    }

    /**
     * Test Praktikum 3: Nested Controllers.
     */
    public function test_praktikum_3_nested_controllers(): void
    {
        // 1. Admin\DashboardController
        $adminResponse = $this->get('/admin/dashboard');
        $adminResponse->assertStatus(200);
        $adminResponse->assertSee('Admin Dashboard');

        // 2. Laporan\RekapController (Tugas Mandiri)
        $rekapResponse = $this->get('/laporan/rekap');
        $rekapResponse->assertStatus(200);
        $rekapResponse->assertSee('Rekapitulasi Laporan Akademik');
    }

    /**
     * Test Praktikum 4: Komparasi 3 Pendekatan Database & Query Log.
     */
    public function test_praktikum_4_komparasi_pendekatan_database(): void
    {
        $response = $this->get(route('demo.qb.komparasi'));
        $response->assertStatus(200);
        $response->assertSee('Komparasi 3 Pendekatan Akses Database');
        $response->assertSee('Raw SQL');
        $response->assertSee('Query Builder');
        $response->assertSee('Eloquent ORM');
        $response->assertSee('Query Log');
    }

    /**
     * Test Praktikum 5: Query Builder Demos, Filters & Aggregation.
     */
    public function test_praktikum_5_query_builder_demos(): void
    {
        // 1. All
        $resSemua = $this->get(route('demo.qb.all'));
        $resSemua->assertStatus(200);
        $resSemua->assertSee('Daftar Seluruh Mahasiswa');

        // 2. Filter semester >= 3
        $resFilter = $this->get(route('demo.qb.filter'));
        $resFilter->assertStatus(200);
        $resFilter->assertSee('Filter Mahasiswa: Semester &gt;= 3', false);

        // 3. Tugas Mandiri 1: whereBetween 3 sampai 6
        $resMandiri1 = $this->get(route('demo.qb.mandiri.filter'));
        $resMandiri1->assertStatus(200);
        $resMandiri1->assertSee('whereBetween');

        // 4. Agregasi per prodi
        $resAgregasi = $this->get(route('demo.qb.statistik'));
        $resAgregasi->assertStatus(200);
        $resAgregasi->assertSee('Agregasi Query Builder: DB::raw &amp; groupBy', false);

        // 5. Paginasi paginate(5)
        $resPaginasi = $this->get(route('demo.qb.paginasi'));
        $resPaginasi->assertStatus(200);
        $resPaginasi->assertSee('Paginasi Query Builder');
    }

    /**
     * Test Praktikum 5: Interactive CRUD with Query Builder.
     */
    public function test_praktikum_5_query_builder_crud_operations(): void
    {
        $crudPage = $this->get(route('demo.qb.crud'));
        $crudPage->assertStatus(200);

        $testNim = 'QBNIM' . rand(100, 999);
        $insertResponse = $this->post(route('demo.qb.insert'), [
            'nim' => $testNim,
            'nama' => 'QB Test User',
            'email' => 'qbtest@example.com',
            'prodi' => 'Teknik Informatika',
            'semester' => 4,
        ]);
        $insertResponse->assertRedirect(route('demo.qb.crud'));
        $this->assertDatabaseHas('mahasiswas', ['nim' => $testNim]);

        $insertedRow = DB::table('mahasiswas')->where('nim', $testNim)->first();
        $this->assertNotNull($insertedRow);

        $deleteResponse = $this->delete(route('demo.qb.delete', $insertedRow->id));
        $deleteResponse->assertRedirect(route('demo.qb.crud'));
        $this->assertDatabaseMissing('mahasiswas', ['id' => $insertedRow->id]);
    }

    /**
     * Test Praktikum 6: Komparasi Objek stdClass vs Model Eloquent.
     */
    public function test_praktikum_6_komparasi_objek(): void
    {
        $response = $this->get(route('demo.eloquent.objek'));
        $response->assertStatus(200);
        $response->assertSee('stdClass');
        $response->assertSee('App\Models\Mahasiswa');
    }

    /**
     * Test Praktikum 7: Eager Loading vs Lazy Loading (N+1 Query Problem).
     */
    public function test_praktikum_7_eager_loading_comparison(): void
    {
        // 1. Lazy loading mode
        $lazyResponse = $this->get(route('demo.eloquent.eager', ['mode' => 'lazy']));
        $lazyResponse->assertStatus(200);
        $lazyResponse->assertSee('LAZY LOADING');

        // 2. Eager loading mode
        $eagerResponse = $this->get(route('demo.eloquent.eager', ['mode' => 'eager']));
        $eagerResponse->assertStatus(200);
        $eagerResponse->assertSee('EAGER LOADING');
        $eagerResponse->assertSee('Hanya dijalankan 3 query SQL');
    }


    /**
     * Test Praktikum 7: Matakuliah Relationship & Reverse Relations.
     */
    public function test_praktikum_7_matakuliah_and_relationships(): void
    {
        $matakuliah = Matakuliah::first();
        $this->assertNotNull($matakuliah);

        $showResponse = $this->get(route('matakuliah.show', $matakuliah->id));
        $showResponse->assertStatus(200);
        $showResponse->assertSee($matakuliah->nama_mk);
        $showResponse->assertSee('Mahasiswa Terdaftar');
    }

    /**
     * Test Eloquent Accessor: getStatusAttribute.
     */
    public function test_mahasiswa_accessor_logic(): void
    {
        $mhsAwal = new Mahasiswa(['semester' => 2]);
        $this->assertEquals('Mahasiswa Baru', $mhsAwal->status);

        $mhsMenengah = new Mahasiswa(['semester' => 5]);
        $this->assertEquals('Mahasiswa Aktif', $mhsMenengah->status);

        $mhsAkhir = new Mahasiswa(['semester' => 8]);
        $this->assertEquals('Tingkat Akhir', $mhsAkhir->status);
    }
}
