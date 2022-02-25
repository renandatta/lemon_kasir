@php($execute = $execute ?? false)

@push('styles')
    <link href="{{ asset('assets/plugins/custom/jstree/jstree.bundle.css?v=7.0.9') }}" rel="stylesheet" type="text/css" />
@endpush

<h3>Program Lab Bahasa</h3>
<div id="tree_view_fitur_program" class="tree-demo">
</div>

@push('scripts')
    <script src="{{ asset('assets/plugins/custom/jstree/jstree.bundle.js?v=7.0.9') }}"></script>
    <script>
        let divTree = $("#tree_view_fitur_program");
        function tampilkan_tree_fitur_program() {
            $.post("{{ route('pengaturan.fitur_program.search') }}", {
                _token: '{{ csrf_token() }}',
            }, function (result) {
                result.push({
                    id: 999,
                    kode: 'new',
                    text: 'Tambah Fitur Baru',
                    icon: 'fa fa-plus text-primary'
                });
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
                    plugins: ["types"]
                }).on("select_node.jstree", function (e, data) {
                    on_click_tree_view_fitur_program(data);
                }).on("loaded.jstree", function () {
                    $(this).jstree("open_all");
                });
            }).fail(function (xhr) {
                console.log(xhr.responseText);
            });
        }

        @if($execute == true)
            tampilkan_tree_fitur_program();
        @endif
    </script>
@endpush
