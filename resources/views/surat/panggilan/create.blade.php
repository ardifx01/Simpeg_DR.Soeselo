@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <h1 class="h2 fw-bold text-primary">Tambah Surat Panggilan</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
            <li class="breadcrumb-item"><a href="{{ route('panggilan.index') }}">Surat Panggilan</a></li>
            <li class="breadcrumb-item active">Tambah Surat Panggilan</li>
        </ol>
    </nav>
</div>

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form Pengajuan Penggilan</h4>
                </div>
                <div class="card-body p-4">
                <form action="{{ route('panggilan.store') }}" method="POST" class="card shadow-sm p-4">
                    @csrf

                    <h5 class="fw-bold mb-3">Detail Surat</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nomor_surat" class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat') }}" placeholder="Contoh: 800/123/IV" required>
                            @error('nomor_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="sifat" class="form-label">Sifat</label>
                            <select class="form-select" id="sifat" name="sifat" required>
                                <option value="Biasa" {{ old('sifat') == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                                <option value="Penting" {{ old('sifat') == 'Penting' ? 'selected' : '' }}>Penting</option>
                                <option value="Segera" {{ old('sifat') == 'Segera' ? 'selected' : '' }}>Segera</option>
                                <option value="Rahasia" {{ old('sifat') == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                            </select>
                            @error('sifat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="lampiran" class="form-label">Lampiran</label>
                            <input type="text" class="form-control" id="lampiran" name="lampiran" value="{{ old('lampiran') }}">
                            @error('lampiran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('tanggal_surat') is-invalid @enderror" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat') }}" autocomplete="off" required>
                                <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_surat" for="tanggal_surat">
                                    <i class="bi bi-calendar3"></i>
                                </button>
                            </div>    
                            @error('tanggal_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <label for="perihal" class="form-label">Perihal</label>
                            <textarea class="form-control" id="perihal" name="perihal" rows="2" required>{{ old('perihal') }}</textarea>
                        </div>
                        @error('perihal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold mb-3">Detail Pegawai</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="pegawai_id" class="form-label">Pegawai Dipanggil</label>
                            <select name="pegawai_id" id="pegawai_id" class="form-select" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }} - {{ $pegawai->nip ?? '' }}</option>
                                @endforeach
                            </select>
                            @error('pegawai_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="penandatangan_id" class="form-label">Penandatangan</label>
                            <select name="penandatangan_id" id="penandatangan_id" class="form-select" required>
                                <option value="">-- Pilih Penandatangan --</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('penandatangan_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }} - {{ $pegawai->nip ?? '' }}</option>
                                @endforeach
                            </select>
                            @error('penandatangan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold mb-3">Detail Jadwal</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="jadwal_hari" class="form-label">Hari</label>
                            <input type="text" class="form-control" id="jadwal_hari" name="jadwal_hari" value="{{ old('jadwal_hari') }}" required>
                            @error('jadwal_hari')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="jadwal_tanggal" class="form-label">Tanggal</label>
                            <div class="input-group">
                            <input type="text" class="form-control @error('jadwal_tanggal') is-invalid @enderror" id="jadwal_tanggal" name="jadwal_tanggal" value="{{ old('jadwal_tanggal') }}" autocomplete="off" required>
                                <button class="btn btn-outline-secondary" type="button" id="btn_jadwal_tanggal" for="jadwal_tanggal">
                                    <i class="bi bi-calendar3"></i>
                                </button>
                            </div>
                            @error('jadwal_tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="jadwal_pukul" class="form-label">Pukul</label>
                            <input type="text" class="form-control" id="jadwal_pukul" name="jadwal_pukul" placeholder="contoh: 09:00 WIB" value="{{ old('jadwal_pukul') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="jadwal_tempat" class="form-label">Tempat</label>
                            <input type="text" class="form-control" id="jadwal_tempat" name="jadwal_tempat" value="{{ old('jadwal_tempat') }}" required>
                            @error('jadwal_tempat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="menghadap_kepada" class="form-label">Menghadap Kepada</label>
                            <input type="text" class="form-control" id="menghadap_kepada" name="menghadap_kepada" value="{{ old('menghadap_kepada') }}" required>
                            @error('menghadap_kepada')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="alamat_menghadap" class="form-label">Alamat Menghadap</label>
                            <textarea class="form-control" id="alamat_menghadap" name="alamat_menghadap" rows="2" required>{{ old('alamat_menghadap') }}</textarea>
                            @error('alamat_menghadap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tembusan" class="form-label">Tembusan (Opsional)</label>
                            <textarea class="form-control @error('tembusan') is-invalid @enderror" id="tembusan" name="tembusan" rows="3">{{ old('tembusan') }}</textarea>
                            <small class="form-text text-muted">Pisahkan setiap tembusan dengan koma (contoh: Direktur RSUD, Arsip).</small>
                            @error('tembusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Surat Panggilan
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection