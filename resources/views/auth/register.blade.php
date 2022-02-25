@extends('layouts.auth')

@section('title')
    Daftar Akun -
@endsection

@push('styles')
    <style>
        @media (min-width: 992px) {
            .login-aside {
                margin-left: auto;
                margin-right: auto;
            }
        }
    </style>
@endpush

@section('content')
    <div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden">
            <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35">
                <div class="d-flex flex-column-fluid flex-column flex-center">
                    <img src="{{ asset('lemon.png') }}" alt="" class="img-fluid" style="width: 20%;">
                    @include('tools._alert')
                    <div class="login-form login-signin py-5" id="form_login">
                        <form class="form" action="{{ route('register.proses') }}" method="post" id="form_register">
                            @csrf
                            <div class="text-center pb-8">
                                <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Daftar Akun Gratis</h2>
                            </div>

                            <div id="register_tahap_1">
                                <div class="form-group">
                                    <label for="nama_profil" class="font-size-h6 font-weight-bold text-dark">Nama Toko</label>
                                    <input class="form-control form-control-solid h-auto py-3 px-6 rounded-md" type="text" name="nama_profil" id="nama_profil" autocomplete="off" autofocus />
                                </div>

                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label for="notelp" class="font-size-h6 font-weight-bold text-dark pt-5">No.Telp</label>
                                    </div>
                                    <input class="form-control form-control-solid h-auto py-3 px-6 rounded-md" type="text" name="notelp" id="notelp" autocomplete="off" />
                                </div>

                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label for="alamat" class="font-size-h6 font-weight-bold text-dark pt-5">Alamat</label>
                                    </div>
                                    <textarea class="form-control form-control-solid h-auto py-3 px-6 rounded-md" type="text" name="alamat" id="alamat" autocomplete="off" rows="3"></textarea>
                                </div>

                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label for="kota" class="font-size-h6 font-weight-bold text-dark pt-5">Kabupaten / Kota</label>
                                    </div>
                                    <input class="form-control form-control-solid h-auto py-3 px-6 rounded-md" type="text" name="kota" id="kota" autocomplete="off" />
                                </div>
                            </div>

                            <div id="register_tahap_2" style="display: none;">
                                <div class="form-group">
                                    <label for="nama_user" class="font-size-h6 font-weight-bold text-dark">Nama Pemilik</label>
                                    <input class="form-control form-control-solid h-auto py-3 px-6 rounded-md" type="text" name="nama_user" id="nama_user" autocomplete="off" />
                                </div>

                                <div class="form-group">
                                    <label for="email" class="font-size-h6 font-weight-bold text-dark">Username</label>
                                    <input class="form-control form-control-solid h-auto py-3 px-6 rounded-md" type="text" name="email" id="email" autocomplete="off" />
                                </div>

                                <div class="form-group">
                                    <label for="password" class="font-size-h6 font-weight-bold text-dark">Password</label>
                                    <input class="form-control form-control-solid h-auto py-3 px-6 rounded-md" type="text" name="password" id="password" autocomplete="off" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('login') }}" class="btn btn-secondary font-weight-bold font-size-h6 px-8 mt-2" id="tombol_kembali">Kembali</a>
                                    <button type="button" class="btn btn-secondary font-weight-bold font-size-h6 px-8 mt-2" id="tombol_sebelumnya" onclick="tahap_sebelumnya()" style="display: none;">Sebelumnya</button>
                                </div>
                                <div class="col-6 text-right">
                                    <button type="button" class="btn btn-primary font-weight-bold font-size-h6 px-8 mt-2" onclick="tahap_berikutnya()" id="tombol_berikutnya">Berikutnya</button>
                                    <button type="button" class="btn btn-primary font-weight-bold font-size-h6 px-8 mt-2" onclick="proses_daftar()" id="tombol_daftar" style="display: none;">Daftar Akun</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let $tombol_kembali = $('#tombol_kembali'),
            $tombol_berikutnya = $('#tombol_berikutnya'),
            $tombol_sebelumnya = $('#tombol_sebelumnya'),
            $tombol_daftar = $('#tombol_daftar');
        let $panel_tahap_1 = $('#register_tahap_1'),
            $panel_tahap_2 = $('#register_tahap_2');
        let $nama_profil = $('#nama_profil'),
            $notelp = $('#notelp'),
            $alamat = $('#alamat'),
            $kota = $('#kota'),
            $nama_user = $('#nama_user'),
            $email = $('#email'),
            $password = $('#password');

        function tahap_berikutnya() {
            if ($nama_profil.val() === '' || $notelp.val() === '' || $alamat.val() === '' || $kota === '') {
                swal.fire('Lengkapi semua kolom !');
                $nama_profil.focus();
                return;
            }

            $tombol_kembali.hide();
            $tombol_berikutnya.hide();
            $tombol_sebelumnya.show();
            $tombol_daftar.show();
            $panel_tahap_1.hide();
            $panel_tahap_2.show();

            $nama_user.focus();
        }

        function tahap_sebelumnya() {
            $tombol_kembali.show();
            $tombol_berikutnya.show();
            $tombol_sebelumnya.hide();
            $tombol_daftar.hide();
            $panel_tahap_1.show();
            $panel_tahap_2.hide();
        }

        function proses_daftar() {
            if ($nama_user.val() === '' || $email.val() === '' || $password.val() === '') {
                swal.fire('Lengkapi semua kolom !');
                $nama_user.focus();
                return;
            }

            $('#form_register').submit();
        }
    </script>
@endpush
