@extends('layouts.main')

@section('title')
    {{ $title }} -
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <h2 class="subheader-title text-dark font-weight-bold my-1 mr-3">{{ $title }}</h2>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom mb-5" id="card_pencarian" style="display: none;">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">
                                Pencarian
                                <span class="d-block text-muted pt-2 font-size-sm">Filter pencarian laporan data</span>
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" id="form_pencarian">
                            @csrf
                            <div class="form-group">
                                <label for="tanggal_dari">Tanggal Dari</label>
                                <input type="text" class="form-control kt-datepicker" name="tanggal_dari" id="tanggal_dari" value="{{ format_date(date('Y-m-01')) }}">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_sampai">Tanggal Sampai</label>
                                <input type="text" class="form-control kt-datepicker" name="tanggal_sampai" id="tanggal_sampai" value="{{ format_date(date('Y-m-t')) }}">
                            </div>
                            <button type="submit" class="btn btn-block btn-primary">Cari</button>
                        </form>
                    </div>
                </div>
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">
                                {{ end($breadcrumbs)['caption'] }}
                                <span class="d-block text-muted pt-2 font-size-sm">{{ end($breadcrumbs)['desc'] }}</span>
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                                <li class="nav-item">
                                    <a class="nav-link py-2 px-4 active" onclick="toggle_pencarian()">Pencarian</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body" id="data_penjualan">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let $data_penjualan = $('#data_penjualan');
        let currentPage = 1;
        function search_data(page = 1) {
            if (page.toString() === '+1') currentPage++;
            else if (page.toString() === '-1') currentPage--;
            else currentPage = page;

            $data_penjualan.html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading</div>');
            $.post('{{ route('kasir.laporan.penjualan.search') }}?page=' + currentPage, {
                _token: '{{ csrf_token() }}',
                paginate: 20,
                is_bayar: 1,
                order_penjualan: 'asc',
                tanggal_dari: $('#tanggal_dari').val(),
                tanggal_sampai: $('#tanggal_sampai').val(),
            }, (result) => {
                $data_penjualan.html(result);
            }).fail((xhr) => {
                console.log(xhr.responseText);
            });
        }
        search_data();
        function toggle_pencarian() {
            $('#card_pencarian').slideToggle();
        }
        $('#form_pencarian').submit((e) => {
            e.preventDefault();
            search_data(1);
        })
    </script>
@endpush
