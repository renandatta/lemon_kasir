<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Penjualan\PenjualanRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardKasirController extends Controller
{
    protected $penjualan;
    public function __construct(PenjualanRepository $penjualan)
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');

        view()->share(['title' => 'Dashboard']);
        $this->penjualan = $penjualan;
    }

    public function index()
    {
        Session::put('modul_aktif', 'Lemon Kasir');
        Session::put('menu_aktif', 'kasir.dashboard');

        $tanggal_sekarang = date('Y-m-d');
        $total_penjualan = $this->total_penjualan($tanggal_sekarang);
        $total_minggu_ini = array();
        for ($i = 1; $i <= 7; $i++) {
            $tanggal = date('Y-m-d', strtotime($tanggal_sekarang . ' -' . intval(7-$i) . ' day'));
            array_push($total_minggu_ini, [
                'tanggal' => fulldate($tanggal), 'total' => $this->total_penjualan($tanggal)
            ]);
        }

        return view('kasir.dashboard', compact('total_penjualan', 'total_minggu_ini'));
    }

    public function total_penjualan($tanggal)
    {
        $req = new Request();
        $req->merge(['tanggal_dibayar' => $tanggal]);
        return $this->penjualan->search($req)->sum('total');
    }
}
