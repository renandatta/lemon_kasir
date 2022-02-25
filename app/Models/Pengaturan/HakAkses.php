<?php

namespace App\Models\Pengaturan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HakAkses extends Model
{
    use SoftDeletes;
    protected $table = 'hak_akses';
    protected $fillable = [
        'fitur_program_id', 'user_level_id', 'flag_akses'
    ];

    public function fitur_program()
    {
        return $this->belongsTo(FiturProgram::class, 'fitur_program_id', 'id');
    }

    public function user_level()
    {
        return $this->belongsTo(UserLevel::class, 'user_level_id', 'id');
    }
}
