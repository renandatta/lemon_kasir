<?php

namespace App\Models\ModulUtama;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLog extends Model
{
    use SoftDeletes;
    protected $table = 'user_log';
    protected $fillable = [
        'user_id', 'url', 'request'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
