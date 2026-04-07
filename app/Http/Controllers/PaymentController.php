<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{

    public function index($id)
    {

        $pesanan = Pesanan::find($id);

        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $pesanan->id,
                'gross_amount' => $pesanan->total,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        $pesanan->snap_token = $snapToken;

        // sementara untuk demo supaya status berubah
        $pesanan->status_pembayaran = 'lunas';

        $pesanan->save();

        return view('kantin.checkout', compact('pesanan'));
    }



    public function callback()
    {

        Config::$serverKey = config('midtrans.serverKey');

        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $order_id = $notif->order_id;

        $pesanan = Pesanan::find($order_id);

        if (!$pesanan) {
            return;
        }

        if ($transaction == 'settlement' || $transaction == 'capture') {
            $pesanan->status_pembayaran = 'lunas';
        }

        if ($transaction == 'pending') {
            $pesanan->status_pembayaran = 'pending';
        }

        if ($transaction == 'expire') {
            $pesanan->status_pembayaran = 'expired';
        }

        if ($transaction == 'cancel') {
            $pesanan->status_pembayaran = 'batal';
        }

        $pesanan->save();
    }

}