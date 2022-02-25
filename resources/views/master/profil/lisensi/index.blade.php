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
                    <button type="button" onclick="toggle_pencarian()" class="btn btn-secondary btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2">
                        <span class="svg-icon svg-icon-primary"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <rect x="0" y="0" width="24" height="24"/> <path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" fill="#000000"/> </g> </svg></span>
                        Filter Pencarian
                    </button>
                    <a href="{{ route('master.profil.lisensi.info', $profil->id) }}" class="btn btn-primary btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2">
                        <span class="svg-icon svg-icon-secondary"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/> <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/> </g> </svg></span>
                        Tambah
                    </a>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        @include('master.profil._sidebar', ['profil' => $profil])
                    </div>
                    <div class="col-md-9">
                        <div class="card card-custom mb-5" id="card_pencarian" style="display: none;">
                            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        Filter Pencarian
                                        <span class="d-block text-muted pt-2 font-size-sm">Cari dengan kondisi berikut</span>
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" id="form_pencarian">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lisensi_id">Lisensi</label>
                                                <select name="lisensi_id" id="lisensi_id" class="form-control select2">
                                                    <option value="">Semua Lisensi</option>
                                                    @foreach($lisensi as $item)
                                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="no_lisensi">No Lisensi</label>
                                                <input type="text" class="form-control" id="no_lisensi" name="no_lisensi">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="is_aktif">Status Lisensi</label>
                                                <select name="is_aktif" id="is_aktif" class="form-control select2">
                                                    <option value="">Semua Status</option>
                                                    <option value="1">Aktif</option>
                                                    <option value="0">Riwayat</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="harga_awal">Harga Awal</label>
                                                <input type="text" class="form-control autonumeric" id="harga_awal" name="harga_awal">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="harga_akhir">Harga Akhir</label>
                                                <input type="text" class="form-control autonumeric" id="harga_akhir" name="harga_akhir">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="berlaku_dari">Berlaku Dari</label>
                                                <input type="text" class="form-control kt-datepicker" id="berlaku_dari" name="berlaku_dari">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="berlaku_sampai">Berlaku Sampai</label>
                                                <input type="text" class="form-control kt-datepicker" id="berlaku_sampai" name="berlaku_sampai">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary font-weight-bold">Pencarian</button>
                                    <a href="{{ route('master.profil.lisensi', $profil->id) }}" class="btn btn-secondary font-weight-bold ml-2">Reset</a>
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
                            </div>
                            <div class="card-body pt-2" id="div_data_lisensi">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggle_pencarian() {
            $('#card_pencarian').slideToggle();
        }

        let selectedPage = 1,
            formPencarian = $('#form_pencarian'),
            divDataLisensi = $('#div_data_lisensi');
        divDataLisensi.html('<div class="text-center"><h4>Loading <i class="fa fa-spinner fa-spin"></i></h4></div>')
        formPencarian.submit(function (e) {
            e.preventDefault();
            search_data();
        });
        function search_data(page = '') {
            if (page.toString() === '-1') page = selectedPage - 1;
            if (page.toString() === '+1') page = selectedPage + 1;
            if (page === '') page = selectedPage;
            selectedPage = page;

            $.post("{{ route('master.profil.lisensi.search', $profil->id) }}?page=" + selectedPage, {
                _token: '{{ csrf_token() }}',
                paginate: 10,
                action: ['edit'],
                no_lisensi: $('#no_lisensi').val(),
            }, function (result) {
                divDataLisensi.html(result);
            }).fail(function (xhr) {
                console.log(xhr.responseText);
            });
        }
        search_data();
    </script>
@endpush
