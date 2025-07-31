<!-- Penghargaan view -->
<div class="view">
    <div class="title d-flex justify-content-between align-items-center mb-3">
        <small><i class="bi bi-caret-right-fill"></i> penghargaan</small>
        <!-- Tambah penghargaan Button -->
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahPenghargaanModal">
            <i class="bi bi-plus-lg"></i> Tambah Penghargaan
        </button>
    </div>
    <div class="table-responsive small">
        <table class="table table-bordered table-striped table-hover align-middle text-center">
            <thead>
                <tr class="text-center align-middle">
                    <th style="width: 50px;">No</th>
                    <th>Nama Tanda Jasa / Penghargaan</th>
                    <th>Pemberi</th>
                    <th>Tahun</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($pegawai->penghargaans->count() == 0)
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data</td>
                    </tr>
                @else
                    @foreach($pegawai->penghargaans as $key => $penghargaan)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $penghargaan->nama }}</td>
                        <td>{{ $penghargaan->pemberi }}</td>
                        <td>{{ \Carbon\Carbon::parse($penghargaan->tanggal_penghargaan)->translatedFormat('d F Y') }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPenghargaanModal-{{ $penghargaan->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusPenghargaanModal-{{ $penghargaan->id }}">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                            <!-- Modal Edit Penghargaan -->
                            <div class="modal fade" id="editPenghargaanModal-{{ $penghargaan->id }}" tabindex="-1" aria-labelledby="editPenghargaanModalLabel-{{ $penghargaan->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editPenghargaanModalLabel-{{ $penghargaan->id }}">Edit Penghargaan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('penghargaan.update', $penghargaan->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">

                                            <div class="row mb-3">
                                                <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama Tanda Jasa / Penghargaan</label>
                                                <div class="col-md-8 col-lg-9">
                                                <input name="nama" type="text" class="form-control" id="nama" value="{{ $penghargaan->nama }}" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="pemberi" class="col-md-4 col-lg-3 col-form-label">Pemberi</label>
                                                <div class="col-md-8 col-lg-9">
                                                <input name="pemberi" type="text" class="form-control" id="pemberi" value="{{ $penghargaan->pemberi }}" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Tahun</label>
                                                <div class="col-md-4 col-lg-3">
                                                    <div class="input-group mb-3">
                                                        <input name="tanggal_penghargaan" type="text" class="form-control" id="tanggal_penghargaan_edit{{ $penghargaan->id }}" value="{{ old('tanggal_penghargaan', \Carbon\Carbon::parse($penghargaan->tanggal_penghargaan)->format('d-m-Y')) }}" required>
                                                        <button class="btn btn-outline-secondary" type="button" for="tanggal_penghargaan_edit{{ $penghargaan->id }}" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center">
                                                <div class="text-center p-2">
                                                <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Simpan</button>
                                                </div>
                                                <div class="text-center p-2">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Batal</button>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="hapusPenghargaanModal-{{ $penghargaan->id }}" tabindex="-1" aria-labelledby="hapusPenghargaanModalLabel-{{ $penghargaan->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="hapusPenghargaanModalLabel-{{ $penghargaan->id }}">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus penghargaan <strong>{{ $penghargaan->nama }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('penghargaan.destroy', $penghargaan->id) }}" method="POST">
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
    <!-- Modal Tambah Penghargaan -->
    <div class="modal fade" id="tambahPenghargaanModal" tabindex="-1" aria-labelledby="tambahPenghargaanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPenghargaanModalLabel">Tambah Penghargaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('penghargaan.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                        <div class="row mb-3">
                            <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama Tanda Jasa / Penghargaan</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="pemberi" class="col-md-4 col-lg-3 col-form-label">Pemberi</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="pemberi" type="text" class="form-control @error('pemberi') is-invalid @enderror" id="pemberi" value="{{ old('pemberi') }}" required>
                                @error('pemberi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tanggal_penghargaan" class="col-md-4 col-lg-3 col-form-label">Tahun</label>
                            <div class="col-md-4 col-lg-3">
                                <div class="input-group">
                                    <input name="tanggal_penghargaan" type="text" class="form-control @error('tanggal_penghargaan') is-invalid @enderror" id="tanggal_penghargaan" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tanggal_penghargaan') }}" required>
                                    <button class="btn btn-outline-secondary" type="button" for="tanggal_penghargaan" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                    @error('tanggal_penghargaan')
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
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"s><i class="bi bi-arrow-90deg-left"></i> Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Penghargaan view -->