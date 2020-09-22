<?php

namespace App\Models\ModulUtama;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAuth extends Model
{
    use SoftDeletes;
    protected $table = 'user_auth';
    protected $fillable = [
        'user_id', 'auth', 'token', 'nomor_meja'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->with(['siswa', 'guru']);
    }
}
