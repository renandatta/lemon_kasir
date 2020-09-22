<?php

namespace App\Models\ModulUtama;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FiturProgram extends Model
{
    use SoftDeletes;
    protected $table = 'fitur_program';
    protected $fillable = [
        'nama', 'url', 'icon', 'kode', 'parent_kode'
    ];
}
