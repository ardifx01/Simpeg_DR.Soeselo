@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <h1 class="h2 fw-bold text-primary">Tambah Surat Pemberian Izin</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pemberian_izin.index') }}">Surat Pemberian Izin</a></li>
            <li class="breadcrumb-item active">Tambah Surat Pemberian Izin</li>
        </ol>
    </nav>
</div>

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form Pengajuan Pemberian Izin</h4>
                </div>
                <div class="card-body p-4">
                <form action="{{ route('pemberian_izin.store') }}" method="POST" class="card shadow-sm p-4">
                    @csrf

                    {{-- DETAIL SURAT --}}
                    <h5 class="fw-bold mb-3">Detail Surat</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nomor_surat" class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat') }}" placeholder="Contoh: 800/123/IV" required>
                            @error('nomor_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="ditetapkan_di" class="form-label">Ditetapkan di</label>
                            <input type="text" class="form-control @error('ditetapkan_di') is-invalid @enderror" id="ditetapkan_di" name="ditetapkan_di" value="{{ old('ditetapkan_di') }}" required>
                            @error('ditetapkan_di')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="tanggal_penetapan" class="form-label">Tanggal Penetapan</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('tanggal_penetapan') is-invalid @enderror" id="tanggal_penetapan" name="tanggal_penetapan" value="{{ old('tanggal_penetapan') }}" autocomplete="off" placeholder="dd-mm-yyyy" required>
                                <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_penetapan" for="tanggal_penetapan">
                                    <i class="bi bi-calendar3"></i>
                                </button>
                                @error('tanggal_penetapan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="tentang" class="form-label">Tentang</label>
                            <input type="text" class="form-control @error('tentang') is-invalid @enderror" id="tentang" name="tentang" value="{{ old('tentang') }}" required>
                            @error('tentang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="dasar_hukum" class="form-label">Dasar Hukum (opsional)</label>
                            <textarea class="form-control @error('dasar_hukum') is-invalid @enderror" id="dasar_hukum" name="dasar_hukum" rows="3" placeholder="Bisa diisi beberapa poin, pisahkan baris">{{ old('dasar_hukum') }}</textarea>
                            @error('dasar_hukum')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="tujuan_izin" class="form-label">Tujuan / Untuk</label>
                            <textarea class="form-control @error('tujuan_izin') is-invalid @enderror" id="tujuan_izin" name="tujuan_izin" rows="3" required>{{ old('tujuan_izin') }}</textarea>
                            @error('tujuan_izin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- DETAIL PEGAWAI --}}
                    <h5 class="fw-bold mb-3">Detail Pegawai</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="pegawai_id" class="form-label">Pegawai</label>
                            <select name="pegawai_id" id="pegawai_id" class="form-select @error('pegawai_id') is-invalid @enderror" required>
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
                            <label for="pemberi_izin_id" class="form-label">Pemberi Izin</label>
                            <select name="pemberi_izin_id" id="pemberi_izin_id" class="form-select @error('pemberi_izin_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pemberi Izin --</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('pemberi_izin_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }} - {{ $pegawai->nip ?? '' }}</option>
                                @endforeach
                            </select>
                            @error('pemberi_izin_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- TEMBUSAN --}}
                    <div class="mb-3">
                        <label for="tembusan" class="form-label">Tembusan (Opsional)</label>
                        <textarea class="form-control @error('tembusan') is-invalid @enderror" id="tembusan" name="tembusan" rows="3">{{ old('tembusan') }}</textarea>
                        <small class="form-text text-muted">Pisahkan setiap tembusan dengan koma (contoh: Direktur RSUD, Arsip).</small>
                        @error('tembusan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Surat Izin
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection