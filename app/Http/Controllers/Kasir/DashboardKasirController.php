<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;

class DashboardKasirController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');
    }

    public function index()
    {
        return view('kasir.dashboard');
    }
}
