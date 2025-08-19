@extends('surat.layouts.main')

@section('main')

<div class="pagetitle"> 
    <div class="row justify-content-between">
        <div class="col">
            <h1>Pengajuan Surat Keterangan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('keterangan.index') }}">Daftar Surat Keterangan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengajuan Surat Keterangan</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Tambah Keterangan Title -->

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form pengajuan Surat Keterangan</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('keterangan.store') }}">
                        @csrf
                        <div class="mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nomor" class="form-label">Nomor Surat</label>
                                    <input type="text" class="form-control @error('nomor') is-invalid @enderror" id="nomor" name="nomor" placeholder="Contoh: 800/123/IV" value="{{ old('nomor') }}" required>
                                    @error('nomor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="pegawai_id" class="form-label">Pegawai yang Diterangkan</label>
                                    <select class="form-select @error('pegawai_id') is-invalid @enderror" id="pegawai_id" name="pegawai_id" required>
                                        <option value="" disabled selected>-- Pilih Pegawai --</option>
                                        @foreach ($pegawais as $pegawai)
                                            <option value="{{ $pegawai->id }}" {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
                                                {{ $pegawai->nama }} - (NIP: {{ $pegawai->nip ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pegawai_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Isi Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="8"required>{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="tanggal_ditetapkan" class="form-label">Tanggal Ditetapkan</label>
                                    <div class="input-group">
                                        <input type="text" name="tanggal_ditetapkan" id="tanggal_ditetapkan" class="form-control @error('tanggal_ditetapkan') is-invalid @enderror" value="{{ old('tanggal_ditetapkan', \Carbon\Carbon::now()->format('d-m-Y')) }}" placeholder="dd-mm-yyyy" required>
                                        <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_ditetapkan" for="tanggal_ditetapkan">
                                            <i class="bi bi-calendar3"></i>
                                        </button>
                                    </div>
                                    @error('tanggal_ditetapkan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="penandatangan_id" class="form-label">Penandatangan</label>
                                    <select class="form-select @error('penandatangan_id') is-invalid @enderror" id="penandatangan_id" name="penandatangan_id" required>
                                        <option value="" disabled selected>-- Pilih Penandatangan --</option>
                                        @foreach ($pegawais as $pegawai)
                                            <option value="{{ $pegawai->id }}" {{ old('penandatangan_id') == $pegawai->id ? 'selected' : '' }}>
                                                {{ $pegawai->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('penandatangan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tembusan" class="form-label">Tembusan (Opsional)</label>
                            <textarea class="form-control @error('tembusan') is-invalid @enderror" id="tembusan" name="tembusan" rows="3">{{ old('tembusan') }}</textarea>
                            <small class="form-text text-muted">Pisahkan setiap tembusan dengan koma (contoh: Direktur RSUD, Arsip).</small>
                            @error('tembusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan Keterangan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
