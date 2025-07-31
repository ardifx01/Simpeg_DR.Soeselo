<!-- Diklat view -->
<div class="view">
    <!-- Diklat Fungsional -->
    <div class="title d-flex justify-content-between align-items-center">
        <small><i class="bi bi-caret-right-fill"></i> Diklat Fungsional</small>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahDiklatFungsional">
            <i class="bi bi-plus"></i> Tambah Diklat
        </button>
    </div>
    <div class="table-responsive small">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr class="text-center align-middle">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Penyelenggara</th>
                    <th>Jumlah Jam</th>
                    <th>Tanggal Selesai</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $diklatFungsionals = isset($pegawai) && $pegawai ? $pegawai->diklat_fungsionals : [];
                @endphp
                @forelse ($diklatFungsionals as $key => $diklatfungsional)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $diklatfungsional->nama }}</td>
                    <td>{{ $diklatfungsional->penyelenggara }}</td>
                    <td>{{ $diklatfungsional->jumlah_jam }}</td>
                    <td>{{ $diklatfungsional->tanggal_selesai }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('diklatfungsional.edit', $diklatfungsional->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusdiklatfungsionalModal{{ $diklatfungsional->id }}">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                        <!-- Modal Konfirmasi Hapus -->
                        <div class="modal fade" id="hapusdiklatfungsionalModal{{ $diklatfungsional->id }}" tabindex="-1" aria-labelledby="hapusdiklatfungsionalModalLabel{{ $diklatfungsional->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusdiklatfungsionalModalLabel{{ $diklatfungsional->id }}">Konfirmasi Hapus</h5>
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
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Modal Tambah Diklat Fungsional -->
    <div class="modal fade" id="modalTambahDiklatFungsional" tabindex="-1" aria-labelledby="modalTambahDiklatFungsionalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDiklatFungsionalLabel">Tambah Diklat Fungsional</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('diklatfungsional.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_fungsional" class="form-label">Nama Diklat</label>
                            <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama_fungsional" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="penyelenggara_fungsional" class="form-label">Penyelenggara</label>
                            <input name="penyelenggara" type="text" class="form-control @error('penyelenggara') is-invalid @enderror" id="penyelenggara_fungsional" value="{{ old('penyelenggara') }}" required>
                            @error('penyelenggara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_jam_fungsional" class="form-label">Jumlah Jam</label>
                            <input name="jumlah_jam" type="text" class="form-control @error('jumlah_jam') is-invalid @enderror" id="jumlah_jam_fungsional" value="{{ old('jumlah_jam') }}" required>
                            @error('jumlah_jam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai_fungsional" class="form-label">Tanggal Selesai</label>
                            <div class="input-group">
                                <input name="tanggal_selesai" type="text" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai_fungsional" value="{{ old('tanggal_selesai') }}">
                                <button class="btn btn-outline-secondary" type="button" for="tanggal_selesai_fungsional"><i class="bi bi-calendar3"></i></button>
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-2"><i class="bi bi-floppy"></i> Simpan</button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-90deg-left"></i> Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Diklat Jabatan -->
    <div class="title d-flex justify-content-between align-items-center mt-4">
        <small><i class="bi bi-caret-right-fill"></i> Diklat Jabatan</small>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahDiklatJabatan">
            <i class="bi bi-plus"></i> Tambah Diklat
        </button>
    </div>
    <div class="table-responsive small">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr class="text-center align-middle">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Penyelenggara</th>
                    <th>Jumlah Jam</th>
                    <th>Tanggal Selesai</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $diklatJabatans = isset($pegawai) && $pegawai ? $pegawai->diklat_jabatans : [];
                @endphp
                @forelse ($diklatJabatans as $key => $diklatjabatan)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $diklatjabatan->nama }}</td>
                    <td>{{ $diklatjabatan->penyelenggara }}</td>
                    <td>{{ $diklatjabatan->jumlah_jam }}</td>
                    <td>{{ $diklatjabatan->tanggal_selesai }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('diklatjabatan.edit', $diklatjabatan->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusdiklatjabatanModal{{ $diklatjabatan->id }}">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                        <!-- Modal Konfirmasi Hapus -->
                        <div class="modal fade" id="hapusdiklatjabatanModal{{ $diklatjabatan->id }}" tabindex="-1" aria-labelledby="hapusdiklatjabatanModalLabel{{ $diklatjabatan->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusdiklatjabatanModalLabel{{ $diklatjabatan->id }}">Konfirmasi Hapus</h5>
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
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Modal Tambah Diklat Jabatan -->
    <div class="modal fade" id="modalTambahDiklatJabatan" tabindex="-1" aria-labelledby="modalTambahDiklatJabatanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDiklatJabatanLabel">Tambah Diklat Jabatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('diklatjabatan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_jabatan" class="form-label">Nama Diklat</label>
                            <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama_jabatan" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="penyelenggara_jabatan" class="form-label">Penyelenggara</label>
                            <input name="penyelenggara" type="text" class="form-control @error('penyelenggara') is-invalid @enderror" id="penyelenggara_jabatan" value="{{ old('penyelenggara') }}" required>
                            @error('penyelenggara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_jam_jabatan" class="form-label">Jumlah Jam</label>
                            <input name="jumlah_jam" type="text" class="form-control @error('jumlah_jam') is-invalid @enderror" id="jumlah_jam_jabatan" value="{{ old('jumlah_jam') }}" required>
                            @error('jumlah_jam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai_jabatan" class="form-label">Tanggal Selesai</label>
                            <div class="input-group">
                                <input name="tanggal_selesai" type="text" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai_jabatan" value="{{ old('tanggal_selesai') }}">
                                <button class="btn btn-outline-secondary" type="button" for="tanggal_selesai_jabatan"><i class="bi bi-calendar3"></i></button>
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-2"><i class="bi bi-floppy"></i> Simpan</button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-90deg-left"></i> Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Diklat Teknis -->
    <div class="title d-flex justify-content-between align-items-center mt-4">
        <small><i class="bi bi-caret-right-fill"></i> Diklat Teknis</small>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahDiklatTeknis">
            <i class="bi bi-plus"></i> Tambah Diklat
        </button>
    </div>
    <div class="table-responsive small">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr class="text-center align-middle">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Penyelenggara</th>
                    <th>Jumlah Jam</th>
                    <th>Tanggal Selesai</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $diklatTekniks = isset($pegawai) && $pegawai ? $pegawai->diklat_tekniks : [];
                @endphp
                @forelse ($diklatTekniks as $key => $diklatteknik)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $diklatteknik->nama }}</td>
                    <td>{{ $diklatteknik->penyelenggara }}</td>
                    <td>{{ $diklatteknik->jumlah_jam }}</td>
                    <td>{{ $diklatteknik->tanggal_selesai }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('diklatteknik.edit', $diklatteknik->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusdiklatteknikModal{{ $diklatteknik->id }}">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                        <!-- Modal Konfirmasi Hapus -->
                        <div class="modal fade" id="hapusdiklatteknikModal{{ $diklatteknik->id }}" tabindex="-1" aria-labelledby="hapusdiklatteknikModalLabel{{ $diklatteknik->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusdiklatteknikModalLabel{{ $diklatteknik->id }}">Konfirmasi Hapus</h5>
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
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Modal Tambah Diklat Teknis -->
    <div class="modal fade" id="modalTambahDiklatTeknis" tabindex="-1" aria-labelledby="modalTambahDiklatTeknisLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDiklatTeknisLabel">Tambah Diklat Teknis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('diklatteknik.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_teknis" class="form-label">Nama Diklat</label>
                            <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama_teknis" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="penyelenggara_teknis" class="form-label">Penyelenggara</label>
                            <input name="penyelenggara" type="text" class="form-control @error('penyelenggara') is-invalid @enderror" id="penyelenggara_teknis" value="{{ old('penyelenggara') }}" required>
                            @error('penyelenggara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_jam_teknis" class="form-label">Jumlah Jam</label>
                            <input name="jumlah_jam" type="text" class="form-control @error('jumlah_jam') is-invalid @enderror" id="jumlah_jam_teknis" value="{{ old('jumlah_jam') }}" required>
                            @error('jumlah_jam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai_teknis" class="form-label">Tanggal Selesai</label>
                            <div class="input-group">
                                <input name="tanggal_selesai" type="text" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai_teknis" value="{{ old('tanggal_selesai') }}">
                                <button class="btn btn-outline-secondary" type="button" for="tanggal_selesai_teknis"><i class="bi bi-calendar3"></i></button>
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-2"><i class="bi bi-floppy"></i> Simpan</button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-90deg-left"></i> Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Diklat view -->