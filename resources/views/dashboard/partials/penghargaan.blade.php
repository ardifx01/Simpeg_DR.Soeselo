<!-- Penghargaan view -->
<div class="view">
    <div class="table-responsive small">
    <table class="table table-striped table-bordered table-sm">
        <thead>
            <tr>
                <th scope="col" style="width: 17px">No</th>
                <th scope="col" style="width: 183px">Nama Tanda Jasa / Penghargaan</th>
                <th scope="col" style="width: 120px">Pemberi</th>
                <th scope="col" style="width: 100px">Tahun</th>
                <th scope="col" style="width: 93px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawai->penghargaans as $key => $penghargaan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $penghargaan->nama }}</td>
                <td>{{ $penghargaan->pemberi }}</td>
                <td>{{ $penghargaan->tahun }}</td>
                <td>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('penghargaan.edit', $penghargaan->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapuspenghargaanModal">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                    <!-- Modal Konfirmasi Hapus -->
                    <div class="modal fade" id="hapuspenghargaanModal" tabindex="-1" aria-labelledby="hapuspenghargaanModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="hapuspenghargaanModalLabel">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda Yakin Ingin Menghapus penghargaan <strong>{{ $penghargaan->nama }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('penghargaan.destroy', $penghargaan->id) }}" method="POST">
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
</div><!-- End Penghargaan view -->