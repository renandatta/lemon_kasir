<div class="card card-custom mb-5">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">
                Informasi Profil
                <span class="d-block text-muted pt-2 font-size-sm">Detail informasi profil</span>
            </h3>
        </div>
    </div>
    <div class="card-body pt-2">
        <table class="table table-borderless">
            <tr><td class="px-0">Nama : <br><b>{{ $profil->nama }}</b></td></tr>
            <tr><td class="px-0">No.Telp : <br><b>{{ $profil->notelp }}</b></td></tr>
            <tr><td class="px-0">Alamat : <br><b>{{ $profil->alamat }}</b></td></tr>
            <tr><td class="px-0">Kota : <br><b>{{ $profil->kota }}</b></td></tr>
        </table>
        <a href="{{ route('master.profil') }}" class="btn btn-secondary btn-block">Kembali</a>
    </div>
</div>
