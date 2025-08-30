{{-- resources/views/surat/undangan/create.blade.php --}}
@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <h1 class="h2 fw-bold text-primary">Tambah Surat Undangan</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
            <li class="breadcrumb-item"><a href="{{ route('undangan.index') }}">Surat Undangan</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form Surat Undangan</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('undangan.store') }}" method="POST">
                        @csrf

                        {{-- DETAIL SURAT --}}
                        <h5 class="fw-bold mb-3">Detail Surat</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="nomor" class="form-label">Nomor Surat</label>
                                <input type="text" name="nomor" id="nomor" class="form-control @error('nomor') is-invalid @enderror" value="{{ old('nomor') }}" placeholder="Contoh: 005/123/RSUD" required>
                                @error('nomor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="tempat_surat" class="form-label">Tempat Surat</label>
                                <input type="text" name="tempat_surat" id="tempat_surat" class="form-control @error('tempat_surat') is-invalid @enderror" value="{{ old('tempat_surat') }}" placeholder="Slawi" required>
                                @error('tempat_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                                <div class="input-group">
                                    <input type="text" name="tanggal_surat" id="tanggal_surat" class="form-control @error('tanggal_surat') is-invalid @enderror" value="{{ old('tanggal_surat') }}" placeholder="dd-mm-YYYY" autocomplete="off" required>
                                    <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_surat" for="tanggal_surat">
                                        <i class="bi bi-calendar3"></i>
                                    </button>
                                </div>
                                @error('tanggal_surat') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <label for="sifat" class="form-label">Sifat</label>
                                <input type="text" name="sifat" id="sifat" class="form-control @error('sifat') is-invalid @enderror" value="{{ old('sifat') }}" placeholder="Penting/Biasa">
                                @error('sifat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="lampiran" class="form-label">Lampiran</label>
                                <input type="text" name="lampiran" id="lampiran" class="form-control @error('lampiran') is-invalid @enderror" value="{{ old('lampiran') }}" placeholder="-">
                                @error('lampiran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="hal" class="form-label">Hal</label>
                                <input type="text" name="hal" id="hal" class="form-control @error('hal') is-invalid @enderror" value="{{ old('hal') }}" required>
                                @error('hal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- TUJUAN --}}
                        <h5 class="fw-bold mb-3">Tujuan</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="yth" class="form-label">Yth</label>
                                <input type="text" name="yth" id="yth" class="form-control @error('yth') is-invalid @enderror" value="{{ old('yth') }}" required>
                                @error('yth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}">
                                @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- ISI SURAT --}}
                        <h5 class="fw-bold mb-3">Isi Surat</h5>
                        <div class="mb-3">
                            <label for="pembuka_surat" class="form-label">Pembuka Surat</label>
                            <input id="pembuka_surat" type="hidden" name="pembuka_surat" value="{{ old('pembuka_surat') }}">
                            <trix-editor input="pembuka_surat" class="@error('pembuka_surat') is-invalid @enderror"></trix-editor>
                            @error('pembuka_surat') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="tanggal_acara" class="form-label">Tanggal Acara</label>
                                <div class="input-group">
                                    <input type="text" name="tanggal_acara" id="tanggal_acara" class="form-control @error('tanggal_acara') is-invalid @enderror" value="{{ old('tanggal_acara') }}" placeholder="dd-mm-YYYY" autocomplete="off" required>
                                    <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_acara" for="tanggal_acara">
                                        <i class="bi bi-calendar3"></i>
                                    </button>
                                </div>
                                @error('tanggal_acara') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="hari" class="form-label">Hari</label>
                                <input type="text" name="hari" id="hari"class="form-control @error('hari') is-invalid @enderror" value="{{ old('hari') }}"> 
                                @error('hari') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="waktu" class="form-label">Waktu</label>
                                <input type="text" name="waktu" id="waktu" class="form-control @error('waktu') is-invalid @enderror"  placeholder="12:00 WIB" value="{{ old('waktu') }}" required>
                                @error('waktu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="tempat" class="form-label">Tempat</label>
                                <input type="text" name="tempat" id="tempat" class="form-control @error('tempat') is-invalid @enderror" value="{{ old('tempat') }}" required>
                                @error('tempat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="acara" class="form-label">Acara</label>
                            <input type="text" name="acara" id="acara" class="form-control @error('acara') is-invalid @enderror" value="{{ old('acara') }}" required>
                            @error('acara') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="penutup_surat" class="form-label">Penutup Surat</label>
                            <input id="penutup_surat" type="hidden" name="penutup_surat" value="{{ old('penutup_surat') }}">
                            <trix-editor input="penutup_surat" class="@error('penutup_surat') is-invalid @enderror"></trix-editor>
                            @error('penutup_surat') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <hr class="my-4">

                        {{-- PENANDATANGAN --}}
                        <h5 class="fw-bold mb-3">Penandatangan</h5>
                        <div class="mb-3">
                            <label for="penandatangan_id" class="form-label">Pilih Penandatangan</label>
                            <select name="penandatangan_id" id="penandatangan_id" class="form-select select2 @error('penandatangan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Penandatangan --</option>
                                @foreach($pegawais as $p)
                                    <option value="{{ $p->id }}" {{ old('penandatangan_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap ?? $p->nama }} - {{ $p->nip }}</option>
                                @endforeach
                            </select>
                            @error('penandatangan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- TEMBUSAN --}}
                        <div class="mb-3">
                            <label for="tembusan" class="form-label">Tembusan</label>
                            <textarea class="form-control @error('tembusan') is-invalid @enderror" id="tembusan" name="tembusan" rows="3">{{ old('tembusan') }}</textarea>
                            <small class="form-text text-muted">Pisahkan dengan koma, contoh: Direktur RSUD, Arsip.</small>
                            @error('tembusan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Undangan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection