@foreach($penjualan as $key => $value)
    @include('kasir.penjualan._item_penjualan', ['id' => $value->id, 'detail_penjualan' => $value->detail_penjualan])
@endforeach
