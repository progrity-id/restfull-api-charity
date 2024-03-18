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
        'total',
        'status',
        'id_users',
    ];

    public function dataTransaksiDetail()
    {

        return $this->hasMany(TransaksiDetail::class, 'id_transaksi', 'id');
    }
}
