<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('home.dashboard');
    }
}
