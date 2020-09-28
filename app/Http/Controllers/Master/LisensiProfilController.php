<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LisensiProfilController extends Controller
{
    protected $breadcrumbs, $lisensiProfil;
    public function __construct(LisensiProfilRepository $lisensiProfil, LisensiRepository $lisensi)
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');

        $this->lisensiProfil = $lisensiProfil;
        view()->share(['title' => 'Lisensi Profil']);
        $this->breadcrumbs = array(
            ['url' => null, 'caption' => 'Master', 'parameters' => null],
            ['url' => 'master.lisensi_profil', 'caption' => 'Lisensi Profil', 'parameters' => null],
        );
        view()->share(['lisensi' => $lisensi->search(new Request())]);
    }

    public function index(Profil $profil)
    {
        Session::put('modul_aktif', 'Master');
        Session::put('menu_aktif', 'master.profil');

        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => 'Data Lisensi Profil',
            'parameters' => null,
            'desc' => 'Manajemen data lisensi profil'
        ]);
        return view('master.profil.lisensi.index', compact('profil', 'breadcrumbs'));
    }

    public function info(Profil $profil, Request $request)
    {
        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => $request->has('id') ? 'Ubah Lisensi Profil' : 'Tambah Lisensi Profil',
            'parameters' => $request->input('id') ?? null,
            'desc' => $request->has('id') ?
                'Ubah informasi data lisensi profil' :
                'Tambah data lisensi profil baru'
        ]);
        $id = $request->input('id') ?? null;
        $lisensi_profil = ($id != null) ? $this->lisensiProfil->find($id) : [];
        return view('master.profil.lisensi.info', compact('profil', 'breadcrumbs', 'lisensi_profil'));
    }

    public function search(Profil $profil, Request $request)
    {
        $request = $this->filter_request($request);
        $request->merge(['profil_id' => $profil->id]);
        $lisensi_profil = $this->lisensiProfil->search($request);
        if ($request->has('ajax')) return $lisensi_profil;
        $action = $request->input('action') ?? array();
        return view('master.profil.lisensi._table', compact('profil', 'lisensi_profil', 'action'));
    }

    public function save(Profil $profil, Request $request)
    {
        $request->validate([
            'no_lisensi' => 'required',
            'lisensi_id' => 'required|numeric',
            'harga' => 'required|numeric',
            'berlaku_dari' => 'required|min:4|max:255',
        ]);
        $request = $this->filter_request($request);
        $request->merge(['profil_id' => $profil->id]);
        $request->merge(['is_aktif' => 1]);

        $lisensi_profil = $this->lisensiProfil->save($request);
        if ($request->has('ajax')) return $lisensi_profil;
        return redirect()->route('master.profil.lisensi', $profil->id)
            ->with('success', 'Lisensi Profil berhasil disimpan');
    }

    public function delete(Profil $profil, Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $lisensi_profil = $this->lisensiProfil->delete($request->input('id'));
        if ($request->has('ajax')) return $lisensi_profil;
        return redirect()->route('master.profil.lisensi', $profil->id)
            ->with('success', 'Lisensi Profil berhasil dihapus');
    }

    public function filter_request(Request $request)
    {
        if ($request->has('berlaku_dari'))
            $request->merge(['berlaku_dari' => unformat_date($request->input('berlaku_dari'))]);
        if ($request->has('berlaku_sampai'))
            $request->merge(['berlaku_sampai' => unformat_date($request->input('berlaku_sampai'))]);
        if ($request->has('harga'))
            $request->merge(['harga' => unformat_number($request->input('harga'))]);
        if ($request->has('harga_dari'))
            $request->merge(['harga_dari' => unformat_number($request->input('harga_dari'))]);
        if ($request->has('harga_sampai'))
            $request->merge(['harga_sampai' => unformat_number($request->input('harga_sampai'))]);
        return $request;
    }
}
