<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>Produk</th>
            <th class="text-right">Jumlah</th>
            <th class="text-right">Harga</th>
            <th class="text-right">Total Harga</th>
        </tr>
        </thead>
        <tbody>
        @php($penjualan_id = '')
        @foreach($penjualan as $key => $value)
            @if($penjualan_id != $value->penjualan_id)
                <tr>
                    <td colspan="2">{{ $value->penjualan->no_penjualan }}</td>
                    <td colspan="2" class="text-right">{{ $value->penjualan->tanggal_waktu_dibayar }}</td>
                </tr>
            @endif
            <tr>
                <td>{{ $value->produk->nama . ($value->produk->kode != '' ? ' ('. $value->produk->kode .')' : '') }}</td>
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
