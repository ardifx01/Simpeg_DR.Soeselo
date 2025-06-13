<!-- Organisasi view -->
<div class="view">
    <div class="table-responsive small">
    <table class="table table-striped table-bordered table-sm">
        <thead>
            <tr class="text-center align-middle">
                <th>No</th>
                <th>Nama Organisasi</th>
                <th>Jenis Organisasi</th>
                <th>Jabatan</th>
                <th>TMT</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawai->organisasis as $key => $organisasi)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $organisasi->nama }}</td>
                <td>{{ $organisasi->jenis }}</td>
                <td>{{ $organisasi->jabatan }}</td>
                <td>{{ $organisasi->tmt }}</td>
                <td>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('organisasi.edit', $organisasi->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusorganisasiModal">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                    <!-- Modal Konfirmasi Hapus -->
                    <div class="modal fade" id="hapusorganisasiModal" tabindex="-1" aria-labelledby="hapusorganisasiModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="hapusorganisasiModalLabel">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda Yakin Ingin Menghapus organisasi <strong>{{ $organisasi->nama }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('organisasi.destroy', $organisasi->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>                                
            @endforeach
        </tbody>
        </table>
    </div>
</div><!-- End Organisasi view -->