<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\ProfilRepository;
use App\Http\Controllers\Produk\ProdukRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProdukKasirController extends Controller
{
    protected $breadcrumbs, $profil, $produk;
    public function __construct(ProfilRepository $profil, ProdukRepository $produk)
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');
        $this->profil = $profil;
        $this->produk = $produk;
        view()->share(['title' => 'Produk / Menu']);
        $this->breadcrumbs = array(
            ['url' => null, 'caption' => 'Lemon Kasir', 'parameters' => null],
            ['url' => 'kasir.produk', 'caption' => 'Produk / Menu', 'parameters' => null],
        );
    }

    public function index()
    {
        Session::put('modul_aktif', 'Lemon Kasir');
        Session::put('menu_aktif', 'kasir.produk');
        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => 'Data Produk / Menu',
            'parameters' => null,
            'desc' => 'Data produk atau menu untuk dijual'
        ]);

        $profil = $this->profil->find(Auth::user()->user_profil->profil_id);
        return view('kasir.produk.index', compact('breadcrumbs', 'profil'));
    }

    public function info(Request $request)
    {
        $id = $request->input('id') ?? '';
        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => 'kasir.produk.info',
            'caption' => $id == '' ? 'Tambah' : 'Ubah',
            'parameters' => $id == '' ? null : $id,
            'desc' => ($id == '' ? 'Tambah' : 'Ubah') . ' produk untuk dijual'
        ]);

        $produk = $id !== '' ? $this->produk->find($id) : array();
        return view('kasir.produk.info', compact('breadcrumbs', 'produk'));
    }

    public function search(Request $request)
    {
        $profil = $this->profil->find(Auth::user()->user_profil->profil_id);
        $request->merge(['profil_id' => $profil->id]);
        $produk = $this->produk->search($request);
        if ($request->has('ajax')) return $produk;
        $action = array('edit');
        return view('kasir.produk._table', compact('produk', 'action'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:4|max:255',
            'harga' => 'required|numeric',
        ]);
        $profil = $this->profil->find(Auth::user()->user_profil->profil_id);
        $request->merge(['profil_id' => $profil->id]);
        $request->merge(['harga' => unformat_number($request->input('harga'))]);
        $produk = $this->produk->save($request);
        if ($request->has('ajax')) return $produk;
        return redirect()->route('kasir.produk')
            ->with('success', 'Produk berhasil disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $produk = $this->produk->delete($request->input('id'));
        if ($request->has('ajax')) return $produk;
        return redirect()->route('kasir.produk')
            ->with('success', 'Produk berhasil dihapus');
    }
}
