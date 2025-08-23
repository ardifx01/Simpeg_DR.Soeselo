@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <h1 class="h2 fw-bold text-primary">Tambah Surat Pengumuman</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengumuman.index') }}">Surat Pengumuman</a></li>
            <li class="breadcrumb-item active">Tambah Surat Pengumuman</li>
        </ol>
    </nav>
</div>

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form Pengajuan Surat Pengumuman</h4>
                </div>
                <div class="card-body p-4">
                <form action="{{ route('pengumuman.store') }}" method="POST" class="card shadow-sm p-4">
                    @csrf

                    {{-- DETAIL SURAT --}}
                    <h5 class="fw-bold mb-3">Detail Surat</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nomor_surat" class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat') }}" placeholder="Contoh: 800/123/IV" required>
                            @error('nomor_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="tanggal_surat" class="form-label">Tanggal Dikeluarkan</label>
                            <div class="input-group">
                                {{-- NOTE: name tetap tanggal_dikeluarkan (buat controller), ID-nya pakai tanggal_surat (buat datepicker di main.blade) --}}
                                <input type="text" class="form-control @error('tanggal_dikeluarkan') is-invalid @enderror" id="tanggal_surat" name="tanggal_dikeluarkan" value="{{ old('tanggal_dikeluarkan') }}" placeholder="dd-mm-YYYY" autocomplete="off" required>
                                <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_surat" for="tanggal_surat">
                                    <i class="bi bi-calendar3"></i>
                                </button>
                            </div>
                            @error('tanggal_dikeluarkan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="dikeluarkan_di" class="form-label">Dikeluarkan di</label>
                            <input type="text" class="form-control @error('dikeluarkan_di') is-invalid @enderror" id="dikeluarkan_di" name="dikeluarkan_di" value="{{ old('dikeluarkan_di') }}" placeholder="Contoh: Slawi" required>
                            @error('dikeluarkan_di') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="tentang" class="form-label">Tentang</label>
                            <input type="text" class="form-control @error('tentang') is-invalid @enderror" id="tentang" name="tentang" value="{{ old('tentang') }}" placeholder="Judul singkat pengumuman" required>
                            @error('tentang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="isi_pengumuman" class="form-label">Isi Pengumuman</label>
                            <textarea class="form-control @error('isi_pengumuman') is-invalid @enderror" id="isi_pengumuman" name="isi_pengumuman" rows="8" required>{{ old('isi_pengumuman') }}</textarea>
                            @error('isi_pengumuman') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Gunakan baris baru untuk paragraf.</small>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- PEJABAT PENGUMUM --}}
                    <h5 class="fw-bold mb-3">Pejabat Pengumum</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="pegawai_id" class="form-label">Pejabat</label>
                            <select name="pegawai_id" id="pegawai_id" class="form-select @error('pegawai_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($pegawais as $p)
                                    <option value="{{ $p->id }}" {{ old('pegawai_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_lengkap ?? $p->nama }} (NIP: {{ $p->nip }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pegawai_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Pengumuman
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
