<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';

    protected $primaryKey = 'id_buku';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_buku',
        'judul',
        'pengarang',
        'tahun',
        'kategori_id'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class,'kategori_id','idkategori');
    }
}