<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\LisensiRepository;
use Illuminate\Http\Request;

class LisensiController extends Controller
{
    protected $lisensi;
    public function __construct(LisensiRepository $lisensi)
    {
        $this->lisensi = $lisensi;
    }

    public function search()
    {
        $lisensi = $this->lisensi->search(new Request());
        return response()->json(['success' => $lisensi]);
    }
}
