@extends('layouts.auth')

@section('title')
    Login -
@endsection

@section('content')
<div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
    <div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden">
        <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35">
            <div class="d-flex flex-column-fluid flex-column flex-center">
                <img src="{{ asset('lemon.png') }}" alt="" class="img-fluid mt-3" style="width: 30%;">
                @include('tools._alert')
                <div class="login-form login-signin py-5" id="form_login">
                    <form class="form" action="{{ route('login.proses') }}" method="post">
                        @csrf
                        <div class="text-center pb-8">
                            <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign In Ke Lemon Kasir</h2>
                        </div>

                        <div class="form-group">
                            <label for="email" class="font-size-h6 font-weight-bolder text-dark">Username</label>
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="text" name="email" id="email" autocomplete="off" autofocus />
                        </div>

                        <div class="form-group">
                            <div class="d-flex justify-content-between mt-n5">
                                <label for="password" class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
                            </div>
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" name="password" id="password" autocomplete="off" />
                        </div>

                        <div class="form-group">
                            <label class="checkbox checkbox-lg font-weight-bolder text-dark">
                                <input type="checkbox" name="remember">
                                <span></span>&nbsp; &nbsp;  Simpan Login
                            </label>
                        </div>

                        <div class="text-center pt-2">
                            <button type="submit" class="btn btn-dark font-weight-bolder font-size-h6 px-8 py-4 my-3">Sign In</button>
                            <br>
                            <a href="{{ route('register') }}" class="btn btn-secondary font-weight-bold font-size-h6 px-8 mt-2">Daftar Akun Gratis</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="content order-1 order-lg-2 d-flex flex-column w-100 pb-0" style="background-color: #b1dced;">
        <div class="d-flex flex-column justify-content-center text-center pt-lg-40 pt-md-5 pt-sm-5 px-lg-0 pt-5 px-7">
            <h3 class="display4 font-weight-bolder my-7 text-dark" style="color: #986923;">Lemon Kasir</h3>
            <p class="font-weight-bolder font-size-h2-md font-size-lg text-dark opacity-70">
            </p>
        </div>
        <div class="content-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url('{{ asset('assets/media/svg/illustrations/login-visual-2.svg') }}');"></div>
    </div>
</div>
@endsection
