{{-- resources/views/surat/tugas/create.blade.php --}}
@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <h1 class="h2 fw-bold text-primary">Tambah Surat Tugas</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tugas.index') }}">Surat Tugas</a></li>
            <li class="breadcrumb-item active">Tambah Surat Tugas</li>
        </ol>
    </nav>
</div>

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form Surat Tugas</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('tugas.store') }}" method="POST">
                        @csrf

                        {{-- DETAIL SURAT --}}
                        <h5 class="fw-bold mb-3">Detail Surat</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="nomor" class="form-label">Nomor Surat</label>
                                <input type="text" class="form-control @error('nomor') is-invalid @enderror" id="nomor" name="nomor" placeholder="Contoh: 800/ND/123/IV" value="{{ old('nomor') }}" required>    
                                @error('nomor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="tempat_dikeluarkan" class="form-label">Tempat Dikeluarkan</label>
                                <input type="text" class="form-control @error('tempat_dikeluarkan') is-invalid @enderror" id="tempat_dikeluarkan" name="tempat_dikeluarkan" value="{{ old('tempat_dikeluarkan') }}" required>
                                @error('tempat_dikeluarkan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="tanggal_dikeluarkan" class="form-label">Tanggal Dikeluarkan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('tanggal_dikeluarkan') is-invalid @enderror" id="tanggal_dikeluarkan" name="tanggal_dikeluarkan" value="{{ old('tanggal_dikeluarkan') }}" placeholder="dd-mm-yyyy" autocomplete="off" required>
                                    <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_dikeluarkan" for="tanggal_dikeluarkan">
                                        <i class="bi bi-calendar3"></i>
                                    </button>
                                </div>
                                @error('tanggal_dikeluarkan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- PEGAWAI DITUGASKAN --}}
                        <h5 class="fw-bold mb-3">Pegawai Ditugaskan</h5>
                        <div class="mb-3">
                            <label for="pegawai" class="form-label">Pegawai (Boleh lebih dari satu)</label>
                            <select name="pegawai[]" id="pegawai" class="form-select select2 @error('pegawai') is-invalid @enderror" multiple required>
                                @foreach($pegawais as $p)
                                    <option value="{{ $p->id }}" 
                                    @if(collect(old('pegawai', []))->contains($p->id)) selected @endif>
                                    {{ $p->nama_lengkap ?? $p->nama }} (NIP: {{ $p->nip }})
                                </option>
                                @endforeach
                            </select>
                            @error('pegawai') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <hr class="my-4">

                        {{-- DASAR & UNTUK --}}
                        <h5 class="fw-bold mb-3">Isi Surat</h5>
                        <div class="mb-3">
                            <label class="form-label">Dasar</label>
                            <textarea name="dasar" rows="3" class="form-control @error('dasar') is-invalid @enderror" required>{{ old('dasar') }}</textarea>
                            <small class="text-muted">Pisahkan dengan titik koma (;) jika lebih dari satu dasar.</small>
                            @error('dasar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Untuk</label>
                            <textarea name="untuk" rows="3" class="form-control @error('untuk') is-invalid @enderror" required>{{ old('untuk') }}</textarea>
                            <small class="text-muted">Pisahkan dengan titik koma (;) jika lebih dari satu tugas.</small>
                            @error('untuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <hr class="my-4">

                        {{-- PENANDATANGAN --}}
                        <h5 class="fw-bold mb-3">Penandatangan</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="penandatangan_id" class="form-label">Penandatangan</label>
                                <select name="penandatangan_id" id="penandatangan_id"
                                        class="form-select @error('penandatangan_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Penandatangan --</option>
                                    @foreach($pegawais as $p)
                                        <option value="{{ $p->id }}" {{ old('penandatangan_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap ?? $p->nama }} (NIP: {{ $p->nip }})</option>
                                    @endforeach
                                </select>
                                @error('penandatangan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Surat Tugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection