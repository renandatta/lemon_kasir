@extends('layouts.main')

@section('title')
    {{ $title }} -
@endsection

@push('styles')
    <style>
        .card-produk {
            min-height: 250px;
            position: sticky;
            bottom: 0;
        }
        .card-pembayaran {
            min-height: 320px;
            position: sticky;
            bottom: 0;
        }
    </style>
@endpush

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <button type="button" onclick="penjualan_baru()" class="btn btn-primary btn-block font-weight-bold text-center mt-5" id="button_penjualan_baru">
                    <span class="svg-icon svg-icon-light"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/> <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/> </g> </svg></span>
                    Transaksi Penjualan Baru
                </button>
                <div id="content_penjualan">
                </div>
                <div class="card card-custom mt-5 card-produk shadow-sm" id="panel_data_produk" style="display: none;">
                    <div class="card-header p-0">
                        <p class="mb-0 mt-2 ml-3" style="line-height: 10px">Pilih Produk / Menu<br><small>Klik pada produk untuk menambahkan pada transaksi</small></p>
                        <button type="button" class="btn btn-link btn-icon btn-sm p-0 ml-auto" onclick="tutup_produk()">
                            <span class="svg-icon svg-icon-danger"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000"> <rect x="0" y="7" width="16" height="2" rx="1"/> <rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) " x="0" y="7" width="16" height="2" rx="1"/> </g> </g> </svg></span>
                        </button>
                    </div>
                    <div class="card-body p-2 px-4" style="overflow-y: scroll;">
                        <div class="row px-2" id="list_data_produk" style="margin-top: 25px;">
                        </div>
                    </div>
                </div>
                <div class="card card-custom mt-5 card-pembayaran shadow-sm" id="panel_pembayaran" style="display: none;">
                    <div class="card-header p-0">
                        <p class="mb-0 mt-2 ml-3" style="line-height: 10px">Pembayaran<br><small>Bayar dan selesaikan transaksi</small></p>
                        <button type="button" class="btn btn-link btn-icon btn-sm p-0 ml-auto" onclick="tutup_pembayaran()">
                            <span class="svg-icon svg-icon-danger"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000"> <rect x="0" y="7" width="16" height="2" rx="1"/> <rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) " x="0" y="7" width="16" height="2" rx="1"/> </g> </g> </svg></span>
                        </button>
                    </div>
                    <div class="card-body p-2 px-4" style="overflow-y: scroll;">
                        <table class="table table-borderless table-sm">
                            <tr><td class="p-0 font-size-h2">Total</td><td class="p-0 text-right font-size-h2" id="total_harga_penjualan">0</td></tr>
                            <tr><td class="p-0 font-size-h2">Dibayar</td><td class="p-0 text-right font-size-h2" id="dibayar_penjualan">0</td></tr>
                            <tr><td class="p-0 font-size-h2">Kembali</td><td class="p-0 text-right font-size-h2" id="kembali_penjualan">0</td></tr>
                        </table>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td><button class="btn btn-block btn-primary font-size-h2 py-0" onclick="tombol_pembayaran('7')">7</button></td>
                                <td><button class="btn btn-block btn-primary font-size-h2 py-0" onclick="tombol_pembayaran('8')">8</button></td>
                                <td><button class="btn btn-block btn-primary font-size-h2 py-0" onclick="tombol_pembayaran('9')">9</button></td>
                                <td><button class="btn btn-block btn-danger font-size-h2 py-0" onclick="tombol_pembayaran('c')"><i class="fa fa-times-circle"></i></button></td>
                            </tr>
                            <tr>
                                <td><button class="btn btn-block btn-primary font-size-h2 py-0" onclick="tombol_pembayaran('4')">4</button></td>
                                <td><button class="btn btn-block btn-primary font-size-h2 py-0" onclick="tombol_pembayaran('5')">5</button></td>
                                <td><button class="btn btn-block btn-primary font-size-h2 py-0" onclick="tombol_pembayaran('6')">6</button></td>
                                <td><button class="btn btn-block btn-danger font-size-h2 py-0" onclick="tombol_pembayaran('bcs')"><i class="fa fa-backspace"></i></button></td>
                            </tr>
                            <tr>
                                <td><button class="btn btn-block btn-primary font-size-h2 py-0" onclick="tombol_pembayaran('1')">1</button></td>
                                <td><button class="btn btn-block btn-primary font-size-h2 py-0" onclick="tombol_pembayaran('2')">2</button></td>
                                <td><button class="btn btn-block btn-primary font-size-h2 py-0" onclick="tombol_pembayaran('3')">3</button></td>
                                <td rowspan="2"><button class="btn btn-block btn-success font-size-h2 py-0 h-75px" onclick="selesai_bayar()"><i class="fa fa-check-circle font-size-h1"></i></button></td>
                            </tr>
                            <tr>
                                <td colspan="3"><button class="btn btn-block btn-primary font-size-h2 py-0" onclick="tombol_pembayaran('0')">0</button></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="template_penjualan" style="display: none;">
        @include('kasir.penjualan._item_penjualan')
    </div>
@endsection

@push('scripts')
    <script>
        let $content_penjualan = $('#content_penjualan'),
            $button_penjualan_baru = $('#button_penjualan_baru'),
            $panel_penjualan_baru = $('#panel_penjualan_baru'),
            $panel_data_produk = $('#panel_data_produk'),
            $list_data_produk = $('#list_data_produk'),
            $panel_pembayaran = $('#panel_pembayaran');

        let selectedId = '', dibayar = '';

        // penjualan
        function search_penjualan() {
            $content_penjualan.html('<div class="text-center mt-5"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading</div>');
            $.post("{{ route('kasir.penjualan.search') }}", {
                _token: '{{ csrf_token() }}',
                is_bayar: 0
            }, (result) => {
                $content_penjualan.html(result);
            }).fail((xhr) => {
                console.log(xhr.responseText);
            });
        }
        search_penjualan();
        function penjualan_baru() {
            $.post("{{ route('kasir.penjualan.new') }}", {
                _token: '{{ csrf_token() }}'
            }, (result) => {
                let panel_baru = $('#template_penjualan');
                panel_baru = panel_baru.html().replace(/_ID_/g, result.id);
                $content_penjualan.prepend(panel_baru);
            }).fail((xhr) => {
                console.log(xhr.responseText);
            });
        }
        function hapus_penjualan(id) {
            Swal.fire({
                title: 'Anda Yakin ?',
                text: "Transaksi penjualan akan dihapus",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonText: 'Jangan Dihapus',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.value) {
                    $.post("{{ route('kasir.penjualan.delete') }}", {
                        _token: '{{ csrf_token() }}', id
                    }, (result) => {
                        $('#panel_penjualan_' + result.id).remove();
                    }).fail((xhr) => {
                        console.log(xhr.responseText);
                    });
                }
            })
        }
        function bayar_penjualan(id) {
            let $selected_item = $('#panel_penjualan_' + id);
            selectedId = id;
            $button_penjualan_baru.hide();
            $('.item_penjualan').hide();
            $selected_item.show();

            pembayaran_height();
            $panel_data_produk.hide();
            $panel_pembayaran.show();

            let $total_harga_penjualan = $('#total_harga_penjualan');
            $total_harga_penjualan.html('<i class="fa fa-spinner fa-spin"></i>')
            dibayar = '';
            $.post("{{ route('kasir.penjualan.total') }}", {
                _token: '{{ csrf_token() }}', id
            }, (result) => {
                $total_harga_penjualan.html(add_commas(result));
            }).fail((xhr) => {
                console.log(xhr.responseText);
            });
        }
        function tutup_pembayaran() {
            $('.item_penjualan').show();
            $button_penjualan_baru.show();
            $panel_pembayaran.hide();
        }
        function tombol_pembayaran(tombol) {
            switch (tombol) {
                case 'c' :
                    dibayar = '';
                    break;
                case 'bcs' :
                    dibayar = dibayar.substr(0, dibayar.length-1);
                    break;
                default :
                    dibayar += tombol;
                    break;
            }
            let total = $('#total_harga_penjualan').html();
            let kembali = parseInt(remove_commas(dibayar)) - parseInt(remove_commas(total));
            $('#dibayar_penjualan').html(dibayar === '' ? '0' : add_commas(dibayar));
            $('#kembali_penjualan').html(kembali === '' ? '0' : add_commas(kembali));
        }
        function selesai_bayar() {
            let kembali = parseInt(remove_commas($('#kembali_penjualan').html()));
            if (kembali <= 0) {
                swal.fire("Pembayaran kurang !");
            } else {
                $.post("{{ route('kasir.penjualan.bayar') }}", {
                    _token: '{{ csrf_token() }}',
                    ajax: 1,
                    id: selectedId,
                    total: $('#total_harga_penjualan').html(),
                    dibayar: $('#dibayar_penjualan').html()
                }, (result) => {
                    tutup_pembayaran();
                    $('#panel_penjualan_' + result.id).remove();
                    swal.fire("Pembayaran selesai !");
                }).fail((xhr) => {
                    console.log(xhr.responseText);
                });
            }
        }

        // penjualan detail
        function toggle_panel_penjualan(id) {
            $('#panel_footer_penjualan_' + id).toggle();
            $('#panel_body_penjualan_' + id).slideToggle();
        }
        function tambahkan_detail(produk) {
            $.post("{{ route('kasir.penjualan.detail.save') }}", {
                _token: '{{ csrf_token() }}',
                penjualan_id: selectedId,
                produk_id: produk.id,
                harga: produk.harga
            }, (result) => {
                $('#data_penjualan_' + selectedId).append(result);
                produk_height();
            }).fail((xhr) => {
                console.log(xhr.responseText);
            });
        }
        function update_detail(detail) {
            $('#total_detail_penjualan_' + detail.id).html('<i class="fa fa-spinner fa-spin"></i>');
            $.post("{{ route('kasir.penjualan.detail.update') }}", {
                _token: '{{ csrf_token() }}',
                id: detail.id
            }, (result) => {
                $('#jumlah_detail_penjualan_' + result.id).html(result.jumlah);
                $('#total_detail_penjualan_' + result.id).html(add_commas(result.total_harga));
            }).fail((xhr) => {
                console.log(xhr.responseText);
            });
        }
        function hapus_detail(id) {
            $('#total_detail_penjualan_' + id).html('<i class="fa fa-spinner fa-spin"></i>');
            $.post("{{ route('kasir.penjualan.detail.delete') }}", {
                _token: '{{ csrf_token() }}',
                id
            }, (result) => {
                if (result.jumlah <= 0) {
                    $('#row_detail_penjualan_' + result.id).remove();
                } else {
                    $('#jumlah_detail_penjualan_' + result.id).html(result.jumlah);
                    $('#total_detail_penjualan_' + result.id).html(add_commas(result.total_harga));
                }
            }).fail((xhr) => {
                console.log(xhr.responseText);
            });
        }

        // produk
        function tampilkan_produk(id) {
            let $selected_item = $('#panel_penjualan_' + id);
            selectedId = id;
            $button_penjualan_baru.hide();
            $('.item_penjualan').hide();
            $selected_item.show();

            produk_height();
            $panel_data_produk.show();
            $panel_pembayaran.hide();
        }
        function produk_height() {
            let $selected_item = $('#panel_penjualan_' + selectedId);
            $panel_data_produk.height($(window).height() - 80 - $selected_item.outerHeight());
        }
        function tutup_produk() {
            $('.item_penjualan').show();
            $button_penjualan_baru.show();
            $panel_data_produk.hide();
        }
        function search_produk() {
            $.post("{{ route('kasir.produk.search') }}", {
                _token: '{{ csrf_token() }}',
                profil_id: '{{ Auth::user()->user_profil->profil_id }}',
                view: 'penjualan._list_produk'
            }, (result) => {
                $list_data_produk.html(result);
            }).fail((xhr) => {
                console.log(xhr.responseText);
            });
        }
        search_produk();

        function pembayaran_height() {
            let $selected_item = $('#panel_penjualan_' + selectedId);
            $panel_pembayaran.height($(window).height() - 80 - $selected_item.outerHeight());
        }
    </script>

@endpush
