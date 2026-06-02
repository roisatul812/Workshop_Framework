<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $fillable = [
        'nomor_antrian',
        'nama',
        'status',
        'dipanggil_at',
    ];

    protected $casts = [
        'dipanggil_at' => 'datetime',
    ];
}