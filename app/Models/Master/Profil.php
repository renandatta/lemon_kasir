<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profil extends Model
{
    use SoftDeletes;
    protected $table = 'profil';
    protected $fillable = [
        'nama', 'notelp', 'alamat', 'kota'
    ];
}
