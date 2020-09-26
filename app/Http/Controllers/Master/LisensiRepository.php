<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Lisensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LisensiRepository
{

    protected $lisensi;
    public function __construct(Lisensi $lisensi)
    {
        $this->lisensi = $lisensi;
    }

    public function search(Request $request)
    {
        $lisensi = $this->lisensi->select('lisensi.*', DB::raw('IF(harga_spesial > 0,harga_spesial, harga) as harga_search'));

        $nama = $request->input('nama') ?? '';
        if ($nama != '')
            $lisensi = $lisensi->where('nama', 'like', '%'. $nama .'%');

        $harga_awal = $request->input('harga_awal') ?? '';
        if ($harga_awal != '')
            $lisensi = $lisensi->where(function ($q) use ($harga_awal) {
                $q->where('harga', '>=', $harga_awal)->orWhere('harga_spesial', '>=', $harga_awal);
            });

        $harga_akhir = $request->input('harga_akhir') ?? '';
        if ($harga_akhir != '')
            $lisensi = $lisensi->where(function ($q) use ($harga_akhir) {
                $q->where('harga', '>=', $harga_akhir)->orWhere('harga_spesial', '>=', $harga_akhir);
            });

        if ($request->has('paginate'))
            return $lisensi->paginate($request->input('paginate'));
        return $lisensi->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->lisensi->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        if (!$request->has('id'))
            $result = $this->lisensi->create($request->all());
        else {
            $result = $this->lisensi->find($request->input('id'));
            $result->update($request->all());
        }
        return $result;
    }

    public function delete($id)
    {
        $result = $this->lisensi->find($id);
        $result->delete();
        return $result;
    }

}
