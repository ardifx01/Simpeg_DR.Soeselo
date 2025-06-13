@extends('dashboard.layouts.main')

@section('main')
<div class="pagetitle">
    <div class="row justify-content-between align-items-center">
        <div class="col-auto">
            <h1>Data OPD / SKPD / Unit Kerja</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data OPD / SKPD / Unit Kerja</li>
                </ol>
            </nav>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addopdModal">
                <i class="bi bi-plus-circle me-1"></i>Tambah Data Unit Kerja
            </button>
        </div>
    </div>
</div><!-- End Page Title -->

<!-- Add Modal -->
<div class="modal fade" id="addopdModal" tabindex="-1" aria-labelledby="addopdModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('opd.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data OPD / SKPD / Unit Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="nama_opd" class="col-md-4 col-lg-3 col-form-label">Nama OPD / SKPD / Unit Kerja</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="nama_opd" type="text" class="form-control @error('nama_opd') is-invalid @enderror" id="nama_opd" value="{{ old('nama_opd') }}" required>
                            @error('nama_opd')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                        <div class="col-md-8 col-lg-9">
                            <textarea name="alamat" class="form-control" id="alamat" style="height: 100px" required>{{ old('alamat') }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="pegawai_id" class="col-md-4 col-lg-3 col-form-label">Pimpinan</label>
                        <div class="col-md-8 col-lg-9">
                            <select name="pegawai_id" class="form-control select2" required>
                                <option selected disabled>-- Pilih Pimpinan --</option>
                                @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<section class="section dashboard">
    <div class="row">
        <!-- OPD view -->
        <div class="view">
            <div class="d-flex justify-content-between row">
                <div class="col-sm-2 col-md-8 col-lg-6">
                    <div class="row mb-3 form-group">
                        <form method="GET" action="{{ route('opd.index') }}" class="d-flex align-items-center">
                            <label for="per_page" class="me-2">Show:</label>
                            <select name="per_page" class="form-select w-auto me-3" onchange="this.form.submit()">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <label for="per_page" class="me-2">Entries</label>
                        </form>
                    </div>
                </div>
                <div class="col-sm-2 col-md-3 col-lg-2">
                    <form action="{{ route('opd.index') }}" method="GET">
                        <div class="row mb-3 form-group">
                            <label type="text" id="search" name="search" for="search" class="col-sm-1 col-md-3 col-lg-3 col-form-label">search: </label>
                            <div class="col-sm-1 col-md-8 col-lg-9">
                                <input type="search" class="form-control" name="search" id="search" value="{{ request('search') }}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama OPD / SKPD / Unit Kerja </th>
                            <th>Pimpinan / Alamat</th>
                            <th width="15%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($opds as $key => $opd)
                        <tr>
                            <td>{{ $opds->firstItem() + $key }}</td>
                            <td>{{ $opd->nama_opd }}</td>
                            <td>
                                @if($opd->pegawai)
                                    {{ $opd->pegawai->gelar_depan }} {{ $opd->pegawai->nama }}, {{ $opd->pegawai->gelar_belakang }} <br> {{ $opd->alamat }}
                                @else
                                    <span class="text-muted">Belum ditentukan</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $opd->id }}"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusopdModal{{ $opd->id }}"><i class="bi bi-x-circle"></i></button>
                            </td>
                        </tr>
                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $opd->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <form action="{{ route('opd.update', $opd->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Data OPD / SKPD / Unit Kerja</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <label for="nama_opd" class="col-md-4 col-lg-3 col-form-label">Nama OPD / SKPD / Unit Kerja</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="nama_opd" type="text" class="form-control @error('nama_opd') is-invalid @enderror" id="nama_opd" value="{{ old('nama_opd')  ?? $opd->nama_opd }}" required>
                                                    @error('nama_opd')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <textarea name="alamat" class="form-control" id="alamat" style="height: 100px" required>{{ old('alamat')  ?? $opd->alamat }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="pegawai_id" class="col-md-4 col-lg-3 col-form-label">Pimpinan</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <select name="pegawai_id" class="form-control select2" required>
                                                        <option selected disabled>-- Pilih Pimpinan --</option>
                                                        @foreach($pegawais as $pegawai)
                                                            <option value="{{ $pegawai->id }}" {{ isset($opd) && $opd->pegawai_id == $pegawai->id ? 'selected' : '' }}>
                                                                {{ $pegawai->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="hapusopdModal{{ $opd->id }}" tabindex="-1" aria-labelledby="hapusopdModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusopdModalLabel">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus <strong>{{ $opd->nama_opd }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('opd.destroy', $opd->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $opds->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</section>
@endsection