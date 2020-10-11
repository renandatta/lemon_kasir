@php
    $id = $id ?? '_ID_';
    $detail_penjualan = $detail_penjualan ?? array();
@endphp
<div class="card card-custom mt-5 item_penjualan" id="panel_penjualan_{{ $id }}">
    <div class="card-header py-2 px-4" onclick="toggle_panel_penjualan({{ $id }})">
        <b id="no_penjualan_{{ $id }}">#{{ $id }}</b>
        <b class="float-right" id="toggle_icon_penjualan_{{ $id }}">-</b>
    </div>
    <div class="card-body p-2 px-4 card-item-penjualan" id="panel_body_penjualan_{{ $id }}" onclick="tampilkan_produk({{ $id }})">
        <table class="table table-sm mb-0">
            <thead>
            <tr>
                <th colspan="2" class="px-0 py-0" style="line-height: 10px;">Produk<br><i><small style="font-size: 55%;">Klik disini untuk mencari data produk</small></i></th>
                <th class="px-0 pr-2 py-1 text-right">Harga </th>
                <th class="px-0 py-1" width="5%"> </th>
            </tr>
            </thead>
            <tbody id="data_penjualan_{{ $id }}">
            @foreach($detail_penjualan as $key => $value)
                @include('kasir.penjualan._item_detail_penjualan', ['detail' => $value])
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer p-2" id="panel_footer_penjualan_{{ $id }}">
        <button type="button" class="btn btn-success btn-sm py-2 px-2 float-left" onclick="bayar_penjualan({{ $id }})">Pembayaran</button>
        <button type="button" class="btn btn-danger btn-sm py-2 px-2 float-right" onclick="hapus_penjualan({{ $id }})">Batal & Hapus Transaksi</button>
    </div>
</div>
