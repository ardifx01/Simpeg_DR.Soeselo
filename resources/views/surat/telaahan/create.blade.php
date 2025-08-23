{{-- resources/views/surat/telaahan/create.blade.php --}}
@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <h1 class="h2 fw-bold text-primary">Tambah Telaahan Staf</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
            <li class="breadcrumb-item"><a href="{{ route('telaahan.index') }}">Telaahan Staf</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<section class="row mt-4">
    <div class="col-12 col-lg-10 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0">Form Telaahan Staf</h4>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('telaahan.store') }}" method="POST">
                    @csrf

                    {{-- HEADER SURAT --}}
                    <h5 class="fw-bold mb-3">Header Surat</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="nomor" class="form-label">Nomor</label>
                            <input type="text" name="nomor" id="nomor" class="form-control @error('nomor') is-invalid @enderror" placeholder="Contoh: 800/ND/123/IV" value="{{ old('nomor') }}" required>
                            @error('nomor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="tanggal_surat" class="form-label">Tanggal</label>
                            <div class="input-group">
                                {{-- NOTE: name="tanggal" supaya match kolom DB; id="tanggal_surat" biar auto-registered datepicker global --}}
                                <input type="text" name="tanggal" id="tanggal_surat" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" placeholder="dd-mm-YYYY" autocomplete="off" required>
                                <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_surat" for="tanggal_surat">
                                    <i class="bi bi-calendar3"></i>
                                </button>
                            </div>
                            @error('tanggal') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="lampiran" class="form-label">Lampiran (opsional)</label>
                            <input type="text" name="lampiran" id="lampiran" class="form-control @error('lampiran') is-invalid @enderror" value="{{ old('lampiran') }}">
                            @error('lampiran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="hal" class="form-label">Perihal</label>
                            <input type="text" name="hal" id="hal" class="form-control @error('hal') is-invalid @enderror" value="{{ old('hal') }}" required>
                            @error('hal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- PENERIMA & PENGIRIM --}}
                    <h5 class="fw-bold mb-3">Pihak Terkait</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="yth_id" class="form-label">Yth (Tujuan)</label>
                            <select name="yth_id" id="yth_id" class="form-select @error('yth_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('yth_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap ?? $pegawai->nama }} - {{ $pegawai->nip }}</option>
                                @endforeach
                            </select>
                            @error('yth_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="dari_id" class="form-label">Dari</label>
                            <select name="dari_id" id="dari_id" class="form-select @error('dari_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('dari_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap ?? $pegawai->nama }} - {{ $pegawai->nip }}</option>
                                @endforeach
                            </select>
                            @error('dari_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <hr class="my-4">

                    {{-- ISI TELAAHAN --}}
                    <h5 class="fw-bold mb-3">Isi Telaahan</h5>

                    <div class="mb-3">
                        <label for="persoalan" class="form-label">Persoalan</label>
                        <input id="persoalan" type="hidden" name="persoalan" value="{{ old('persoalan') }}">
                        <trix-editor input="persoalan" class="@error('persoalan') is-invalid @enderror"></trix-editor>
                        @error('persoalan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="praanggapan" class="form-label">Praanggapan</label>
                        <input id="praanggapan" type="hidden" name="praanggapan" value="{{ old('praanggapan') }}">
                        <trix-editor input="praanggapan" class="@error('praanggapan') is-invalid @enderror"></trix-editor>
                        @error('praanggapan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="fakta" class="form-label">Fakta</label>
                        <input id="fakta" type="hidden" name="fakta" value="{{ old('fakta') }}">
                        <trix-editor input="fakta" class="@error('fakta') is-invalid @enderror"></trix-editor>
                        @error('fakta') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="analisis" class="form-label">Analisis</label>
                        <input id="analisis" type="hidden" name="analisis" value="{{ old('analisis') }}">
                        <trix-editor input="analisis" class="@error('analisis') is-invalid @enderror"></trix-editor>
                        @error('analisis') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kesimpulan" class="form-label">Kesimpulan</label>
                        <input id="kesimpulan" type="hidden" name="kesimpulan" value="{{ old('kesimpulan') }}">
                        <trix-editor input="kesimpulan" class="@error('kesimpulan') is-invalid @enderror"></trix-editor>
                        @error('kesimpulan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="saran" class="form-label">Saran</label>
                        <input id="saran" type="hidden" name="saran" value="{{ old('saran') }}">
                        <trix-editor input="saran" class="@error('saran') is-invalid @enderror"></trix-editor>
                        @error('saran') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <hr class="my-4">

                    {{-- PENANDATANGAN --}}
                    <h5 class="fw-bold mb-3">Penandatangan</h5>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="penandatangan_id" class="form-label">Nama Penandatangan</label>
                            <select name="penandatangan_id" id="penandatangan_id"
                                    class="form-select select2 @error('penandatangan_id') is-invalid @enderror">
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
                            <i class="fas fa-save"></i> Simpan Telaahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection