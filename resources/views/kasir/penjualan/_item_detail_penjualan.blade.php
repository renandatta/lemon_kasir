<tr id="row_detail_penjualan_{{ $detail->id }}">
    <td class="p-0 text-nowrap" style="vertical-align: middle;width: 5%;">
        <button class="btn btn-primary btn-icon-sm btn-sm text-center" style="padding: 0.125rem;" onclick="update_detail({{ $detail }})">
            <i class="la la-plus"></i>
        </button>
    </td>
    <td class="px-0 py-1 pl-2" style="line-height: 12px;">
        {{ $detail->produk->nama }}<br>
        <small>{{ format_number($detail->harga) }} x <span id="jumlah_detail_penjualan_{{ $detail->id }}">{{ format_number($detail->jumlah) }}</span></small>
    </td>
    <td class="px-0 py-1 pr-2 text-right" style="vertical-align: middle;" id="total_detail_penjualan_{{ $detail->id }}">{{ format_number($detail->total_harga) }}</td>
    <td class="p-0 text-nowrap" style="vertical-align: middle;width: 5%;">
        <button class="btn btn-danger btn-icon-sm btn-sm text-center" style="padding: 0.125rem;" onclick="hapus_detail({{ $detail->id }})">
            <i class="la la-minus"></i>
        </button>
    </td>
</tr>
