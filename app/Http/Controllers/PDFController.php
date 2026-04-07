<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Buku;
use App\Models\Kategori;

class PDFController extends Controller
{

    public function form()
    {
        return view('pdf.form');
    }

    public function cetak(Request $request)
    {
        $orientasi = $request->input('format');

        if ($request->data == 'buku') {

            $data = Buku::latest()->get();

            $pdf = Pdf::loadView('pdf.buku', compact('data'))
                ->setPaper('A4', $orientasi);

            return $pdf->download('data-buku.pdf');
        }

        if ($request->data == 'kategori') {

            $data = Kategori::latest()->get();

            $pdf = Pdf::loadView('pdf.kategori', compact('data'))
                ->setPaper('A4', $orientasi);

            return $pdf->download('data-kategori.pdf');
        }
    }

}