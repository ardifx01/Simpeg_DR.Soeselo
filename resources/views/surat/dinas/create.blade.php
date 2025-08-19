@extends('surat.layouts.main')

@section('main')

<div class="pagetitle"> 
    <div class="row justify-content-between">
        <div class="col">
            <h1>Tambah Surat Dinas</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dinas.index') }}">Daftar Surat Dinas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Surat Dinas</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Pengajuan Surat Dinas Title -->

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form Tambah Surat Dinas</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('dinas.store') }}">
                        @csrf
                        <div class="mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nomor" class="form-label">Nomor Surat</label>
                                    <input type="text" name="nomor" id="nomor" class="form-control @error('nomor') is-invalid @enderror" value="{{ old('nomor') }}" placeholder="Contoh: 800/123/IV" required>
                                    @error('nomor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="sifat" class="form-label">Sifat Surat</label>
                                    <input type="text" name="sifat" id="sifat" class="form-control @error('sifat') is-invalid @enderror" value="{{ old('sifat') }}" required>
                                    @error('sifat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="lampiran" class="form-label">Lampiran Surat</label>
                                    <input type="text" name="lampiran" id="lampiran" class="form-control @error('lampiran') is-invalid @enderror" value="{{ old('lampiran') }}" required>
                                    @error('lampiran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="hal" class="form-label">Hal Surat</label>
                                    <input type="text" name="hal" id="hal" class="form-control @error('hal') is-invalid @enderror" value="{{ old('hal') }}" required>
                                    @error('hal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="tempat" class="form-label">Tempat Dinas</label>
                                    <input type="text" name="tempat" id="tempat" class="form-control @error('tempat') is-invalid @enderror" value="{{ old('tempat') }}" required>
                                    @error('tempat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('tanggal_surat') is-invalid @enderror" id="tanggal_dinas" name="tanggal_surat" value="{{ old('tanggal_surat') }}" autocomplete="off" required>
                                        <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_dinas" for="tanggal_dinas">
                                            <i class="bi bi-calendar3"></i>
                                        </button>
                                    </div>
                                    @error('tanggal_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="row g-3">
                                <div class="mb-3">
                                    <label for="kepada_yth" class="form-label">Kepada Yth</label>
                                    <input type="text" class="form-control" id="kepada_yth" name="kepada_yth" value="{{ old('kepada_yth') }}">
                                    @error('kepada_yth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                <label for="alamat_tujuan" class="form-label">Alamat Tujuan</label>
                                <textarea class="form-control" id="alamat_tujuan" name="alamat_tujuan" rows="3">{{ old('alamat_tujuan') }}</textarea>
                                @error('alamat_tujuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="penandatangan_id" class="form-label">Penandatangan</label>
                            <select name="penandatangan_id" id="penandatangan_id" class="form-select @error('penandatangan_id') is-invalid @enderror" required>
                                <option value="">Pilih Penandatangan</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('penandatangan_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama }}</option>
                                @endforeach
                            </select>
                            @error('penandatangan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tembusan" class="form-label">Tembusan</label>
                            <textarea class="form-control" id="tembusan" name="tembusan" rows="3">{{ old('tembusan') }}</textarea>
                            <small class="form-text text-muted">Pisahkan setiap tembusan dengan koma (contoh: Direktur RSUD, Arsip).</small>
                            @error('tembusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan Surat Dinas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection