<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfilController extends Controller
{
    protected $breadcrumbs, $profil;
    public function __construct(ProfilRepository $profil)
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');

        $this->profil = $profil;
        view()->share(['title' => 'Profil']);
        $this->breadcrumbs = array(
            ['url' => null, 'caption' => 'Master', 'parameters' => null],
            ['url' => 'master.profil', 'caption' => 'Profil', 'parameters' => null],
        );
    }

    public function index()
    {
        Session::put('modul_aktif', 'Master');
        Session::put('menu_aktif', 'master.profil');

        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => 'Data Profil',
            'parameters' => null,
            'desc' => 'Manajemen data profil w'
        ]);
        return view('master.profil.index', compact('breadcrumbs'));
    }

    public function info(Request $request)
    {
        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => $request->has('id') ? 'Ubah Profil' : 'Tambah Profil',
            'parameters' => $request->input('id') ?? null,
            'desc' => $request->has('id') ?
                'Ubah informasi data profil' :
                'Tambah data profil baru'
        ]);
        $id = $request->input('id') ?? null;
        $profil = ($id != null) ? $this->profil->find($id) : [];
        return view('master.profil.info', compact('breadcrumbs', 'profil'));
    }

    public function search(Request $request)
    {
        $profil = $this->profil->search($request);
        if ($request->has('ajax')) return $profil;
        $action = $request->input('action') ?? array();
        return view('master.profil._table', compact('profil', 'action'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:4|max:255',
            'notelp' => 'required|min:4|max:255',
            'alamat' => 'required|min:4|max:255',
            'kota' => 'required|min:2|max:255',
        ]);

        $profil = $this->profil->save($request);
        if ($request->has('ajax')) return $profil;
        return redirect()->route('master.profil')
            ->with('success', 'Profil berhasil disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $profil = $this->profil->delete($request->input('id'));
        if ($request->has('ajax')) return $profil;
        return redirect()->route('master.profil')
            ->with('success', 'Profil berhasil dihapus');
    }
}
