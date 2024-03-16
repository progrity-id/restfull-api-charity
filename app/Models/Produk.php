<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // protected $guarded = [];
    protected $fillable = [
        "nama",
        "gambar",
        "harga",
        "sn",
        "stock",
        "id_kategori",
        "id_supplier",
    ];

    public function dataKategori()
    {

        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }
    public function dataSupplier()
    {

        return $this->belongsTo(Supplier::class, 'id_supplier', 'id');
    }

}
