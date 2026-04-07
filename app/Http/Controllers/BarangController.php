<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController
{
    public function index()
    {
        $data = Barang::latest()->get();

        return view('barang.index', compact('data'));
    }
    public function cetakHarga(Request $request)
    {
        $x = $request->x;
        $y = $request->y;

        $barang = Barang::whereIn('id', $request->barang)->get();

        $start = (($y - 1) * 5) + $x;

        $labels = [];

        // label kosong sebelum START
        for ($i = 1; $i < $start; $i++) {
            $labels[] = null;
        }

        // isi label
        foreach ($barang as $b) {
            $labels[] = $b;
        }

        $pdf = PDF::loadView('pdf.tag-harga', [
            'labels' => $labels
        ])->setPaper('A4', 'portrait')
            ->setOption('dpi', 96);

        return $pdf->download('tag-harga.pdf');
    }
}
