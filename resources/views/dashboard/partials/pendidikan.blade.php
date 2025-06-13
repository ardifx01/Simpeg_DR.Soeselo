<!-- Pendidikan view -->
<div class="view">
    <!-- Pendidikan Akhir -->
    <div class="title"><small><i class="bi bi-caret-right-fill"></i> Pendidikan Akhir</small></div>
    <div class="table-responsive small">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th scope="col" style="width: 17px">No</th>
                    <th scope="col" style="width: 183px">Tingkat Pendidikan</th>
                    <th scope="col" style="width: 102px">Jurusan</th>
                    <th scope="col" style="width: 225px">Nama Sekolah</th>
                    <th scope="col" style="width: 102px">Tahun Lulus</th>
                    <th scope="col" style="width: 102px">No Ijazah</th>
                    <th scope="col" style="width: 102px">Tanggal Ijazah</th>
                    <th scope="col" style="width: 93px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawai->pendidikans as $key => $pendidikan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pendidikan->tingkat }}</td>
                    <td>{{ $pendidikan->jurusan }}</td>
                    <td>{{ $pendidikan->nama }}</td>
                    <td>{{ $pendidikan->tahun_lulus }}</td>
                    <td>{{ $pendidikan->no_ijazah }}</td>
                    <td>{{ $pendidikan->tanggal_ijazah }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('pendidikan.edit', $pendidikan->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapuspendidikanModal">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                        <!-- Modal Konfirmasi Hapus -->
                        <div class="modal fade" id="hapuspendidikanModal" tabindex="-1" aria-labelledby="hapuspendidikanModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapuspendidikanModalLabel">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda Yakin Ingin Menghapus <strong>{{ $pendidikan->nama }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('pendidikan.destroy', $pendidikan->id) }}" method="POST">
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
    <!-- Pendidikan Lanjut -->
    <div class="title"><small><i class="bi bi-caret-right-fill"></i> Pendidikan Lanjut</small></div>
    <div class="table-responsive small">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th scope="col" style="width: 17px">No</th>
                    <th scope="col" style="width: 183px">Tingkat Pendidikan</th>
                    <th scope="col" style="width: 102px">Jenis Bantuan</th>
                    <th scope="col" style="width: 225px">Nama Sekolah</th>
                    <th scope="col" style="width: 102px">Tahun Lulus</th>
                    <th scope="col" style="width: 102px">No Ijazah</th>
                    <th scope="col" style="width: 102px">Tanggal Ijazah</th>
                    <th scope="col" style="width: 93px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawai->ijin_belajars as $key => $ijinbelajar)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ijinbelajar->tingkat }}</td>
                    <td>{{ $ijinbelajar->jenis }}</td>
                    <td>{{ $ijinbelajar->nama }}</td>
                    <td>{{ $ijinbelajar->tahun_lulus }}</td>
                    <td>{{ $ijinbelajar->no_ijazah }}</td>
                    <td>{{ $ijinbelajar->tanggal_ijazah }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('ijinbelajar.edit', $ijinbelajar->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusijinbelajarModal">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                        <!-- Modal Konfirmasi Hapus -->
                        <div class="modal fade" id="hapusijinbelajarModal" tabindex="-1" aria-labelledby="hapusijinbelajarModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusijinbelajarModalLabel">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda Yakin Ingin Menghapus <strong>{{ $ijinbelajar->nama }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('ijinbelajar.destroy', $ijinbelajar->id) }}" method="POST">
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
</div><!-- End Pendidikan Umum view -->