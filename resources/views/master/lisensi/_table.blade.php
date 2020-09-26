<table class="table table-stripped">
    <thead>
    <tr>
        <th width="50px">No</th>
        <th>Nama</th>
        <th class="text-right">Harga</th>
        <th>Keterangan</th>
        @if(in_array('edit', $action))
            <th width="50px"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @if($lisensi instanceof \Illuminate\Pagination\Paginator)
        @php
            $no = isset($lisensi) ? $lisensi->firstItem() : 1;
        @endphp
    @else
        @php($no = 1)
    @endif
    @forelse($lisensi as $key => $value)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $value->nama }}</td>
            <td class="text-right">
                @if($value->harga_spesial == 0)
                    {{ format_number($value->harga) }}
                @else
                    <span class="text-muted mr-1" style="text-decoration: line-through;">{{ format_number($value->harga) }}</span>
                    {{ format_number($value->harga_spesial) }}
                @endif
            </td>
            <td>{{ $value->keterangan }}</td>
            @if(in_array('edit', $action))
                <td class="p-1">
                    <a href="{{ route('master.lisensi.info', 'id=' . $value->id) }}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon" title="Edit details">
                        <i class="la la-edit"></i>
                    </a>
                </td>
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="99" class="text-center">Data kosong</td>
        </tr>
    @endforelse
    </tbody>
</table>
@if(method_exists($lisensi,'links'))
    {{ $lisensi->links() }}
@endif
