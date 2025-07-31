<!-- Pendidikan view -->
<div class="view">
    <!-- Pendidikan Akhir -->
    <div class="title d-flex justify-content-between align-items-center mb-3">
        <small><i class="bi bi-caret-right-fill"></i> Pendidikan Akhir</small>
        <!-- Tambah Pendidikan Button -->
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahPendidikanModal">
            <i class="bi bi-plus-lg"></i> Tambah Pendidikan
        </button>
    </div>
    <div class="table-responsive small">
        <table class="table table-bordered table-striped table-hover align-middle text-center">
            <thead>
                <tr class="text-center align-middle">
                    <th style="width: 50px;">No</th>
                    <th style="width: 160px;">Tingkat Pendidikan</th>
                    <th style="width: 160px;">Jurusan</th>
                    <th style="width: 200px;">Nama Sekolah</th>
                    <th style="width: 100px;">Tahun Lulus</th>
                    <th style="width: 160px;">No Ijazah</th>
                    <th style="width: 150px;">Tanggal Ijazah</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($pegawai->pendidikans->count() == 0)
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data</td>
                    </tr>
                @else
                    @foreach ($pegawai->pendidikans as $key => $pendidikan)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $pendidikan->tingkat }}</td>
                        <td>{{ $pendidikan->jurusan }}</td>
                        <td>{{ $pendidikan->nama_sekolah }}</td>
                        <td>{{ $pendidikan->tahun_lulus }}</td>
                        <td>{{ $pendidikan->no_ijazah }}</td>
                        <td>{{ \Carbon\Carbon::parse($pendidikan->tanggal_ijazah)->translatedFormat('d F Y') }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPendidikanModal{{ $pendidikan->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapuspendidikanModal-{{ $pendidikan->id }}">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                            <!-- Modal Edit Pendidikan -->
                            <div class="modal fade" id="editPendidikanModal{{ $pendidikan->id }}" tabindex="-1" aria-labelledby="editPendidikanModalLabel{{ $pendidikan->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editPendidikanModalLabel{{ $pendidikan->id }}">Edit Pendidikan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pendidikan.update', $pendidikan->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">

                                            <div class="row mb-3">
                                                <label for="tingkat" class="col-md-4 col-lg-3 col-form-label">Tingkat Pendidikan</label>
                                                <div class="col-md-4 col-lg-3">
                                                <select class="form-select" name="tingkat" required>
                                                    @foreach(['SD','SMP','SMA','D3','D4','S1','S2','S3'] as $tingkat)
                                                    <option value="{{ $tingkat }}" {{ $pendidikan->tingkat == $tingkat ? 'selected' : '' }}>{{ $tingkat }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="jurusan{{ $pendidikan->id }}" class="col-md-4 col-lg-3 col-form-label">Jurusan</label>
                                                <div class="col-md-8 col-lg-9">
                                                <input name="jurusan" type="text" class="form-control" value="{{ $pendidikan->jurusan }}" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="nama_sekolah{{ $pendidikan->id }}" class="col-md-4 col-lg-3 col-form-label">Nama Sekolah</label>
                                                <div class="col-md-8 col-lg-9">
                                                <input name="nama_sekolah" type="text" class="form-control" value="{{ $pendidikan->nama_sekolah }}" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="tahun_lulus{{ $pendidikan->id }}" class="col-md-4 col-lg-3 col-form-label">Tahun Lulus</label>
                                                <div class="col-md-4 col-lg-3">
                                                <input name="tahun_lulus" type="number" class="form-control @error('tahun_lulus') is-invalid @enderror" min="1900" max="2099" step="1" value="{{ $pendidikan->tahun_lulus }}" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="no_ijazah{{ $pendidikan->id }}" class="col-md-4 col-lg-3 col-form-label">No Ijazah</label>
                                                <div class="col-md-8 col-lg-9">
                                                <input name="no_ijazah" type="text" class="form-control" value="{{ $pendidikan->no_ijazah }}" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Tanggal Ijazah</label>
                                                <div class="col-md-4 col-lg-3">
                                                    <div class="input-group mb-3">
                                                        <input name="tanggal_ijazah" type="text" class="form-control" id="tanggal_ijazah_edit{{ $pendidikan->id }}" value="{{ old('tanggal_ijazah', \Carbon\Carbon::parse($pendidikan->tanggal_ijazah)->format('d-m-Y')) }}" required>
                                                        <button class="btn btn-outline-secondary" type="button" for="tanggal_ijazah_edit{{ $pendidikan->id }}" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
                                                <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal"><i class="bi bi-x"></i> Batal</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="hapuspendidikanModal-{{ $pendidikan->id }}" tabindex="-1" aria-labelledby="hapuspendidikanModalLabel-{{ $pendidikan->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="hapuspendidikanModalLabel-{{ $pendidikan->id }}">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda Yakin Ingin Menghapus <strong>{{ $pendidikan->nama_sekolah }}</strong>?
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
                @endif
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Pendidikan -->
    <div class="modal fade" id="tambahPendidikanModal" tabindex="-1" aria-labelledby="tambahPendidikanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPendidikanModalLabel">Tambah Pendidikan Akhir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pendidikan.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                        <div class="row mb-3">
                            <label for="tingkat" class="col-md-4 col-lg-3 col-form-label">Tingkat Pendidikan</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-select" aria-label="Default select example" name="tingkat" id="tingkat">
                                    <option selected disabled>-- Pilihan --</option>
                                    <option value="SD" {{ old('tingkat')=='SD' ? 'selected': '' }} >SD</option>
                                    <option value="SMP" {{ old('tingkat')=='SMP' ? 'selected': '' }} >SMP</option>
                                    <option value="SMA" {{ old('tingkat')=='SMA' ? 'selected': '' }} >SMA</option>
                                    <option value="D3" {{ old('tingkat')=='D3' ? 'selected': '' }} >D3</option>
                                    <option value="D4" {{ old('tingkat')=='D4' ? 'selected': '' }} >D4</option>
                                    <option value="S1" {{ old('tingkat')=='S1' ? 'selected': '' }} >S1</option>
                                    <option value="S2" {{ old('tingkat')=='S2' ? 'selected': '' }} >S2</option>
                                    <option value="S3" {{ old('tingkat')=='S3' ? 'selected': '' }} >S3</option>
                                </select>
                                @error('tingkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jurusan" class="col-md-4 col-lg-3 col-form-label">Jurusan</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="jurusan" type="text" class="form-control @error('jurusan') is-invalid @enderror" id="jurusan" value="{{ old('jurusan') }}" required>
                                @error('jurusan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nama_sekolah" class="col-md-4 col-lg-3 col-form-label">Nama Sekolah</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nama_sekolah" type="text" class="form-control @error('nama_sekolah') is-invalid @enderror" id="nama_sekolah" value="{{ old('nama_sekolah') }}" required>
                                @error('nama_sekolah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tahun_lulus" class="col-md-4 col-lg-3 col-form-label">Tahun Lulus</label>
                            <div class="col-md-4 col-lg-3">
                                <div class="input-group">
                                    <input name="tahun_lulus" type="number" class="form-control @error('tahun_lulus') is-invalid @enderror" min="1900" max="2099" step="1" value="{{ old('tahun_lulus') }}" required>
                                    @error('tahun_lulus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="no_ijazah" class="col-md-4 col-lg-3 col-form-label">No Ijazah</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="no_ijazah" type="text" class="form-control @error('no_ijazah') is-invalid @enderror" id="no_ijazah" value="{{ old('no_ijazah') }}" required>
                                @error('no_ijazah')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tanggal_ijazah" class="col-md-4 col-lg-3 col-form-label">Tanggal Ijazah</label>
                            <div class="col-md-4 col-lg-3">
                                <div class="input-group mb-3">
                                    <input name="tanggal_ijazah" type="text" class="form-control @error('tanggal_ijazah') is-invalid @enderror" id="tanggal_ijazah" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tanggal_ijazah') }}" required>
                                    <button class="btn btn-outline-secondary" type="button" for="tanggal_ijazah" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                    @error('tanggal_ijazah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="text-center p-2">
                                <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> save</button>
                            </div>
                            <div class="text-center p-2">
                                <button type="button" class="btn btn-outline-secondary"><i class="bi bi-arrow-90deg-left"></i> cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendidikan Lanjut -->
    <div class="title d-flex justify-content-between align-items-center mb-3 mt-4">
        <small><i class="bi bi-caret-right-fill"></i> Pendidikan Lanjut</small>
        <!-- Tambah Ijin Belajar Button -->
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahIjinBelajarModal">
            <i class="bi bi-plus-lg"></i> Tambah Izin Belajar
        </button>
    </div>
    <div class="table-responsive small">
        <table class="table table-bordered table-striped table-hover align-middle text-center">
            <thead>
                <tr class="text-center align-middle">
                    <th style="width: 50px;">No</th>
                    <th style="width: 160px;">Tingkat Pendidikan</th>
                    <th style="width: 160px;">Jenis Bantuan</th>
                    <th style="width: 200px;">Nama Sekolah</th>
                    <th style="width: 100px;">Tahun Lulus</th>
                    <th style="width: 160px;">No Ijazah</th>
                    <th style="width: 150px;">Tanggal Ijazah</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($pegawai->ijin_belajars->count() == 0)
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data</td>
                    </tr>
                @else
                    @foreach ($pegawai->ijin_belajars as $key => $ijinbelajar)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $ijinbelajar->tingkat_ijin }}</td>
                        <td>{{ $ijinbelajar->jenis_ijin }}</td>
                        <td>{{ $ijinbelajar->nama_ijin }}</td>
                        <td>{{ $ijinbelajar->tahun_lulus_ijin }}</td>
                        <td>{{ $ijinbelajar->no_ijazah_ijin }}</td>
                        <td>{{ \Carbon\Carbon::parse($ijinbelajar->tanggal_ijazah_ijin)->translatedFormat('d F Y') }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editIjinBelajarModal-{{ $ijinbelajar->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusijinbelajarModal-{{ $ijinbelajar->id }}">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                            <!-- Modal Edit Ijin Belajar -->
                            <div class="modal fade" id="editIjinBelajarModal-{{ $ijinbelajar->id }}" tabindex="-1" aria-labelledby="editIjinBelajarModalLabel-{{ $ijinbelajar->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editIjinBelajarModalLabel-{{ $ijinbelajar->id }}">Edit Izin Belajar</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('ijinbelajar.update', $ijinbelajar->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                            <div class="row mb-3">
                                                <label for="tingkat_ijin" class="col-md-4 col-lg-3 col-form-label">Tingkat Pendidikan</label>
                                                <div class="col-md-4 col-lg-3">
                                                <select class="form-select" name="tingkat_ijin" required>
                                                    @foreach(['SD','SMP','SMA','D3','D4','S1','S2','S3'] as $tingkat)
                                                    <option value="{{ $tingkat }}" {{ $ijinbelajar->tingkat_ijin == $tingkat ? 'selected' : '' }}>{{ $tingkat }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Jenis Bantuan</label>
                                                <div class="col-md-4 col-lg-3">
                                                <select class="form-select" name="jenis_ijin" required>
                                                    <option value="Ijin Belajar" {{ $ijinbelajar->jenis_ijin == 'Ijin Belajar' ? 'selected' : '' }}>Ijin Belajar</option>
                                                    <option value="Tugas Belajar" {{ $ijinbelajar->jenis_ijin == 'Tugas Belajar' ? 'selected' : '' }}>Tugas Belajar</option>
                                                </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="nama_ijin{{ $ijinbelajar->id }}" class="col-md-4 col-lg-3 col-form-label">Nama Sekolah</label>
                                                <div class="col-md-8 col-lg-9">
                                                <input name="nama_ijin" type="text" class="form-control" value="{{ $ijinbelajar->nama_ijin }}" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="tahun_lulus_ijin{{ $ijinbelajar->id }}" class="col-md-4 col-lg-3 col-form-label">Tahun Lulus</label>
                                                <div class="col-md-4 col-lg-3">
                                                <input name="tahun_lulus_ijin" type="number" class="form-control @error('tahun_lulus_ijin') is-invalid @enderror" min="1900" max="2099" step="1" value="{{ $ijinbelajar->tahun_lulus_ijin }}" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="no_ijazah{{ $ijinbelajar->id }}" class="col-md-4 col-lg-3 col-form-label">No Ijazah</label>
                                                <div class="col-md-8 col-lg-9">
                                                <input name="no_ijazah_ijin" type="text" class="form-control" value="{{ $ijinbelajar->no_ijazah_ijin }}" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Tanggal Ijazah</label>
                                                <div class="col-md-4 col-lg-3">
                                                    <div class="input-group mb-3">
                                                        <input name="tanggal_ijazah_ijin" type="text" class="form-control" id="tanggal_ijazah_ijin_edit{{ $ijinbelajar->id }}" value="{{ old('tanggal_ijazah_ijin', \Carbon\Carbon::parse($ijinbelajar->tanggal_ijazah)->format('d-m-Y')) }}" required>
                                                        <button class="btn btn-outline-secondary" type="button" for="tanggal_ijazah_ijin_edit{{ $ijinbelajar->id }}" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-90deg-left"></i> Batal</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="hapusijinbelajarModal-{{ $ijinbelajar->id }}" tabindex="-1" aria-labelledby="hapusijinbelajarModalLabel-{{ $ijinbelajar->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="hapusijinbelajarModalLabel-{{ $ijinbelajar->id }}">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda Yakin Ingin Menghapus <strong>{{ $ijinbelajar->nama_ijin }}</strong>?
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
                @endif
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Ijin Belajar -->
    <div class="modal fade" id="tambahIjinBelajarModal" tabindex="-1" aria-labelledby="tambahIjinBelajarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahIjinBelajarModalLabel">Tambah Izin Belajar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('ijinbelajar.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                        <div class="row mb-3">
                            <label for="tingkat_ijin" class="col-md-4 col-lg-3 col-form-label">Tingkat Pendidikan</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-select" aria-label="Default select example" name="tingkat_ijin" id="tingkat_ijin">
                                    <option selected disabled>-- Pilihan --</option>
                                    <option value="SD" {{ old('tingkat_ijin')=='SD' ? 'selected': '' }} >SD</option>
                                    <option value="SMP" {{ old('tingkat_ijin')=='SMP' ? 'selected': '' }} >SMP</option>
                                    <option value="SMA" {{ old('tingkat_ijin')=='SMA' ? 'selected': '' }} >SMA</option>
                                    <option value="D3" {{ old('tingkat_ijin')=='D3' ? 'selected': '' }} >D3</option>
                                    <option value="D4" {{ old('tingkat_ijin')=='D4' ? 'selected': '' }} >D4</option>
                                    <option value="S1" {{ old('tingkat_ijin')=='S1' ? 'selected': '' }} >S1</option>
                                    <option value="S2" {{ old('tingkat_ijin')=='S2' ? 'selected': '' }} >S2</option>
                                    <option value="S3" {{ old('tingkat_ijin')=='S3' ? 'selected': '' }} >S3</option>
                                </select>
                                @error('tingkat_ijin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jenis_ijin" class="col-md-4 col-lg-3 col-form-label">Jenis Bantuan</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-select" aria-label="Default select example" name="jenis_ijin" id="jenis_ijin">
                                    <option selected disabled>-- Pilihan --</option>
                                    <option value="Ijin Belajar" {{ old('jenis_ijin')=='Ijin Belajar' ? 'selected': '' }}>Izin Belajar</option>
                                    <option value="Tugas Belajar" {{ old('jenis_ijin')=='Tugas Belajar' ? 'selected': '' }}>Tugas Belajar</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nama_ijin" class="col-md-4 col-lg-3 col-form-label">Nama Sekolah</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nama_ijin" type="text" class="form-control @error('nama_ijin') is-invalid @enderror" id="nama_ijin" value="{{ old('nama_ijin') }}" required>
                                @error('nama_ijin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tahun_lulus_ijin" class="col-md-4 col-lg-3 col-form-label">Tahun Lulus</label>
                            <div class="col-md-4 col-lg-3">
                                <div class="input-group">
                                    <input name="tahun_lulus_ijin" type="number" class="form-control @error('tahun_lulus_ijin') is-invalid @enderror" min="1900" max="2099" step="1" value="{{ old('tahun_lulus_ijin') }}" required>
                                    @error('tahun_lulus_ijin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="no_ijazah_ijin" class="col-md-4 col-lg-3 col-form-label">No Ijazah</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="no_ijazah_ijin" type="text" class="form-control @error('no_ijazah_ijin') is-invalid @enderror" id="no_ijazah_ijin" value="{{ old('no_ijazah_ijin') }}" required>
                                @error('no_ijazah_ijin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tanggal_ijazah_ijin" class="col-md-4 col-lg-3 col-form-label">Tanggal Ijazah</label>
                            <div class="col-md-4 col-lg-3">
                                <div class="input-group mb-3">
                                    <input name="tanggal_ijazah_ijin" type="text" class="form-control @error('tanggal_ijazah_ijin') is-invalid @enderror" id="tanggal_ijazah_ijin" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tanggal_ijazah_ijin') }}" required>
                                    <button class="btn btn-outline-secondary" type="button" for="tanggal_ijazah_ijin" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                    @error('tanggal_ijazah_ijin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="text-center p-2">
                                <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Simpan</button>
                            </div>
                            <div class="text-center p-2">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-90deg-left"></i> Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Pendidikan Umum view -->