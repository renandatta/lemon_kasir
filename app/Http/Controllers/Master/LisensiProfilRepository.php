<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\LisensiProfil;
use Illuminate\Http\Request;

class LisensiProfilRepository
{
    protected $lisensiProfil;
    public function __construct(LisensiProfil $lisensiProfil)
    {
        $this->lisensiProfil = $lisensiProfil;
    }

    public function search(Request $request)
    {
        $lisensi_profil = $this->lisensiProfil->select('lisensi_profil.*')
            ->with(['profil', 'lisensi']);

        $no_lisensi = $request->input('no_lisensi') ?? '';
        if ($no_lisensi != '')
            $lisensi_profil = $lisensi_profil->where('user.no_lisensi', 'like', '%'. $no_lisensi .'%');

        $profil_id = $request->input('profil_id') ?? '';
        if ($profil_id != '')
            $lisensi_profil = $lisensi_profil->where('profil_id', '=', $profil_id);

        $lisensi_id = $request->input('lisensi_id') ?? '';
        if ($lisensi_id != '')
            $lisensi_profil = $lisensi_profil->where('lisensi_id', '=', $lisensi_id);

        $is_aktif = $request->input('is_aktif') ?? '';
        if ($is_aktif != '')
            $lisensi_profil = $lisensi_profil->where('is_aktif', '=', $is_aktif);

        $harga_awal = $request->input('harga_awal') ?? '';
        if ($harga_awal != '')
            $lisensi_profil = $lisensi_profil->where('lisensi_profil.harga', '>=', $harga_awal);

        $harga_akhir = $request->input('harga_akhir') ?? '';
        if ($harga_akhir != '')
            $lisensi_profil = $lisensi_profil->where('lisensi_profil.harga', '<=', $harga_akhir);

        $berlaku_dari = $request->input('berlaku_dari') ?? '';
        if ($berlaku_dari != '')
            $lisensi_profil = $lisensi_profil->where('lisensi_profil.berlaku_dari', '>=', $berlaku_dari);

        $berlaku_sampai = $request->input('berlaku_sampai') ?? '';
        if ($berlaku_sampai != '')
            $lisensi_profil = $lisensi_profil->where('lisensi_profil.berlaku_sampai', '<=', $berlaku_sampai);

        if ($request->has('paginate'))
            return $lisensi_profil->paginate($request->input('paginate'));
        return $lisensi_profil->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->lisensiProfil->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        if (!$request->has('id'))
            $result = $this->lisensiProfil->create($request->all());
        else {
            $result = $this->lisensiProfil->find($request->input('id'));
            $result->update($request->all());
        }
        return $result;
    }

    public function delete($id)
    {
        $result = $this->lisensiProfil->find($id);
        $result->delete();
        return $result;
    }

    public function nomor_otomatis()
    {
        return date('Y') . '/' . numberToRoman(date('n')) . '/' . date('d') . '/' . strval(mt_rand(111111, 999999));
    }
}
