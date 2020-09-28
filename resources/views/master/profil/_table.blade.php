<table class="table table-stripped">
    <thead>
    <tr>
        <th width="50px">No</th>
        <th>Nama</th>
        <th>Notelp</th>
        <th>Alamat</th>
        <th>Kota</th>
        @if(in_array('edit', $action))
            <th width="50px"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @if($profil instanceof \Illuminate\Pagination\Paginator)
        @php
            $no = isset($profil) ? $profil->firstItem() : 1;
        @endphp
    @else
        @php($no = 1)
    @endif
    @forelse($profil as $key => $value)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $value->nama }}</td>
            <td>{{ $value->notelp }}</td>
            <td>{{ $value->alamat }}</td>
            <td>{{ $value->kota }}</td>
            @if(in_array('edit', $action))
                <td class="p-1">
                    <a href="{{ route('master.profil.info', 'id=' . $value->id) }}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon" title="Edit details">
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
@if(method_exists($profil,'links'))
    {{ $profil->links() }}
@endif
