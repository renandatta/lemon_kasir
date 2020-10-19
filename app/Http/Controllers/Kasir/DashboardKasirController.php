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

        return view('kasir.dashboard.index', compact('total_penjualan', 'total_minggu_ini'));
    }

    public function total_penjualan($tanggal)
    {
        $req = new Request(['tanggal_dibayar' => $tanggal]);
        return $this->penjualan->search($req)->sum('total');
    }

    public function produk_terlaris(Request $request)
    {
        if (!$request->has('mode')) return abort(404);
        $mode = $request->input('mode');
        $tanggal_sekarang = date('Y-m-d');
        switch ($mode) {
            case 'semua' :
                $terlaris = $this->search_produk_terlaris();
                break;
            case 'hari' :
                $terlaris = $this->search_produk_terlaris($tanggal_sekarang, $tanggal_sekarang);
                break;
            case 'minggu' :
                $tanggal_awal = date('Y-m-d', strtotime($tanggal_sekarang . ' -7 day'));
                $terlaris = $this->search_produk_terlaris($tanggal_awal, $tanggal_sekarang);
                break;
            case 'bulan' :
                $tanggal_awal = date('Y-m-d', strtotime($tanggal_sekarang . ' -1 month'));
                $terlaris = $this->search_produk_terlaris($tanggal_awal, $tanggal_sekarang);
                break;
            default :
                $terlaris = [];
                break;
        }
        if ($request->has('ajax')) return $terlaris;
        return view('kasir.dashboard._list_produk_terlaris', compact('terlaris'));
    }

    public function search_produk_terlaris($tanggal_awal = '', $tanggal_akhir = '')
    {
        return $this->penjualan->search_detail(
            new Request(
                [
                    'tanggal_dari' => $tanggal_awal,
                    'tanggal_sampai' => $tanggal_akhir,
                    'group_produk' => 'desc'
                ]
            )
        );
    }
}
