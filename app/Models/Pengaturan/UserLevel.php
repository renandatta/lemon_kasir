<?php

namespace App\Models\Pengaturan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLevel extends Model
{
    use SoftDeletes;
    protected $table = 'user_level';
    protected $fillable = [
        'nama', 'keterangan'
    ];
}
