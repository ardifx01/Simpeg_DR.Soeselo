<!-- Istri view -->
<div class="view">
    <div class="table-responsive small">
    <table class="table table-striped table-bordered table-sm">
        <thead>
            <tr class="text-center align-middle">
                <th>No</th>
                <th>Nama Suami/Istri</th>
                <th>Tempat<br>Tanggal Lahir</th>
                <th>Profesi</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawai->istris as $key => $istri)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $istri->nama }}</td>
                <td>{{ $istri->tempat_lahir }}<br>{{ $istri->tanggal_lahir }}</td>
                <td>{{ $istri->profesi }}</td>
                <td>{{ $istri->status_hubungan }}</td>
                <td>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('istri.edit', $istri->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusIstriModal">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                    <!-- Modal Konfirmasi Hapus -->
                    <div class="modal fade" id="hapusIstriModal" tabindex="-1" aria-labelledby="hapusIstriModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="hapusIstriModalLabel">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda Yakin Ingin Menghapus Istri <strong>{{ $istri->nama }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('istri.destroy', $istri->id) }}" method="POST">
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
</div><!-- End Istri view -->