<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';

    protected $fillable = [
        'pesanan_id',
        'menu_id',
        'qty',
        'harga',
        'subtotal'
    ];

    public function detail()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
