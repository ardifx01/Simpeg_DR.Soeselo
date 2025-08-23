@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Tambah Notula</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('notula.index') }}">Notula</a></li>
                    <li class="breadcrumb-item active">Tambah Notula</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form Pengajuan Notula</h4>
                </div>
                <div class="card-body p-4">
                <form action="{{ route('notula.store') }}" method="POST">
                    @csrf

                    <!-- Sidang / Rapat -->
                    <div class="mb-3">
                        <label for="sidang_rapat" class="form-label fw-bold">Sidang / Rapat</label>
                        <input type="text" name="sidang_rapat" id="sidang_rapat" class="form-control @error('sidang_rapat') is-invalid @enderror" value="{{ old('sidang_rapat') }}" required>
                        @error('sidang_rapat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal & Waktu -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label fw-bold">Tanggal</label>
                            <div class="input-group">
                                <input type="text" name="tanggal" id="tanggal_notula" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', \Carbon\Carbon::now()->format('d-m-Y')) }}" placeholder="dd-mm-yyyy" required>
                                <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_notula" for="tanggal_notula">
                                    <i class="bi bi-calendar3"></i>
                                </button>
                            </div>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="waktu" class="form-label fw-bold">Waktu</label>
                            <input type="time" name="waktu" id="waktu" class="form-control @error('waktu') is-invalid @enderror" value="{{ old('waktu') }}" required>
                            @error('waktu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Surat Undangan -->
                    <div class="mb-3 mt-3">
                        <label for="surat_undangan" class="form-label fw-bold">Nomor Surat Undangan</label>
                        <input type="text" name="surat_undangan" id="surat_undangan" class="form-control @error('surat_undangan') is-invalid @enderror" value="{{ old('surat_undangan') }}">
                        @error('surat_undangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Acara -->
                    <div class="mb-3">
                        <label for="acara" class="form-label fw-bold">Acara</label>
                        <textarea name="acara" id="acara" rows="3" class="form-control @error('acara') is-invalid @enderror" required>{{ old('acara') }}</textarea>
                        @error('acara')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ketua, Sekretaris, Pencatat -->
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="ketua_id" class="form-label fw-bold">Ketua</label>
                            <select name="ketua_id" id="ketua_id"
                                    class="form-select @error('ketua_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Ketua --</option>
                                @foreach ($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('ketua_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            @error('ketua_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="sekretaris_id" class="form-label fw-bold">Sekretaris</label>
                            <select name="sekretaris_id" id="sekretaris_id"
                                    class="form-select @error('sekretaris_id') is-invalid @enderror">
                                <option value="">-- Pilih Sekretaris --</option>
                                @foreach ($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('sekretaris_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            @error('sekretaris_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="pencatat_id" class="form-label fw-bold">Pencatat</label>
                            <select name="pencatat_id" id="pencatat_id"
                                    class="form-select @error('pencatat_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pencatat --</option>
                                @foreach ($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('pencatat_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            @error('pencatat_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Peserta (multi select) -->
                    <div class="mb-3 mt-3">
                        <label for="peserta" class="form-label fw-bold">Peserta</label>
                        <select name="peserta[]" id="peserta" class="form-select @error('peserta') is-invalid @enderror" multiple required>
                            @foreach($pegawais as $pegawai)
                            <option value="{{ $pegawai->id }}" {{ in_array($pegawai->id, old('peserta', [])) ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }} - {{ $pegawai->nip ?? '' }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">* Tekan Ctrl / Cmd untuk memilih lebih dari satu peserta</small>
                        @error('peserta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kegiatan Rapat -->
                    <div class="mb-3">
                        <label for="kegiatan_rapat" class="form-label fw-bold">Kegiatan Rapat</label>
                        <textarea name="kegiatan_rapat" id="kegiatan_rapat" rows="4" class="form-control @error('kegiatan_rapat') is-invalid @enderror" required>{{ old('kegiatan_rapat') }}</textarea>
                        @error('kegiatan_rapat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol -->
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Notula</button>
                    </div>

                </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
