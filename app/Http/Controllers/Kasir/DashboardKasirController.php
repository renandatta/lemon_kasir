<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class DashboardKasirController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');
    }

    public function index()
    {
        Session::put('modul_aktif', 'Lemon Kasir');
        Session::put('menu_aktif', 'kasir.dashboard');
        return view('kasir.dashboard');
    }
}
