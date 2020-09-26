<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LisensiController extends Controller
{
    protected $breadcrumbs, $lisensi;
    public function __construct(LisensiRepository $lisensi)
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');

        $this->lisensi = $lisensi;
        view()->share(['title' => 'Lisensi']);
        $this->breadcrumbs = array(
            ['url' => null, 'caption' => 'Master', 'parameters' => null],
            ['url' => 'master.lisensi', 'caption' => 'Lisensi', 'parameters' => null],
        );
    }

    public function index()
    {
        Session::put('modul_aktif', 'Master');
        Session::put('menu_aktif', 'master.lisensi');

        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => 'Data Lisensi',
            'parameters' => null,
            'desc' => 'Manajemen data lisensi program'
        ]);
        return view('master.lisensi.index', compact('breadcrumbs'));
    }

    public function info(Request $request)
    {
        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => $request->has('id') ? 'Ubah Lisensi' : 'Tambah Lisensi',
            'parameters' => $request->input('id') ?? null,
            'desc' => $request->has('id') ?
                'Ubah informasi data lisensi' :
                'Tambah data lisensi baru'
        ]);
        $id = $request->input('id') ?? null;
        $lisensi = ($id != null) ? $this->lisensi->find($id) : [];
        return view('master.lisensi.info', compact('breadcrumbs', 'lisensi'));
    }

    public function search(Request $request)
    {
        $request = $this->filter_request($request);
        $lisensi = $this->lisensi->search($request);
        if ($request->has('ajax')) return $lisensi;
        $action = $request->input('action') ?? array();
        return view('master.lisensi._table', compact('lisensi', 'action'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:4|max:255',
            'keterangan' => 'min:4|max:255',
            'harga' => 'required|numeric'
        ]);
        $request = $this->filter_request($request);

        $lisensi = $this->lisensi->save($request);
        if ($request->has('ajax')) return $lisensi;
        return redirect()->route('master.lisensi')
            ->with('success', 'Lisensi berhasil disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $lisensi = $this->lisensi->delete($request->input('id'));
        if ($request->has('ajax')) return $lisensi;
        return redirect()->route('master.lisensi')
            ->with('success', 'Lisensi berhasil dihapus');
    }

    public function filter_request(Request $request)
    {
        if ($request->has('harga'))
            $request->merge(['harga' => unformat_number($request->input('harga'))]);
        if ($request->has('harga_spesial'))
            $request->merge(['harga_spesial' => unformat_number($request->input('harga_spesial'))]);
        if ($request->has('harga_awal'))
            $request->merge(['harga_awal' => unformat_number($request->input('harga_awal'))]);
        if ($request->has('harga_akhir'))
            $request->merge(['harga_akhir' => unformat_number($request->input('harga_akhir'))]);
        return $request;
    }
}
