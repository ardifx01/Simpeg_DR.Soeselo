<!-- Anak view -->
<div class="view">
    <!-- Tombol Tambah Anak -->
    <div class="mb-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahAnakModal">
            <i class="bi bi-person-plus"></i> Tambah Anak
        </button>
    </div>
    <div class="table-responsive small">
        <table class="table table-bordered table-striped table-hover align-middle text-center">
            <thead>
                <tr class="text-center align-middle">
                    <th style="width: 50px;">No</th>
                    <th>Nama Anak</th>
                    <th>Tempat<br>Tanggal Lahir</th>
                    <th>Status keluarga</th>
                    <th>Status Tunjangan</th>
                    <th>Jenis Kelamin</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($pegawai->anaks->count() == 0)
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data</td>
                    </tr>
                @else
                    @foreach($pegawai->anaks as $key => $anak)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $anak->nama }}</td>
                        <td>{{ $anak->tempat_lahir }}<br>{{ \Carbon\Carbon::parse($anak->tanggal_lahir_anak)->translatedFormat('d F Y') }}</td>
                        <td>{{ $anak->status_keluarga }}</td>
                        <td>{{ $anak->status_tunjangan }}</td>
                        <td>{{ $anak->jenis_kelamin }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editAnakModal{{ $anak->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusAnakModal{{ $anak->id }}">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                            <!-- Modal Edit Anak -->
                            <div class="modal fade" id="editAnakModal{{ $anak->id }}" tabindex="-1" aria-labelledby="editAnakModalLabel{{ $anak->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editAnakModalLabel{{ $anak->id }}">Edit Anak</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('anak.update', $anak->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">

                                            <div class="row mb-3">
                                                <label for="nama{{ $anak->id }}" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                                <div class="col-md-8 col-lg-9">
                                                <input name="nama" type="text" class="form-control" id="nama{{ $anak->id }}" value="{{ $anak->nama }}" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Tempat, Tanggal Lahir</label>
                                                <div class="col-md-4 col-lg-3">
                                                <input name="tempat_lahir" type="text" class="form-control" value="{{ $anak->tempat_lahir }}" required>
                                                </div>
                                                <div class="col-md-4 col-lg-3">
                                                    <div class="input-group">
                                                        <input name="tanggal_lahir_anak" type="text" class="form-control" id="tanggal_lahir_anak_edit_{{ $anak->id }}" value="{{ old('tanggal_lahir_anak', \Carbon\Carbon::parse($anak->tanggal_lahir_anak)->format('d-m-Y')) }}" required>
                                                        <button class="btn btn-outline-secondary" type="button" for="tanggal_lahir_anak_edit_{{ $anak->id }}"><i class="bi bi-calendar3"></i></button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Status Keluarga</label>
                                                <div class="col-md-4 col-lg-3">
                                                <select class="form-select" name="status_keluarga" required>
                                                    <option disabled>-- Pilihan --</option>
                                                    <option value="Anak Kandung" {{ $anak->status_keluarga == 'Anak Kandung' ? 'selected' : '' }}>Anak Kandung</option>
                                                    <option value="Anak Angkat" {{ $anak->status_keluarga == 'Anak Angkat' ? 'selected' : '' }}>Anak Angkat</option>
                                                    <option value="Anak Tiri" {{ $anak->status_keluarga == 'Anak Tiri' ? 'selected' : '' }}>Anak Tiri</option>
                                                </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Status Tunjangan</label>
                                                <div class="col-md-4 col-lg-3">
                                                <select class="form-select" name="status_tunjangan" required>
                                                    <option disabled>-- Pilihan --</option>
                                                    <option value="Dapat" {{ $anak->status_tunjangan == 'Dapat' ? 'selected' : '' }}>Dapat</option>
                                                    <option value="Tidak Dapat" {{ $anak->status_tunjangan == 'Tidak Dapat' ? 'selected' : '' }}>Tidak Dapat</option>
                                                </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3 form-group">
                                                <label class="col-md-4 col-lg-3 col-form-label">Jenis Kelamin</label>
                                                <div class="col-md-8 col-lg-9 mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki_laki{{ $anak->id }}" value="Laki-laki" {{ $anak->jenis_kelamin == 'Laki-laki' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="laki_laki{{ $anak->id }}">Laki-laki</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan{{ $anak->id }}" value="Perempuan" {{ $anak->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="perempuan{{ $anak->id }}">Perempuan</label>
                                                </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
                                                <button type="button" class="btn btn-outline-secondary ms-2" data-bs-dismiss="modal"><i class="bi bi-x"></i> Batal</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="hapusAnakModal{{ $anak->id }}" tabindex="-1" aria-labelledby="hapusAnakModalLabel" aria-hidden="true">
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
                @endif
            </tbody>
        </table>
    </div>
    <!-- Modal Tambah Anak -->
    <div class="modal fade" id="tambahAnakModal" tabindex="-1" aria-labelledby="tambahAnakModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahAnakModalLabel">Tambah Anak</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('anak.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                        <div class="row mb-3">
                            <label for="Nama" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="tempat_lahir" class="col-md-4 col-lg-3 col-form-label">Tempat, Tanggal Lahir</label>
                            <div class="col-md-4 col-lg-3">
                                <input name="tempat_lahir" type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <div class="input-group">
                                    <input name="tanggal_lahir_anak" type="text" class="form-control @error('tanggal_lahir_anak') is-invalid @enderror" id="tanggal_lahir_anak" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tanggal_lahir_anak') }}" required>
                                    <button class="btn btn-outline-secondary" type="button" for="tanggal_lahir_anak" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                    @error('tanggal_lahir_anak')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="status_keluarga" class="col-md-4 col-lg-3 col-form-label">Status Keluarga</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-select" aria-label="Default select example" name="status_keluarga" id="status_keluarga">
                                    <option selected disabled>-- Pilihan --</option>
                                    <option value="Anak Kandung" {{ old('status_keluarga')=='Anak Kandung' ? 'selected': '' }} >Anak Kandung</option>
                                    <option value="Anak Angkat" {{ old('status_keluarga')=='Anak Angkat' ? 'selected': '' }} >Anak Angkat</option>
                                    <option value="Anak Tiri" {{ old('status_keluarga')=='Anak Tiri' ? 'selected': '' }} >Anak Tiri</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="status_tunjangan" class="col-md-4 col-lg-3 col-form-label">Status Tunjangan</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-select" aria-label="Default select example" name="status_tunjangan" id="status_tunjangan">
                                    <option selected disabled>-- Pilihan --</option>
                                    <option value="Dapat" {{ old('status_tunjangan')=='Dapat' ? 'selected': '' }} >Dapat</option>
                                    <option value="Tidak Dapat" {{ old('status_tunjangan')=='Tidak Dapat' ? 'selected': '' }} >Tidak Dapat</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3 form-group">
                            <label class="col-md-4 col-lg-3 col-form-label">Jenis Kelamin</label>
                            <div class="col-md-8 col-lg-9 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="laki_laki" value="Laki-laki">
                                    <label class="form-check-label" for="laki_laki">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan">
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            <div class="text-center p-2">
                                <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Simpan</button>
                            </div>
                            <div class="text-center p-2">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Anak view -->