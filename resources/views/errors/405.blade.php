@extends('layouts.error')

@section('title')
    Halaman tidak ditemukan
@endsection

@section('content')
    <div class="error error-6 d-flex flex-row-fluid bgi-size-cover bgi-position-center" style="background-image: url({{ asset('assets/media/error/bg6.jpg') }});">
        <div class="d-flex flex-column flex-row-fluid text-center">
            <h1 class="error-title font-weight-boldest text-white mb-12" style="margin-top: 12rem;">Oops...</h1>
            <p class="display-4 font-weight-bold text-white">Halaman yang anda akses tidak dapat ditemukan</p>
            <a href="{{ route('/') }}" class="display-4 font-weight-bold text-white">Klik disini untuk ke halaman utama</a>
        </div>
    </div>
@endsection
