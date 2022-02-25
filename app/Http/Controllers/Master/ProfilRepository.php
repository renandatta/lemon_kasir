<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Profil;
use Illuminate\Http\Request;

class ProfilRepository {

    protected $profil;
    public function __construct(Profil $profil)
    {
        $this->profil = $profil;
    }

    public function search(Request $request)
    {
        $profil = $this->profil;

        $nama = $request->input('nama') ?? '';
        if ($nama != '')
            $profil = $profil->where('nama', 'like', '%'. $nama .'%');

        $notelp = $request->input('notelp') ?? '';
        if ($notelp != '')
            $profil = $profil->where('notelp', 'like', '%'. $notelp .'%');

        $alamat = $request->input('alamat') ?? '';
        if ($alamat != '')
            $profil = $profil->where('alamat', 'like', '%'. $alamat .'%');

        $kota = $request->input('kota') ?? '';
        if ($kota != '')
            $profil = $profil->where('kota', '=', $kota);

        if ($request->has('paginate'))
            return $profil->paginate($request->input('paginate'));
        return $profil->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->profil->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        if (!$request->has('id'))
            $result = $this->profil->create($request->all());
        else {
            $result = $this->profil->find($request->input('id'));
            $result->update($request->all());
        }
        return $result;
    }

    public function delete($id)
    {
        $result = $this->profil->find($id);
        $result->delete();
        return $result;
    }

}
