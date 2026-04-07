<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $jumlahBuku = Buku::count();
        $jumlahKategori = Kategori::count();

        return view('home', compact('jumlahBuku', 'jumlahKategori'));
    }
}