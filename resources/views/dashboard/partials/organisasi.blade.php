<!-- Organisasi view -->
<div class="view">
    <div class="title d-flex justify-content-between align-items-center mb-3">
        <small><i class="bi bi-caret-right-fill"></i> Organisasi</small>
        <!-- Tambah Organisasi Button -->
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahOrganisasiModal">
            <i class="bi bi-plus-lg"></i> Tambah Organisasi
        </button>
    </div>
    <div class="table-responsive small">
        <table class="table table-bordered table-striped table-hover align-middle text-center">
            <thead>
                <tr class="text-center align-middle">
                    <th style="width: 50px;">No</th>
                    <th>Nama Organisasi</th>
                    <th>Jenis Organisasi</th>
                    <th>Jabatan</th>
                    <th>TMT Organisasi</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($pegawai->organisasis->count() == 0)
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data</td>
                    </tr>
                @else
                    @foreach($pegawai->organisasis as $key => $organisasi)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $organisasi->nama }}</td>
                        <td>{{ $organisasi->jenis }}</td>
                        <td>{{ $organisasi->jabatan }}</td>
                        <td>{{ \Carbon\Carbon::parse($organisasi->tmt_organisasi)->translatedFormat('d F Y') }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editOrganisasiModal-{{ $organisasi->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusorganisasiModal-{{ $organisasi->id }}">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                            <!-- Modal Edit -->
                            <div class="modal fade" id="editOrganisasiModal-{{ $organisasi->id }}" tabindex="-1" aria-labelledby="editOrganisasiModalLabel-{{ $organisasi->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <form action="{{ route('organisasi.update', $organisasi->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">

                                        <div class="modal-header">
                                        <h5 class="modal-title" id="editOrganisasiModalLabel-{{ $organisasi->id }}">Edit Organisasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>

                                        <div class="modal-body">
                                        <div class="row mb-3">
                                            <label for="nama{{ $organisasi->id }}" class="col-md-4 col-lg-3 col-form-label">Nama Organisasi</label>
                                            <div class="col-md-8 col-lg-9">
                                            <input name="nama" type="text" class="form-control" value="{{ old('nama', $organisasi->nama) }}" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="jenis{{ $organisasi->id }}" class="col-md-4 col-lg-3 col-form-label">Jenis Organisasi</label>
                                            <div class="col-md-8 col-lg-9">
                                            <input name="jenis" type="text" class="form-control" value="{{ old('jenis', $organisasi->jenis) }}" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="jabatan{{ $organisasi->id }}" class="col-md-4 col-lg-3 col-form-label">Jabatan</label>
                                            <div class="col-md-8 col-lg-9">
                                            <input name="jabatan" type="text" class="form-control" value="{{ old('jabatan', $organisasi->jabatan) }}" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="tmt_organisasi{{ $organisasi->id }}" class="col-md-4 col-lg-3 col-form-label">TMT Organisasi</label>
                                            <div class="col-md-4 col-lg-3">
                                                <div class="input-group mb-3">
                                                    <input name="tmt_organisasi" type="text" class="form-control" id="tmt_organisasi_edit{{ $organisasi->id }}" value="{{ old('tmt_organisasi', \Carbon\Carbon::parse($organisasi->tmt_organisasi)->format('d-m-Y')) }}" required>
                                                    <button class="btn btn-outline-secondary" type="button" for="tmt_organisasi_edit{{ $organisasi->id }}" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="modal-footer">
                                        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Batal</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="hapusorganisasiModal-{{ $organisasi->id }}" tabindex="-1" aria-labelledby="hapusorganisasiModalLabel-{{ $organisasi->id }}" aria-hidden="true">
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
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            </form>
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
    <!-- Modal Tambah Organisasi -->
    <div class="modal fade" id="tambahOrganisasiModal" tabindex="-1" aria-labelledby="tambahOrganisasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahOrganisasiModalLabel">Tambah Organisasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('organisasi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                        <div class="row mb-3">
                            <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama Organisasi</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jenis" class="col-md-4 col-lg-3 col-form-label">Jenis Organisasi</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="jenis" type="text" class="form-control @error('jenis') is-invalid @enderror" id="jenis" value="{{ old('jenis') }}" required>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jabatan" class="col-md-4 col-lg-3 col-form-label">Jabatan</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="jabatan" type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" value="{{ old('jabatan') }}" required>
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tmt_organisasi" class="col-md-4 col-lg-3 col-form-label">TMT Organisasi</label>
                            <div class="col-md-4 col-lg-3">
                                <div class="input-group">
                                    <input name="tmt_organisasi" type="text" class="form-control @error('tmt_organisasi') is-invalid @enderror" id="tmt_organisasi" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tmt_organisasi') }}" required>
                                    <button class="btn btn-outline-secondary" type="button" for="_organisasi" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                    @error('tmt_organisasi')
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
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-90deg-left"></i> cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Organisasi view -->