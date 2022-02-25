<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lisensi extends Model
{
    use SoftDeletes;
    protected $table = 'lisensi';
    protected $fillable = [
        'nama', 'harga', 'harga_spesial', 'keterangan'
    ];
}
