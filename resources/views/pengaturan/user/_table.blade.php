<table class="table table-stripped">
    <thead>
    <tr>
        <th width="50px">No</th>
        <th>Nama</th>
        <th>Username</th>
        <th>User Level</th>
        <th>Terakhir Login</th>
        @if(in_array('edit', $action))
            <th width="50px"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @if($user instanceof \Illuminate\Pagination\Paginator)
        @php
            $no = isset($user) ? $user->firstItem() : 1;
        @endphp
    @else
        @php($no = 1)
    @endif
    @forelse($user as $key => $value)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $value->nama }}</td>
            <td>{{ $value->email }}</td>
            <td>{{ $value->user_level->nama }}</td>
            <td>{{ !empty($value->last_login) ? $value->last_login->created_at : '-' }}</td>
            @if(in_array('edit', $action))
                <td class="p-1">
                    <a href="{{ route('pengaturan.user.info', 'id=' . $value->id) }}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon" title="Edit details">
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
@if(method_exists($user,'links'))
    {{ $user->links() }}
@endif
