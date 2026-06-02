<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;
use App\Models\Kunjungan;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Auth;

class KunjunganController extends Controller
{
    // Halaman utama: list toko + form input toko baru
    public function index()
    {
        $tokos = Toko::latest()->get();

        $generator = new BarcodeGeneratorPNG();
        foreach ($tokos as $toko) {
            $toko->barcode_img = base64_encode(
                $generator->getBarcode($toko->barcode, $generator::TYPE_CODE_128)
            );
        }

        return view('kunjungan.index', compact('tokos'));
    }

    // Simpan toko baru
    public function storeToko(Request $request)
    {
        $request->validate([
            'nama_toko'  => 'required|string|max:100',
            'alamat'     => 'nullable|string',
            'latitude'   => 'required|numeric',
            'longitude'  => 'required|numeric',
            'accuracy'   => 'required|numeric',
        ]);

        // Generate barcode unik dari timestamp
        $barcode = 'TKO-' . time();

        Toko::create([
            'barcode'   => $barcode,
            'nama_toko' => $request->nama_toko,
            'alamat'    => $request->alamat,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'accuracy'  => $request->accuracy,
        ]);

        return redirect('/kunjungan-toko')->with('success', 'Toko berhasil ditambahkan!');
    }

    // Ambil data toko berdasarkan barcode (dipanggil via AJAX saat scan)
    public function getToko(Request $request)
    {
        $toko = Toko::where('barcode', $request->barcode)->first();

        if (!$toko) {
            return response()->json(['error' => 'Toko tidak ditemukan'], 404);
        }

        return response()->json($toko);
    }

    // Simpan hasil kunjungan (diterima/ditolak)
    public function storeKunjungan(Request $request)
    {
        $request->validate([
            'toko_id'         => 'required|exists:tokos,id',
            'latitude_sales'  => 'required|numeric',
            'longitude_sales' => 'required|numeric',
            'accuracy_sales'  => 'required|numeric',
        ]);

        $toko = Toko::findOrFail($request->toko_id);

        $threshold = 300; // meter, bisa diubah sesuai kebutuhan

        // Hitung jarak dengan formula Haversine
        $jarak = $this->haversine(
            $toko->latitude,  $toko->longitude,
            $request->latitude_sales, $request->longitude_sales
        );

        // Threshold efektif = threshold + accuracy toko + accuracy sales
        $threshold_efektif = $threshold + $toko->accuracy + $request->accuracy_sales;

        $status = ($jarak <= $threshold_efektif) ? 'diterima' : 'ditolak';

        Kunjungan::create([
            'toko_id'         => $toko->id,
            'user_id'         => Auth::id(),
            'latitude_sales'  => $request->latitude_sales,
            'longitude_sales' => $request->longitude_sales,
            'accuracy_sales'  => $request->accuracy_sales,
            'jarak_meter'     => $jarak,
            'status'          => $status,
            'threshold'       => $threshold,
        ]);

        return response()->json([
            'status'             => $status,
            'jarak'              => round($jarak, 2),
            'threshold_efektif'  => round($threshold_efektif, 2),
            'toko'               => $toko->nama_toko,
        ]);
    }

    // Formula Haversine
    private function haversine($lat1, $lng1, $lat2, $lng2)
    {
        $R = 6371000; // radius bumi dalam meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $R * $c;
    }
}