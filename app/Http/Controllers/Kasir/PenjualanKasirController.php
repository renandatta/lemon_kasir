<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\ProfilRepository;
use App\Http\Controllers\Penjualan\PenjualanRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PenjualanKasirController extends Controller
{
    protected $breadcrumbs, $profil, $penjualan;
    public function __construct(ProfilRepository $profil, PenjualanRepository $penjualan)
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');
        $this->profil = $profil;
        $this->penjualan = $penjualan;
        view()->share(['title' => 'Penjualan']);
        $this->breadcrumbs = array(
            ['url' => null, 'caption' => 'Lemon Kasir', 'parameters' => null],
            ['url' => 'kasir.penjualan', 'caption' => 'Penjualan', 'parameters' => null],
        );
    }

    public function index()
    {
        Session::put('modul_aktif', 'Lemon Kasir');
        Session::put('menu_aktif', 'kasir.penjualan');
        $breadcrumbs = $this->breadcrumbs;

        $profil = $this->profil->find(Auth::user()->user_profil->profil_id);
        return view('kasir.penjualan.index', compact('breadcrumbs', 'profil'));
    }

    public function search(Request $request)
    {
        $profil = $this->profil->find(Auth::user()->user_profil->profil_id);
        $request->merge(['profil_id' => $profil->id]);
        $penjualan = $this->penjualan->search($request);
        return view('kasir.penjualan._list_penjualan', compact('penjualan'));
    }

    public function new()
    {
        $profil = $this->profil->find(Auth::user()->user_profil->profil_id);
        $request = new Request();
        $request->merge(['profil_id' => $profil->id]);
        $request->merge(['no_penjualan' => $this->penjualan->nomor_otomatis()]);
        return $this->penjualan->save($request);
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        return $this->penjualan->delete($request->input('id'));
    }

    public function total(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $request->merge(['penjualan_id' => $request->input('id')]);
        $detail = $this->penjualan->search_detail(new Request($request->only('penjualan_id')));
        return $detail->sum('total_harga');
    }

    public function bayar(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $request->merge(['total' => unformat_number($request->input('total'))]);
        $request->merge(['dibayar' => unformat_number($request->input('dibayar'))]);
        $penjualan = $this->penjualan->bayar($request);
        if ($request->has('ajax')) return $penjualan;
        return redirect()->route('kasir.penjualan')
            ->with('success', 'Penjualan selesai');
    }

    public function save_detail(Request $request)
    {
        if (!$request->has('penjualan_id') || !$request->has('produk_id')) return abort(404);
        $request->merge(['harga' => unformat_number($request->input('harga'))]);
        $detail = $this->penjualan->save_detail($request);
        return view('kasir.penjualan._item_detail_penjualan', compact('detail'));
    }

    public function update_detail(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $detail = $this->penjualan->find_detail($request->input('id'));
        $request->merge(['jumlah' => $detail->jumlah+1]);
        $detail = $this->penjualan->save_detail($request);
        $detail->total_harga = $detail->total_harga;
        return $detail;
    }

    public function delete_detail(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $detail = $this->penjualan->delete_detail($request->input('id'));
        $detail->total_harga = $detail->total_harga;
        return $detail;
    }
}
