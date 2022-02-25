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
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">
                                {{ end($breadcrumbs)['caption'] }}
                                <span class="d-block text-muted pt-2 font-size-sm">{{ end($breadcrumbs)['desc'] }}</span>
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($lisensi as $key => $value)
                            <div class="card shadow-sm">
                                <div class="card-body p-2">
                                    <div class="row">
                                        <div class="col-6">
                                            <h3 class="mb-0">{{ $value->lisensi->nama }}</h3>
                                            {{ $value->harga > 0 ? format_number($value->harga) : '' }}
                                        </div>
                                        <div class="col-6 text-right">
                                            {{ fulldate($value->berlaku_dari) }} <br>
                                            s/d {{ $value->berlaku_sampai != '' ? fulldate($value->berlaku_sampai) : ' selamanya' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
