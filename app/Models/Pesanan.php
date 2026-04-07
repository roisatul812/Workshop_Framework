<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'total',
        'status_pembayaran',
        'payment_type',
        'transaction_status',
        'midtrans_order_id',
        'snap_token'
    ];

    public $timestamps = false;

    public function detail()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }
}
