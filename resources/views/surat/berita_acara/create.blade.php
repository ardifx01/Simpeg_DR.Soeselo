@extends('surat.layouts.main')

@section('main')

<div class="pagetitle">
    <div class="row justify-content-between">
        <div class="col">
            <h1>Tambah Berita Acara</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('berita_acara.index') }}">Daftar Berita Acara</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Berita Acara</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Pengajuan Surat Berita Acara Title -->

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form Tambah Berita Acara</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('berita_acara.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="nomor" class="form-label">Nomor Berita Acara</label>
                            <input type="text" name="nomor" id="nomor" class="form-control @error('nomor') is-invalid @enderror" value="{{ old('nomor') }}" placeholder="Contoh: 800/123/IV" required>
                            @error('nomor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="hari" class="form-label">Hari</label>
                                    <input type="text" name="hari" id="hari" class="form-control @error('hari') is-invalid @enderror" value="{{ old('hari') }}" required>
                                    @error('hari')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="tanggal_acara" class="form-label">Tanggal Acara</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal_acara" name="tanggal" value="{{ old('tanggal') }}" required>
                                        <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_acara" for="tanggal_acara">
                                            <i class="bi bi-calendar3"></i>
                                        </button>
                                    </div>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="pihak_pertama_id" class="form-label">Pihak Pertama</label>
                            <select name="pihak_pertama_id" id="pihak_pertama_id" class="form-select @error('pihak_pertama_id') is-invalid @enderror" required>
                                <option value="">Pilih Pihak Pertama</option>
                                @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}" {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            @error('pihak_pertama_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pihak_kedua_id" class="form-label">Pihak Kedua</label>
                            <select name="pihak_kedua_id" id="pihak_kedua_id" class="form-select @error('pihak_kedua_id') is-invalid @enderror">
                                <option value="">Pilih Pihak Kedua</option>
                                @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}" {{ old('pihak_kedua_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            @error('pihak_kedua_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="atasan_id" class="form-label">Atasan</label>
                            <select name="atasan_id" id="atasan_id" class="form-select @error('atasan_id') is-invalid @enderror" required>
                                <option value="">Pilih Atasan</option>
                                @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}" {{ old('atasan_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            @error('atasan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan Berita Acara</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection