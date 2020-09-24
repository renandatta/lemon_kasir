<table class="table table-stripped">
    <thead>
    <tr>
        <th width="50px">No</th>
        <th>Nama</th>
        <th>Keterangan</th>
        @if(in_array('edit', $action))
            <th width="50px"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($user_level as $key => $value)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $value->nama }}</td>
            <td>{{ $value->keterangan }}</td>
            @if(in_array('edit', $action))
                <td class="p-1">
                    <a href="{{ route('pengaturan.user_level.info', 'id=' . $value->id) }}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon">
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
