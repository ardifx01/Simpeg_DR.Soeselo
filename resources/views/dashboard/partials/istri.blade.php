<!-- Istri view -->
<div class="view">
    <!-- Tombol Tambah Istri -->
    <div class="mb-3 d-flex justify-content-end">
        @if($pegawai->status_nikah !== 'Belum')
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahIstriModal">
                <i class="bi bi-plus"></i> Tambah Suami/Istri
            </button>
        @else
            <div class="alert alert-warning py-1 px-2 mb-2 fs-7 mt-2">
                Pegawai belum menikah. Data Suami/Istri tidak bisa diisi.
            </div>
        @endif

    </div>
    <div class="table-responsive small">
        <table class="table table-bordered table-striped table-hover align-middle text-center">
            <thead>
                <tr class="text-center align-middle">
                    <th style="width: 50px;">No</th>
                    <th>Nama Suami/Istri</th>
                    <th>Tempat<br>Tanggal Lahir</th>
                    <th>Profesi</th>
                    <th>Status</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($pegawai->istris->count() == 0)
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data</td>
                    </tr>
                @else
                    @foreach($pegawai->istris as $key => $istri)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $istri->nama }}</td>
                        <td>{{ $istri->tempat_lahir }}, {{ \Carbon\Carbon::parse($istri->tanggal_lahir_istri)->translatedFormat('d F Y') }}</td>
                        <td>{{ $istri->profesi }}</td>
                        <td>{{ $istri->status_hubungan }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editIstriModal{{ $istri->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusIstriModal{{ $istri->id }}">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                            <!-- Modal Edit Istri -->
                            <div class="modal fade" id="editIstriModal{{ $istri->id }}" tabindex="-1" aria-labelledby="editIstriModalLabel{{ $istri->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editIstriModalLabel{{ $istri->id }}">Edit Istri</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('istri.update', $istri->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="pegawai_id" value="{{ $istri->pegawai_id }}">

                                                <!-- Nama -->
                                                <div class="row mb-3">
                                                    <label for="nama_{{ $istri->id }}" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="nama" type="text" class="form-control" id="nama_{{ $istri->id }}" value="{{ old('nama', $istri->nama) }}" required>
                                                    </div>
                                                </div>

                                                <!-- Tempat, Tanggal Lahir -->
                                                <div class="row mb-3">
                                                    <label for="tempat_lahir_{{ $istri->id }}" class="col-md-4 col-lg-3 col-form-label">Tempat, Tanggal Lahir</label>
                                                    <div class="col-md-4 col-lg-3">
                                                        <input name="tempat_lahir" type="text" class="form-control" id="tempat_lahir_{{ $istri->id }}" value="{{ old('tempat_lahir', $istri->tempat_lahir) }}" required>
                                                    </div>
                                                    <div class="col-md-4 col-lg-3">
                                                        <div class="input-group">
                                                            <input name="tanggal_lahir_istri" type="text" class="form-control" id="tanggal_lahir_istri_edit_{{ $istri->id }}" value="{{ old('tanggal_lahir_istri', \Carbon\Carbon::parse($istri->tanggal_lahir_istri)->format('d-m-Y')) }}" required>
                                                            <button class="btn btn-outline-secondary" type="button" for="tanggal_lahir_istri_edit_{{ $istri->id }}"><i class="bi bi-calendar3"></i></button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Profesi -->
                                                <div class="row mb-3">
                                                    <label for="profesi_{{ $istri->id }}" class="col-md-4 col-lg-3 col-form-label">Profesi</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="profesi" type="text" class="form-control" id="profesi_{{ $istri->id }}" value="{{ old('profesi', $istri->profesi) }}" required>
                                                    </div>
                                                </div>

                                                <!-- Tanggal Nikah -->
                                                <div class="row mb-3">
                                                    <label for="tanggal_nikah_edit_{{ $istri->id }}" class="col-md-4 col-lg-3 col-form-label">Tanggal Nikah</label>
                                                    <div class="col-md-4 col-lg-3">
                                                        <div class="input-group">
                                                            <input name="tanggal_nikah" type="text" class="form-control" id="tanggal_nikah_edit_{{ $istri->id }}" value="{{ old('tanggal_nikah', \Carbon\Carbon::parse($istri->tanggal_nikah)->format('d-m-Y')) }}" required>
                                                            <button class="btn btn-outline-secondary" type="button" for="tanggal_nikah_edit_{{ $istri->id }}"><i class="bi bi-calendar3"></i></button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Status Hubungan -->
                                                <div class="row mb-3">
                                                    <label for="status_hubungan_{{ $istri->id }}" class="col-md-4 col-lg-3 col-form-label">Status Hubungan</label>
                                                    <div class="col-md-4 col-lg-3">
                                                        <select class="form-select" name="status_hubungan" id="status_hubungan_{{ $istri->id }}" required>
                                                            <option disabled>-- Pilihan --</option>
                                                            <option value="Suami" {{ old('status_hubungan', $istri->status_hubungan) == 'Suami' ? 'selected' : '' }}>Suami</option>
                                                            <option value="Istri" {{ old('status_hubungan', $istri->status_hubungan) == 'Istri' ? 'selected' : '' }}>Istri</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Tombol Aksi -->
                                                <div class="d-flex justify-content-center">
                                                    <div class="text-center p-2">
                                                        <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Update</button>
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
                            <div class="modal fade" id="hapusIstriModal{{ $istri->id }}" tabindex="-1" aria-labelledby="hapusIstriModalLabel{{ $istri->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="hapusIstriModalLabel{{ $istri->id }}">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus <strong>{{ $istri->nama }}</strong>?
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
                @endif
            </tbody>
        </table>
    </div>
    <!-- Modal Tambah Istri -->
    <div class="modal fade" id="tambahIstriModal" tabindex="-1" aria-labelledby="tambahIstriModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahIstriModalLabel">Tambah Istri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('istri.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id ?? '' }}">
                    <div class="row mb-3">
                        <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama</label>
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
                                <input name="tanggal_lahir_istri" type="text" class="form-control @error('tanggal_lahir_istri') is-invalid @enderror" id="tanggal_lahir_istri" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tanggal_lahir_istri') }}" required>
                                <button class="btn btn-outline-secondary" type="button" for="tanggal_lahir_istri" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                @error('tanggal_lahir_istri')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="profesi" class="col-md-4 col-lg-3 col-form-label">Profesi</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="profesi" type="text" class="form-control" id="profesi" value="{{ old('profesi') }}" required>
                            @error('profesi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="tanggal_nikah" class="col-md-4 col-lg-3 col-form-label">Tanggal Nikah</label>
                        <div class="col-md-4 col-lg-3">
                            <div class="input-group">
                                <input name="tanggal_nikah" type="text" class="form-control @error('tanggal_nikah') is-invalid @enderror" id="tanggal_nikah" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tanggal_nikah') }}" required>
                                <button class="btn btn-outline-secondary" type="button" for="tanggal_nikah" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                @error('tanggal_nikah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="status_hubungan" class="col-md-4 col-lg-3 col-form-label">Status Hubungan</label>
                        <div class="col-md-4 col-lg-3">
                            <select class="form-select" aria-label="Default select example" name="status_hubungan" id="status_hubungan" required>
                                <option selected disabled>-- Pilihan --</option>
                                <option value="Suami" {{ old('status_hubungan')=='Suami' ? 'selected': '' }} >Suami</option>
                                <option value="Istri" {{ old('status_hubungan')=='Istri' ? 'selected': '' }} >Istri</option>
                            </select>
                            @error('status_hubungan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
</div><!-- End Istri view -->