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
                            <div class="card-body pt-2">
                                <div class="row mt-4">
                                    <div class="col-md-4 border-right" style="border-right-style: dashed!important;">
                                        @include('pengaturan.fitur_program._tree_view', ['execute' => true])
                                    </div>
                                    <div class="col-md-8" id="div_info_fitur_program" style="display:none;">
                                        <h4># Informasi Fitur Program</h4>
                                        <form action="{{ route('pengaturan.fitur_program.save') }}" method="post" id="form_fitur_program">
                                            @csrf
                                            <input type="hidden" name="id" id="fitur_program_id">
                                            <input type="hidden" name="kode" id="kode">
                                            <input type="hidden" name="parent_kode" id="parent_kode">
                                            <div class="form-group" style="display: none;" id="parent_group">
                                                <label for="parent_nama">Parent Unit Kerja</label>
                                                <input type="text" class="form-control" id="parent_nama" name="parent_nama">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="nama">Nama</label>
                                                        <input type="text" class="form-control" id="nama" name="nama">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="url">URL</label>
                                                        <input type="text" class="form-control" id="url" name="url">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="icon">Icon</label>
                                                <input type="text" class="form-control" id="icon" name="icon">
                                            </div>
                                            <div class="float-right">
                                                <div class="btn-group mr-5" id="group_reposisi">
                                                    <button type="button" class="btn btn-icon btn-secondary" onclick="reposisi('up')">
                                                        <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <polygon points="0 0 24 0 24 24 0 24"/> <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero"/> </g> </svg></span>
                                                    </button>
                                                    <button type="button" class="btn btn-icon btn-secondary" onclick="reposisi('down')">
                                                        <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <polygon points="0 0 24 0 24 24 0 24"/> <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999) "/> </g> </svg></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Simpan Fitur Program</button>
                                            <a href="{{ route('pengaturan.fitur_program') }}" class="btn btn-default">Batal</a>
                                        </form>
                                        <div class="separator separator-dashed my-5"></div>
                                        <button type="button" class="btn btn-primary" onclick="tambah_sub()" id="button_sub">Tambahkan Sub</button>
                                        <form action="{{ route('pengaturan.fitur_program.delete') }}" method="post" class="text-right float-right" id="form_hapus">
                                            @csrf
                                            <input type="hidden" name="id" id="hapus_id">
                                            <button type="submit" class="btn btn-danger">Hapus Fitur Program</button>
                                        </form>
                                    </div>
                                </div>
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
        let $divInfoFiturProgram = $('#div_info_fitur_program'),
            $kode = $('#kode'),
            $parentKode = $('#parent_kode'),
            $parentGroup = $('#parent_group'),
            $parentNama = $('#parent_nama'),
            $fiturProgramId = $('#fitur_program_id'),
            $nama = $('#nama'),
            $url = $('#url'),
            $icon = $('#icon'),
            $buttonSub = $('#button_sub'),
            $formHapus = $('#form_hapus'),
            $hapusId = $('#hapus_id'),
            $groupReposisi = $('#group_reposisi');

        function on_click_tree_view_fitur_program(data) {
            data = data.node.original;
            if (data.kode === 'new') {
                $.post("{{ route('pengaturan.fitur_program.kode_otomatis') }}", {
                    _token: '{{ csrf_token() }}',
                    parent_kode: '#'
                }, function (result) {
                    $parentGroup.hide();
                    $parentNama.val('');
                    $kode.val(result);
                    $parentKode.val('#');
                    $fiturProgramId.attr('name', '');
                    $fiturProgramId.val('');
                    $nama.val('');
                    $url.val('');
                    $icon.val('');
                    $divInfoFiturProgram.show();
                    $buttonSub.hide();
                    $formHapus.hide();
                    $hapusId.val('');
                    $hapusId.attr('name', '');
                    $groupReposisi.hide();
                }).fail(function (xhr) {
                    console.log(xhr.responseText);
                });
            } else {
                $.post("{{ route('pengaturan.fitur_program.info') }}", {
                    _token: '{{ csrf_token() }}',
                    id: data.id
                }, function (result) {
                    $parentGroup.hide();
                    $parentNama.val('');
                    $nama.val(result.nama);
                    $url.val(result.url);
                    $icon.val(result.icon);
                    $kode.val(result.kode);
                    $parentKode.val(result.parent_kode);
                    $fiturProgramId.attr('name', 'id');
                    $fiturProgramId.val(result.id);
                    $divInfoFiturProgram.show();
                    $buttonSub.show();
                    $formHapus.show();
                    $hapusId.val(result.id);
                    $hapusId.attr('name', 'id');
                    $groupReposisi.show();
                }).fail(function (xhr) {
                    console.log(xhr.responseText);
                });
            }
        }
        function tambah_sub() {
            let parentKode = $kode.val(),
                parentNama = $nama.val();
            $.post("{{ route('pengaturan.fitur_program.kode_otomatis') }}", {
                _token: '{{ csrf_token() }}',
                parent_kode: parentKode
            }, function (result) {
                $parentGroup.show();
                $parentNama.val(parentNama);
                $kode.val(result);
                $parentKode.val(parentKode);
                $nama.val('');
                $url.val('');
                $icon.val('');
                $fiturProgramId.attr('name', '');
                $fiturProgramId.val('');
                $divInfoFiturProgram.show();
                $buttonSub.hide();
                $formHapus.hide();
                $hapusId.val('');
                $hapusId.attr('name', '');
                $groupReposisi.hide();
            }).fail(function (xhr) {
                console.log(xhr.responseText);
            });
        }
        function reposisi(arah) {
            $.post("{{ route('pengaturan.fitur_program.reposisi') }}", {
                _token: '{{ csrf_token() }}',
                id: $fiturProgramId.val(),
                arah: arah
            }, function () {
                window.location.reload();
            }).fail(function (xhr) {
                console.log(xhr.responseText);
            });
        }
    </script>
@endpush

