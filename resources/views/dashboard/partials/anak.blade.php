<!-- Anak view -->
<div class="view">
    <div class="table-responsive small">
    <table class="table table-striped table-bordered table-sm">
        <thead>
            <tr class="text-center align-middle">
                <th>No</th>
                <th>Nama Anak</th>
                <th>Tempat<br>Tanggal Lahir</th>
                <th>Status keluarga</th>
                <th>Status Tunjangan</th>
                <th>Jenis Kelamin</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawai->anaks as $key => $anak)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $anak->nama }}</td>
                <td>{{ $anak->tempat_lahir }}<br>{{ $anak->tanggal_lahir }}</td>
                <td>{{ $anak->status_keluarga }}</td>
                <td>{{ $anak->status_tunjangan }}</td>
                <td>{{ $anak->jenis_kelamin }}</td>
                <td>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('anak.edit', $anak->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusAnakModal">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                    <!-- Modal Konfirmasi Hapus -->
                    <div class="modal fade" id="hapusAnakModal" tabindex="-1" aria-labelledby="hapusAnakModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="hapusAnakModalLabel">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda Yakin Ingin Menghapus Anak <strong>{{ $anak->nama }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('anak.destroy', $anak->id) }}" method="POST">
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
</div><!-- End Anak view -->