<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    public function index()
{
    $buku = Buku::with('kategori')->get();
    return view('buku.index', compact('buku'));
}

    public function create()
    {
        $kategori = Kategori::all();
        return view('buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        Buku::create($request->all());
        return redirect('/buku');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::all();

        return view('buku.edit', compact('buku','kategori'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->update($request->all());

        return redirect('/buku');
    }

    public function destroy($id)
    {
        Buku::destroy($id);
        return redirect('/buku');
    }
}