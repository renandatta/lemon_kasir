@extends('kasir.pengaturan.index')

@section('sub_content')
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
            <form action="{{ route('kasir.pengaturan.save', $profil->id) }}" method="post" autocomplete="off">
                @csrf
                <input type="hidden" name="id" value="{{ $profil->id }}">
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
                        <a href="{{ route('kasir.pengaturan') }}" class="btn btn-secondary font-weight-bold">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
