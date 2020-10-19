<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\ProfilRepository;
use App\Http\Controllers\Penjualan\PenjualanRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LaporanPenjualanKasirController extends Controller
{

    protected $breadcrumbs, $profil, $penjualan;
    public function __construct(ProfilRepository $profil, PenjualanRepository $penjualan)
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');
        $this->profil = $profil;
        $this->penjualan = $penjualan;
        view()->share(['title' => 'Laporan Penjualan']);
        $this->breadcrumbs = array(
            ['url' => null, 'caption' => 'Lemon Kasir', 'parameters' => null],
            [
                'url' => 'kasir.penjualan', 'caption' => 'Laporan Penjualan', 'parameters' => null,
                'desc' => 'Laporan produk terjual'
            ],
        );
    }

    public function index()
    {
        Session::put('modul_aktif', 'Lemon Kasir');
        Session::put('menu_aktif', 'kasir.laporan_penjualan');
        $breadcrumbs = $this->breadcrumbs;

        $profil = $this->profil->find(Auth::user()->user_profil->profil_id);
        return view('kasir.laporan.penjualan.index', compact('breadcrumbs', 'profil'));
    }

    public function search(Request $request)
    {
        $profil = $this->profil->find(Auth::user()->user_profil->profil_id);
        $request->merge(['profil_id' => $profil->id]);
        $penjualan = $this->penjualan->search_detail($request);
        return view('kasir.laporan.penjualan._table', compact('penjualan'));
    }
}
