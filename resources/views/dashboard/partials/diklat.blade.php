<!-- Diklat view -->
<div class="view">
    <!-- Diklat Fungsional -->
    <div class="title"><small><i class="bi bi-caret-right-fill"></i> Diklat Fungsional</small></div>
    <div class="table-responsive small">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th scope="col" style="width: 17px">No</th>
                    <th scope="col" style="width: 102px">Nama</th>
                    <th scope="col" style="width: 183px">Penyelenggara</th>
                    <th scope="col" style="width: 102px">Jumlah Jam</th>
                    <th scope="col" style="width: 120px">Tanggal Selesai</th>
                    <th scope="col" style="width: 93px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawai->diklat_fungsionals as $key => $diklatfungsional)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $diklatfungsional->nama }}</td>
                    <td>{{ $diklatfungsional->penyelenggara }}</td>
                    <td>{{ $diklatfungsional->jumlah_jam }}</td>
                    <td>{{ $diklatfungsional->tanggal_selesai }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('diklatfungsional.edit', $diklatfungsional->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusdiklatfungsionalModal">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                        <!-- Modal Konfirmasi Hapus -->
                        <div class="modal fade" id="hapusdiklatfungsionalModal" tabindex="-1" aria-labelledby="hapusdiklatfungsionalModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusdiklatfungsionalModalLabel">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda Yakin Ingin Menghapus <strong>{{ $diklatfungsional->nama }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('diklatfungsional.destroy', $diklatfungsional->id) }}" method="POST">
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
    <!-- Diklat Jabatan -->
    <div class="title"><small><i class="bi bi-caret-right-fill"></i> Diklat Jabatan</small></div>
    <div class="table-responsive small">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th scope="col" style="width: 17px">No</th>
                    <th scope="col" style="width: 102px">Nama</th>
                    <th scope="col" style="width: 183px">Penyelenggara</th>
                    <th scope="col" style="width: 102px">Jumlah Jam</th>
                    <th scope="col" style="width: 120px">Tanggal Selesai</th>
                    <th scope="col" style="width: 93px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawai->diklat_jabatans as $key => $diklatjabatan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $diklatjabatan->nama }}</td>
                    <td>{{ $diklatjabatan->penyelenggara }}</td>
                    <td>{{ $diklatjabatan->jumlah_jam }}</td>
                    <td>{{ $diklatjabatan->tanggal_selesai }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('diklatjabatan.edit', $diklatjabatan->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusdiklatjabatanModal">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                        <!-- Modal Konfirmasi Hapus -->
                        <div class="modal fade" id="hapusdiklatjabatanModal" tabindex="-1" aria-labelledby="hapusdiklatjabatanModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusdiklatjabatanModalLabel">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda Yakin Ingin Menghapus <strong>{{ $diklatjabatan->nama }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('diklatjabatan.destroy', $diklatjabatan->id) }}" method="POST">
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
    <!-- Diklat teknis -->
    <div class="title"><small><i class="bi bi-caret-right-fill"></i> Diklat Teknis</small></div>
    <div class="table-responsive small">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th scope="col" style="width: 17px">No</th>
                    <th scope="col" style="width: 102px">Nama</th>
                    <th scope="col" style="width: 183px">Penyelenggara</th>
                    <th scope="col" style="width: 102px">Jumlah Jam</th>
                    <th scope="col" style="width: 120px">Tanggal Selesai</th>
                    <th scope="col" style="width: 93px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawai->diklat_tekniks as $key => $diklatteknik)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $diklatteknik->nama }}</td>
                    <td>{{ $diklatteknik->penyelenggara }}</td>
                    <td>{{ $diklatteknik->jumlah_jam }}</td>
                    <td>{{ $diklatteknik->tanggal_selesai }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('diklatteknik.edit', $diklatteknik->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusdiklatteknikModal">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                        <!-- Modal Konfirmasi Hapus -->
                        <div class="modal fade" id="hapusdiklatteknikModal" tabindex="-1" aria-labelledby="hapusdiklatteknikModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusdiklatteknikModalLabel">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda Yakin Ingin Menghapus <strong>{{ $diklatteknik->nama }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('diklatteknik.destroy', $diklatteknik->id) }}" method="POST">
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
</div><!-- End Diklat view -->