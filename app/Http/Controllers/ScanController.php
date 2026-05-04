<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Barang;

class ScanController extends Controller
{
    public function scanAll($id)
    {
        // cek barang dulu
        $barang = Barang::find($id);
        if ($barang) {
            return response()->json([
                'type' => 'barang',
                'id' => $barang->id,
                'nama' => $barang->nama_barang,
                'harga' => $barang->harga
            ]);
        }

        // kalau bukan barang → cek pesanan
        $pesanan = Pesanan::with('detail.menu')->find($id);
        if ($pesanan && !$pesanan->detail->isEmpty()) {
            return response()->json([
                'type' => 'pesanan',
                'id' => $pesanan->id,
                'status' => $pesanan->status_pembayaran,
                'detail' => $pesanan->detail->map(function($d) {
                    return [
                        'nama_menu' => $d->menu->nama_menu,
                        'qty' => $d->qty,
                        'subtotal' => $d->subtotal,
                    ];
                })
            ]);
        }

        return response()->json(['type' => 'unknown']);
    }
}