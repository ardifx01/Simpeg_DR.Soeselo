@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <h1 class="h2 fw-bold text-primary">Tambah Surat Pernyataan</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pernyataan.index') }}">Surat Pernyataan</a></li>
            <li class="breadcrumb-item active">Tambah Surat Pernyataan</li>
        </ol>
    </nav>
</div>

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form Pengajuan Pernyataan</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('pernyataan.store') }}" method="POST">
                        @csrf

                        {{-- DETAIL SURAT --}}
                        <h5 class="fw-bold mb-3">Detail Surat</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="nomor_surat" class="form-label">Nomor Surat</label>
                                <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat" name="nomor_surat" placeholder="Contoh: 800/ND/123/IV" value="{{ old('nomor_surat') }}" required>
                                @error('nomor_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                                <div class="input-group">
                                    <input type="text" id="tanggal_surat" name="tanggal_surat" class="form-control @error('tanggal_surat') is-invalid @enderror" value="{{ old('tanggal_surat') }}" placeholder="dd-mm-YYYY" autocomplete="off" required>
                                    <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_surat" for="tanggal_surat">
                                        <i class="bi bi-calendar3"></i>
                                    </button>
                                </div>
                                @error('tanggal_surat') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="tempat_surat" class="form-label">Tempat Surat</label>
                                <input type="text" id="tempat_surat" name="tempat_surat" class="form-control @error('tempat_surat') is-invalid @enderror"value="{{ old('tempat_surat') }}" required>
                                @error('tempat_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- PEGAWAI & PEJABAT --}}
                        <h5 class="fw-bold mb-3">Data Pegawai & Pejabat</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="pegawai_id" class="form-label">Pegawai yang Dinyatakan</label>
                                <select name="pegawai_id" id="pegawai_id" class="form-select @error('pegawai_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Pegawai --</option>
                                    @foreach($pegawais as $p)
                                        <option value="{{ $p->id }}" {{ old('pegawai_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap ?? $p->nama }} - {{ $p->nip }}</option>
                                    @endforeach
                                </select>
                                @error('pegawai_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="pejabat_id" class="form-label">Pegawai yang Menetapkan</label>
                                <select name="pejabat_id" id="pejabat_id" class="form-select @error('pejabat_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Pejabat --</option>
                                    @foreach($pegawais as $p)
                                        <option value="{{ $p->id }}" {{ old('pejabat_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap ?? $p->nama }} - {{ $p->nip }}</option>
                                    @endforeach
                                </select>
                                @error('pejabat_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- DETAIL TUGAS --}}
                        <h5 class="fw-bold mb-3">Detail Tugas</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Peraturan Tugas</label>
                                <input type="text" name="peraturan_tugas" class="form-control @error('peraturan_tugas') is-invalid @enderror" value="{{ old('peraturan_tugas') }}" required>  
                                @error('peraturan_tugas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Nomor Peraturan</label>
                                <input type="number" name="nomor_peraturan" class="form-control @error('nomor_peraturan') is-invalid @enderror" value="{{ old('nomor_peraturan') }}" required>
                                @error('nomor_peraturan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tahun Peraturan</label>
                                <input type="number" name="tahun_peraturan" maxlength="4" class="form-control @error('tahun_peraturan') is-invalid @enderror" value="{{ old('tahun_peraturan') }}" required>
                                @error('tahun_peraturan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Tentang Peraturan</label>
                                <input type="text" name="tentang_peraturan" class="form-control @error('tentang_peraturan') is-invalid @enderror" value="{{ old('tentang_peraturan') }}" required>        
                                @error('tentang_peraturan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Mulai Tugas</label>
                                <div class="input-group">
                                    <input type="text" name="tanggal_mulai_tugas" id="tanggal_mulai" class="form-control @error('tanggal_mulai_tugas') is-invalid @enderror" value="{{ old('tanggal_mulai_tugas') }}" placeholder="dd-mm-YYYY" autocomplete="off" required>
                                    <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_mulai" for="tanggal_mulai">
                                        <i class="bi bi-calendar3"></i>
                                    </button>
                                </div>
                                @error('tanggal_mulai_tugas') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jabatan Tugas</label>
                                <input type="text" name="jabatan_tugas" class="form-control @error('jabatan_tugas') is-invalid @enderror" value="{{ old('jabatan_tugas') }}" required>
                                @error('jabatan_tugas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Lokasi Tugas</label>
                                <input type="text" name="lokasi_tugas" class="form-control @error('lokasi_tugas') is-invalid @enderror" value="{{ old('lokasi_tugas') }}" required>
                                @error('lokasi_tugas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- TEMBUSAN --}}
                        <h5 class="fw-bold mb-3">Tembusan</h5>
                        <div class="mb-3">
                            <textarea class="form-control @error('tembusan') is-invalid @enderror" id="tembusan" name="tembusan" rows="3">{{ old('tembusan') }}</textarea>
                            <small class="form-text text-muted">Pisahkan setiap tembusan dengan koma (contoh: Direktur RSUD, Arsip).</small>
                            @error('tembusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Pernyataan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection