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
                        <form action="{{ route('master.profil.save') }}" method="post" autocomplete="off">
                            @csrf
                            @if(!empty($profil))
                                <input type="hidden" name="id" value="{{ $profil->id }}">
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="{{ !empty($profil) ? $profil->nama : old('nama') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="notelp">No.Telp</label>
                                        <input type="text" class="form-control" id="notelp" name="notelp" value="{{ !empty($profil) ? $profil->notelp : old('notelp') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat" value="{{ !empty($profil) ? $profil->alamat : old('alamat') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="kota">Kota</label>
                                        <input type="text" class="form-control" id="kota" name="kota" value="{{ !empty($profil) ? $profil->kota : old('kota') }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                                    <a href="{{ route('master.profil') }}" class="btn btn-secondary font-weight-bold">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if(!empty($profil))
                        <div class="card-footer text-right p-2">
                            <form action="{{ route('master.profil.delete') }}" method="post" id="form_hapus">
                                @csrf
                                <input type="hidden" name="id" value="{{ $profil->id }}">
                                <button type="button" class="btn btn-light-danger" onclick="hapus_data()">
                                    <i class="la la-times"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function hapus_data() {
            Swal.fire({
                title: 'Hapus data?',
                text: "Data yang dihapus tidak dapat dikembalikan lagi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelmButtonText: 'Batal',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.value) {
                    $('#form_hapus').submit();
                }
            })
        }
    </script>
@endpush
