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
                    <a href="{{ route('pengaturan.user_level.info') }}" class="btn btn-primary btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2">
                        <span class="svg-icon svg-icon-secondary"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/> <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/> </g> </svg></span>
                        Tambah
                    </a>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-custom">
                            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        {{ end($breadcrumbs)['caption'] }}
                                        <span class="d-block text-muted pt-2 font-size-sm">{{ end($breadcrumbs)['desc'] }}</span>
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body pt-2" id="div_data_user_level">
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
            $formPencarian = $('#form_pencarian'),
            $divDataUserLevel = $('#div_data_user_level');
        $divDataUserLevel.html('<div class="text-center"><h4>Loading <i class="fa fa-spinner fa-spin"></i></h4></div>')
        $formPencarian.submit(function (e) {
            e.preventDefault();
            selectedPage = 1;
            search_data();
        });
        function search_data(page = '') {
            if (page.toString() === '-1') page = selectedPage - 1;
            if (page.toString() === '+1') page = selectedPage + 1;
            if (page === '') page = selectedPage;
            selectedPage = page;

            $.post("{{ route('pengaturan.user_level.search') }}?page=" + selectedPage, {
                _token: '{{ csrf_token() }}',
                paginate: 10,
                action: ['edit', 'hak_akses'],
            }, function (result) {
                $divDataUserLevel.html(result);
            }).fail(function (xhr) {
                console.log(xhr.responseText);
            });
        }
        search_data();
    </script>
@endpush
