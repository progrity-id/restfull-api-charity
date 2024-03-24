<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'inv',
        'tanggal',
        'tax',
        'total',
        'status',
        'id_users',
        'metode_bayar',

    ];

    public function dataTransaksiDetail()
    {

        return $this->hasMany(TransaksiDetail::class, 'id_transaksi', 'id');
    }
}
