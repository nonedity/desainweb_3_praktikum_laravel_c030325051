<?php

namespace App\Http\Controllers;

class SapaController extends Controller
{
    /**
     * Praktikum 1: Membandingkan Route dengan Closure vs Route dengan Controller
     */
    public function index($nama = 'Mahasiswa')
    {
        return "Halo, {$nama}! Selamat datang di Laravel 13. Ini adalah response yang dihasilkan dari SapaController@index (Praktikum 1).";
    }
}

