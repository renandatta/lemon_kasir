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
                <div class="row">
                    <div class="col-md-3">
                        @include('master.profil._sidebar', ['profil' => $profil])
                    </div>
                    <div class="col-md-9">
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
                                <form action="{{ route('master.profil.user.save', $profil->id) }}" method="post" autocomplete="off">
                                    @csrf
                                    @if(!empty($user_profil))
                                        <input type="hidden" name="id" value="{{ $user_profil->user_id }}">
                                    @endif
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="nama" value="{{ !empty($user_profil) ? $user_profil->user->nama : '' }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Username</label>
                                                <input type="text" class="form-control" id="email" name="email" value="{{ !empty($user_profil) ? $user_profil->user->email : '' }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" @if(empty($user_profil)) required @endif>
                                                @if(!empty($user_profil))
                                                    <span class="form-text text-muted">Kosongi apabila tidak diubah</span>
                                                @endif
                                            </div>
                                            <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                                            <a href="{{ route('master.profil.user', $profil->id) }}" class="btn btn-secondary font-weight-bold">Batal</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @if(!empty($user_profil))
                                <div class="card-footer text-right p-2">
                                    <form action="{{ route('master.profil.user.delete', $profil->id) }}" method="post" id="form_hapus">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user_profil->id }}">
                                        <button type="button" class="btn btn-light-danger" onclick="hapus_data()">
                                            <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <rect x="0" y="0" width="24" height="24"/> <path d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z" fill="#000000" fill-rule="nonzero"/> <path d="M14,4.5 L14,3.5 C14,3.22385763 13.7761424,3 13.5,3 L10.5,3 C10.2238576,3 10,3.22385763 10,3.5 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/> </g> </svg></span>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
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
