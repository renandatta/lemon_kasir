<?php

namespace App\Http\Controllers\Produk;

use App\Models\Penjualan\DetailPenjualan;
use App\Models\Produk\Produk;
use Illuminate\Http\Request;

class ProdukRepository
{
    protected $produk, $detailPenjualan;
    public function __construct(Produk $produk, DetailPenjualan $detailPenjualan)
    {
        $this->produk = $produk;
        $this->detailPenjualan = $detailPenjualan;
    }

    public function search(Request $request)
    {
        $produk = $this->produk->orderBy('id', 'desc');

        $nama = $request->input('nama') ?? '';
        if ($nama != '')
            $produk = $produk->where('nama', 'like', '%'. $nama .'%');

        $profil_id = $request->input('profil_id') ?? '';
        if ($profil_id != '')
            $produk = $produk->where('profil_id', $profil_id);

        $kode = $request->input('kode') ?? '';
        if ($kode != '')
            $produk = $produk->where('kode', $kode);

        $kategori = $request->input('kategori') ?? '';
        if ($kategori != '')
            $produk = $produk->where('kategori', $kategori);

        $harga_awal = $request->input('harga_awal') ?? '';
        if ($harga_awal != '')
            $produk = $produk->where('harga', '>=', $harga_awal);

        $harga_akhir = $request->input('harga_akhir') ?? '';
        if ($harga_akhir != '')
            $produk = $produk->where('harga', '<=', $harga_akhir);

        if ($request->has('paginate'))
            return $produk->paginate($request->input('paginate'));
        return $produk->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->produk->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        if (!$request->has('id'))
            $result = $this->produk->create($request->all());
        else {
            $result = $this->produk->find($request->input('id'));
            $result->update($request->all());
        }
        return $result;
    }

    public function delete($id)
    {
        if ($this->detailPenjualan->where('produk_id', $id)->count() > 0) return false;
        $result = $this->produk->find($id);
        $result->delete();
        return $result;
    }
}
