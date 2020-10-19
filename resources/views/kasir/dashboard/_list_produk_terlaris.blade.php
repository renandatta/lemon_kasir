@foreach($terlaris as $value)
    <div class="d-flex align-items-center flex-wrap mb-5">
        <div class="d-flex flex-column flex-grow-1 mr-2">
            <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ $value->produk->nama }}</a>
            <span class="text-muted font-weight-bold">Rp. {{ format_number($value->produk->harga) }}</span>
        </div>
        <span class="label label-xl label-light label-inline my-lg-0 my-2 text-dark-50 font-weight-bolder">{{ $value->jumlah }}</span>
    </div>
@endforeach
