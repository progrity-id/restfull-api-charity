<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'qty',
        'total',
        'harga'
    ];

    public function dataProduk()
    {

        return $this->belongsTo(Produk::class, 'id_produk', 'id');
    }
}
