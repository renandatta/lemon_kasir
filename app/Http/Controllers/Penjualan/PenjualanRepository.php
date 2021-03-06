<?php

namespace App\Http\Controllers\Penjualan;

use App\Models\Penjualan\DetailPenjualan;
use App\Models\Penjualan\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanRepository
{
    protected $penjualan, $detailPenjualan;
    public function __construct(Penjualan $penjualan, DetailPenjualan $detailPenjualan)
    {
        $this->penjualan = $penjualan;
        $this->detailPenjualan = $detailPenjualan;
    }

    public function search(Request $request)
    {
        $penjualan = $this->penjualan->orderBy('id', 'desc');

        $profil_id = $request->input('profil_id') ?? '';
        if ($profil_id != '') $penjualan = $penjualan->where('profil_id', $profil_id);

        $no_penjualan = $request->input('no_penjualan') ?? '';
        if ($no_penjualan != '') $penjualan = $penjualan->where('no_penjualan', $no_penjualan);

        $tanggal = $request->input('tanggal') ?? '';
        if ($tanggal != '') $penjualan = $penjualan->whereDate('created_at', unformat_date($tanggal));

        $tanggal = $request->input('tanggal_dibayar') ?? '';
        if ($tanggal != '') $penjualan = $penjualan->whereDate('tanggal_waktu_dibayar', unformat_date($tanggal));

        $tanggal_dari = $request->input('tanggal_dari') ?? '';
        if ($tanggal_dari != '') $penjualan = $penjualan->whereDate('tanggal_waktu_dibayar', '<=', unformat_date($tanggal_dari));

        $tanggal_sampai = $request->input('tanggal_sampai') ?? '';
        if ($tanggal_sampai != '') $penjualan = $penjualan->whereDate('tanggal_waktu_dibayar', '>=', unformat_date($tanggal_sampai));

        $is_bayar = $request->input('is_bayar') ?? '';
        if ($is_bayar != '') $penjualan = $penjualan->where('is_bayar', $is_bayar);

        if ($request->has('paginate')) return $penjualan->paginate($request->input('paginate'));
        return $penjualan->get();
    }

    public function search_detail(Request $request)
    {
        $detail = $this->detailPenjualan->select('detail_penjualan.*')
            ->join('penjualan', 'penjualan.id', '=', 'detail_penjualan.penjualan_id')
            ->with(['produk']);

        $profil_id = $request->input('profil_id') ?? '';
        if ($profil_id != '') $detail = $detail->whereHas('penjualan', function ($q) use ($profil_id) {
            $q->where('profil_id', $profil_id);
        });

        $is_bayar = $request->input('is_bayar') ?? '';
        if ($is_bayar != '') $detail = $detail->where('penjualan.is_bayar', $is_bayar);

        $penjualan_id = $request->input('penjualan_id') ?? '';
        if ($penjualan_id != '') $detail = $detail->where('penjualan_id', $penjualan_id);

        $produk_id = $request->input('produk_id') ?? '';
        if ($produk_id != '') $detail = $detail->where('produk_id', $produk_id);

        $jumlah = $request->input('jumlah') ?? '';
        if ($jumlah != '') $detail = $detail->where('jumlah', $jumlah);

        $tanggal = $request->input('tanggal') ?? '';
        if ($tanggal != '') $detail = $detail->whereDate('tanggal_waktu_dibayar', unformat_date($tanggal));

        $jumlah_dari = $request->input('jumlah_dari') ?? '';
        if ($jumlah_dari != '') $detail = $detail->where('jumlah', '>=', $jumlah_dari);

        $jumlah_sampai = $request->input('jumlah_sampai') ?? '';
        if ($jumlah_sampai != '') $detail = $detail->where('jumlah', '>=', $jumlah_sampai);

        $tanggal_dari = $request->input('tanggal_dari') ?? '';
        if ($tanggal_dari != '') $detail = $detail->whereDate('tanggal_waktu_dibayar', '>=', unformat_date($tanggal_dari));

        $tanggal_sampai = $request->input('tanggal_sampai') ?? '';
        if ($tanggal_sampai != '') $detail = $detail->whereDate('tanggal_waktu_dibayar', '<=', unformat_date($tanggal_sampai));

        $group_produk = $request->input('group_produk') ?? '';
        if ($group_produk != '')
            $detail = $detail->select('produk_id', DB::raw('count(*) as jumlah'))
                ->groupBy('produk_id')
                ->orderBy('jumlah', $group_produk)
                ->with(['produk']);

        $order_penjualan = $request->input('order_penjualan') ?? '';
        if ($order_penjualan != '')
            $detail = $detail->orderBy('penjualan_id', $order_penjualan)
                ->addSelect('penjualan.tanggal_waktu_dibayar')
                ->with(['penjualan']);

        if ($request->has('paginate')) return $detail->paginate($request->input('paginate'));
        return $detail->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->penjualan->where($column, '=', $value)->first();
    }

    public function find_detail($value, $column = 'id')
    {
        return $this->detailPenjualan->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        return $this->penjualan->create($request->only('profil_id', 'no_penjualan'));
    }

    public function save_detail(Request $request)
    {
        if (!$request->has('id')) {
            $request->merge(['jumlah' => 1]);
            $detail = $this->detailPenjualan->create($request->only('penjualan_id', 'produk_id', 'jumlah', 'harga'));
        } else {
            $detail = $this->detailPenjualan->find($request->input('id'));
            $detail->update($request->all());
        }
        return $detail;
    }

    public function delete($id)
    {
        $penjualan = $this->penjualan->find($id);
        $penjualan->delete();
        return $penjualan;
    }

    public function delete_detail($id)
    {
        $detail = $this->detailPenjualan->find($id);
        $detail->jumlah--;
        if ($detail->jumlah <= 0)
            $detail->delete();
        else
            $detail->save();
        return $detail;
    }

    public function nomor_otomatis()
    {
        return date('Y') . '/' . numberToRoman(date('n')) . '/' . date('d') . '/' . strval(mt_rand(111111, 999999));
    }

    public function bayar(Request $request)
    {
        $penjualan = $this->penjualan->find($request->input('id'));
        $penjualan->total = $request->input('total');
        $penjualan->dibayar = $request->input('dibayar');
        $penjualan->tanggal_waktu_dibayar = date('Y-m-d H:i:s');
        $penjualan->is_bayar = 1;
        $penjualan->save();
        return $penjualan;
    }
}
