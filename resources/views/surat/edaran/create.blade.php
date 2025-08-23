@extends('surat.layouts.main')

@section('main')

<div class="pagetitle"> 
    <div class="row justify-content-between">
        <div class="col">
            <h1>Pengajuan Surat Edaran</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('edaran.index') }}">Daftar Surat Edaran</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengajuan Surat Edaran</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Tambah Edaran Title -->

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form pengajuan Surat Edaran</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('edaran.store') }}">
                        @csrf
                        <div class="mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nomor" class="form-label">Nomor Surat (Opsional)</label>
                                    <input type="text" class="form-control @error('nomor') is-invalid @enderror" id="nomor" name="nomor" placeholder="Contoh: 800/123/IV" value="{{ old('nomor') }}">
                                    @error('nomor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}" required>
                                    @error('tahun')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tentang" class="form-label">Tentang</label>
                            <input type="text" class="form-control @error('tentang') is-invalid @enderror" id="tentang" name="tentang" placeholder="Perihal surat edaran" value="{{ old('tentang') }}" required>
                            @error('tentang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Yth. (Penerima)</label>
                            <select class="form-select @error('tujuan') is-invalid @enderror" id="tujuan" name="tujuan[]" multiple="multiple" required>
                                @foreach ($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}" {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            @error('tujuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="isi_edaran" class="form-label">Isi Surat Edaran</label>
                            <textarea class="form-control @error('isi_edaran') is-invalid @enderror" id="isi_edaran" name="isi_edaran" rows="10">{{ old('isi_edaran') }}</textarea>
                            @error('isi_edaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="tanggal_ditetapkan" class="form-label">Tanggal Ditetapkan</label>
                                    <div class="input-group">
                                        <input type="text" name="tanggal_ditetapkan" id="tanggal_ditetapkan" class="form-control @error('tanggal_ditetapkan') is-invalid @enderror" value="{{ old('tanggal_ditetapkan', \Carbon\Carbon::now()->format('d-m-Y')) }}" required>
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
                            <button type="submit" class="btn btn-primary">Simpan Edaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
