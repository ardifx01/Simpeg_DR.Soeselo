{{-- resources/views/surat/sertifikat/create.blade.php --}}
@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <h1 class="h2 fw-bold text-primary">Tambah Sertifikat</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sertifikat.index') }}">Sertifikat</a></li>
            <li class="breadcrumb-item active">Tambah Sertifikat</li>
        </ol>
    </nav>
</div>

<section class="row mt-4">
    <div class="col-12 col-lg-10 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0">Form Tambah Sertifikat</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('sertifikat.store') }}" method="POST">
                    @csrf

                    {{-- DETAIL SERTIFIKAT --}}
                    <h5 class="fw-bold mb-3">Detail Sertifikat</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nomor" class="form-label">Nomor Sertifikat</label>
                            <input type="text" name="nomor" id="nomor" class="form-control @error('nomor') is-invalid @enderror" value="{{ old('nomor') }}" required>
                            @error('nomor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="instansi" class="form-label">Instansi (opsional)</label>
                            <input type="text" name="instansi" id="instansi" class="form-control @error('instansi') is-invalid @enderror" value="{{ old('instansi') }}">
                            @error('instansi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- PENERIMA --}}
                    <h5 class="fw-bold mb-3">Penerima Sertifikat</h5>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="penerima_id" class="form-label">Nama Penerima</label>
                            <select name="penerima_id" id="penerima_id"
                                    class="form-select select2 @error('penerima_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('penerima_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap ?? $pegawai->nama }} (NIP: {{ $pegawai->nip }})</option>
                                @endforeach
                            </select>
                            @error('penerima_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- DETAIL KEGIATAN --}}
                    <h5 class="fw-bold mb-3">Detail Kegiatan</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control @error('nama_kegiatan') is-invalid @enderror" value="{{ old('nama_kegiatan') }}" required>
                            @error('nama_kegiatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="penyelenggara" class="form-label">Penyelenggara</label>
                            <input type="text" name="penyelenggara" id="penyelenggara" class="form-control @error('penyelenggara') is-invalid @enderror" value="{{ old('penyelenggara') }}" required>
                            @error('penyelenggara') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <div class="input-group">
                                <input type="text" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai') }}" placeholder="dd-mm-YYYY" autocomplete="off" required>
                                <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_mulai" for="tanggal_mulai">
                                    <i class="bi bi-calendar3"></i>
                                </button>
                            </div>
                            @error('tanggal_mulai') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <div class="input-group">
                                <input type="text" name="tanggal_selesai" id="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai') }}" placeholder="dd-mm-YYYY" autocomplete="off" required>
                                <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_selesai" for="tanggal_selesai">
                                    <i class="bi bi-calendar3"></i>
                                </button>
                            </div>
                            @error('tanggal_selesai') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" id="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi') }}" required>
                            @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- PENERBITAN --}}
                    <h5 class="fw-bold mb-3">Penerbitan Sertifikat</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="tempat_terbit" class="form-label">Tempat Terbit</label>
                            <input type="text" name="tempat_terbit" id="tempat_terbit" class="form-control @error('tempat_terbit') is-invalid @enderror" value="{{ old('tempat_terbit') }}" required>
                            @error('tempat_terbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                            <div class="input-group">
                                <input type="text" name="tanggal_terbit" id="tanggal_terbit" class="form-control @error('tanggal_terbit') is-invalid @enderror" value="{{ old('tanggal_terbit') }}" placeholder="dd-mm-YYYY" autocomplete="off" required>
                                <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_terbit" for="tanggal_terbit">
                                    <i class="bi bi-calendar3"></i>
                                </button>
                            </div>
                            @error('tanggal_terbit') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- PENANDATANGAN --}}
                    <h5 class="fw-bold mb-3">Penandatangan</h5>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="penandatangan_id" class="form-label">Nama Penandatangan</label>
                            <select name="penandatangan_id" id="penandatangan_id"
                                    class="form-select select2 @error('penandatangan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('penandatangan_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap ?? $pegawai->nama }} - {{ $pegawai->nip }}</option>
                                @endforeach
                            </select>
                            @error('penandatangan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Sertifikat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection