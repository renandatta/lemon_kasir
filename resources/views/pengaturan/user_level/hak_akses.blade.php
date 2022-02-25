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
                        <div class="row">
                            <div class="col-md-4">
                                <h6 class="text-muted">Nama : </h6>
                                <h5 class="mb-5">{{ $user_level->nama }}</h5>
                                <h6 class="text-muted">Keterangan : </h6>
                                <h5 class="mb-5">{{ $user_level->keterangan }}</h5>
                                <a href="{{ route('pengaturan.user_level') }}" class="btn btn-secondary px-10">Kembali</a>
                            </div>
                            <div class="col-md-8 border-left" style="border-left-style: dashed!important;">
                                <h4>Akses Menu</h4>
                                <div id="tree_view_fitur_program" class="tree-demo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('assets/plugins/custom/jstree/jstree.bundle.css?v=7.0.9') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('assets/plugins/custom/jstree/jstree.bundle.js?v=7.0.9') }}"></script>
    <script>
        let divTree = $("#tree_view_fitur_program");
        $.post("{{ route('pengaturan.fitur_program.search') }}", {
            _token: '{{ csrf_token() }}',
            user_level_id: '{{ $user_level->id }}'
        }, function (result) {
            divTree.jstree({
                core: {
                    themes: {
                        responsive: false
                    },
                    check_callback: true,
                    data: result,
                },
                types: {
                    default: {
                        icon: "fa fa-folder text-primary"
                    },
                },
                plugins: ["types", "checkbox"],
                checkbox: {
                    three_state : false, // to avoid that fact that checking a node also check others
                    whole_node : false,  // to avoid checking the box just clicking the node
                    tie_selection : false // for checking without selecting and selecting without checking
                },
            }).on("loaded.jstree", function () {
                $(this).jstree("open_all");
            }).on("check_node.jstree uncheck_node.jstree", function(e, data) {
                $.post("{{ route('pengaturan.user_level.hak_akses.save') }}", {
                    _token: '{{ csrf_token() }}',
                    fitur_program_id: data.node.original.id,
                    user_level_id: '{{ $user_level->id }}',
                    flag_akses: data.node.state.checked ? 1 : 0
                }, function (result) {
                    console.log(result);
                }).fail(function (xhr) {
                    console.log(xhr.responseText);
                });
            })
        }).fail(function (xhr) {
            console.log(xhr.responseText);
        });
    </script>
@endpush
