<div class="table-responsive">
    <table class="table table-sm">
        <thead>
        <tr>
            <th>Produk</th>
            <th class="text-right">Jumlah</th>
            <th class="text-right">Harga</th>
            <th class="text-right">Total</th>
        </tr>
        </thead>
        <tbody>
        @php($penjualan_id = '')
        @foreach($penjualan as $key => $value)
            @if($penjualan_id != $value->penjualan_id)
                <tr style="background-color: #eaeaea;">
                    <td colspan="1"><b>No.{{ $value->penjualan->no_penjualan }}</b></td>
                    <td colspan="3" class="text-right"><b>{{ $value->penjualan->tanggal_waktu_dibayar }}</b></td>
                </tr>
            @endif
            <tr>
                <td>- {{ $value->produk->nama . ($value->produk->kode != '' ? ' ('. $value->produk->kode .')' : '') }}</td>
                <td class="text-right">{{ format_number($value->jumlah) }}</td>
                <td class="text-right">{{ format_number($value->harga) }}</td>
                <td class="text-right">{{ format_number($value->total_harga) }}</td>
            </tr>
            @php($penjualan_id = $value->penjualan_id ?? '')
        @endforeach
        </tbody>
    </table>
</div>
@if(method_exists($penjualan,'links'))
    {{ $penjualan->links() }}
@endif
