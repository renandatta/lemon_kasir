<?php

namespace App\Models\Penjualan;

use App\Models\Produk\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPenjualan extends Model
{
    use SoftDeletes;
    protected $table = 'detail_penjualan';
    protected $fillable = [
        'penjualan_id', 'produk_id', 'jumlah', 'harga'
    ];

    public function getTotalHargaAttribute()
    {
        return $this->jumlah * $this->harga;
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
