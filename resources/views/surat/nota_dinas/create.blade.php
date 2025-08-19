@extends('surat.layouts.main')

@section('main')

<div class="pagetitle"> 
    <div class="row justify-content-between">
        <div class="col">
            <h1>Pengajuan Nota Dinas</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('nota_dinas.index') }}">Daftar Nota Dinas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengajuan Nota Dinas</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Tambah Nota Dinas Title -->

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form Pengajuan Nota Dinas</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('nota_dinas.store') }}">
                        @csrf
                        <div class="mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nomor" class="form-label">Nomor Surat</label>
                                    <input type="text" class="form-control @error('nomor') is-invalid @enderror" id="nomor" name="nomor" placeholder="Contoh: 800/ND/123/IV" value="{{ old('nomor') }}">
                                    @error('nomor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="tempat" class="form-label">Tempat</label>
                                    <input type="text" class="form-control @error('tempat') is-invalid @enderror" id="tempat" name="tempat" value="{{ old('tempat') }}" placeholder="Slawi">
                                    @error('tempat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <div class="input-group">
                                        <input type="text" name="tanggal" id="tanggal_nota" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', \Carbon\Carbon::now()->format('d-m-Y')) }}" placeholder="dd-mm-yyyy" required>
                                        <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_nota" for="tanggal_nota">
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
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="pemberi_id" class="form-label">Pengirim</label>
                                    <select class="form-select @error('pemberi_id') is-invalid @enderror" id="pemberi_id" name="pemberi_id" required>
                                        <option value="" disabled selected>-- Pilih pemberi --</option>
                                        @foreach ($pegawais as $pegawai)
                                            <option value="{{ $pegawai->id }}" {{ old('pemberi_id') == $pegawai->id ? 'selected' : '' }}>
                                                {{ $pegawai->nama }} - (NIP: {{ $pegawai->nip ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pemberi_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="penerima_id" class="form-label">Penerima</label>
                                    <select class="form-select @error('penerima_id') is-invalid @enderror" id="penerima_id" name="penerima_id" required>
                                        <option value="" disabled selected>-- Pilih Penerima --</option>
                                        @foreach ($pegawais as $pegawai)
                                            <option value="{{ $pegawai->id }}" {{ old('penerima_id') == $pegawai->id ? 'selected' : '' }}>
                                                {{ $pegawai->nama }} - (NIP: {{ $pegawai->nip ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('penerima_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="sifat" class="form-label">Sifat Nota</label>
                                    <input type="text" class="form-control @error('sifat') is-invalid @enderror" id="sifat" name="sifat" value="{{ old('sifat') }}">
                                    @error('sifat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="lampiran" class="form-label">Lampiran</label>
                                    <input type="text" class="form-control @error('lampiran') is-invalid @enderror" id="lampiran" name="lampiran" value="{{ old('lampiran') }}">
                                    @error('lampiran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="hal" class="form-label">Hal</label>
                            <input type="text" class="form-control @error('hal') is-invalid @enderror" id="hal" name="hal" placeholder="Perihal surat..." value="{{ old('hal') }}" required>
                            @error('hal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Nota Dinas</label>
                            <textarea class="form-control @error('isi') is-invalid @enderror" id="isi" name="isi" rows="6" required>{{ old('isi') }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tembusan" class="form-label">Tembusan</label>
                            <textarea class="form-control @error('tembusan') is-invalid @enderror" id="tembusan" name="tembusan" rows="3">{{ old('tembusan') }}</textarea>
                            <small class="form-text text-muted">Pisahkan setiap tembusan dengan koma (contoh: Direktur RSUD, Arsip).</small>
                            @error('tembusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan Nota Dinas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection