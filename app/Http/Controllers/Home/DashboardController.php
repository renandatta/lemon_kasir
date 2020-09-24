<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');
    }

    public function index()
    {
        Session::put('modul_aktif', 'Home');
        Session::put('menu_aktif', 'home.dashboard');
        return view('home.dashboard');
    }
}
