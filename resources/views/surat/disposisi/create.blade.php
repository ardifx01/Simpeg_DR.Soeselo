@extends('surat.layouts.main')

@section('main')

<div class="pagetitle"> 
    <div class="row justify-content-between">
        <div class="col">
            <h1>Pengajuan Surat Disposisi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('disposisi.index') }}">Daftar Surat Disposisi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengajuan Surat Disposisi</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Tambah Disposisi Title -->

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form pengajuan Surat Disposisi</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('disposisi.store') }}">
                        @csrf
                        <div class="mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="surat_dari" class="form-label">Surat Dari</label>
                                    <input type="text" name="surat_dari" id="surat_dari" class="form-control @error('surat_dari') is-invalid @enderror" value="{{ old('surat_dari') }}" required>
                                    @error('surat_dari')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="no_surat" class="form-label">Nomor Surat</label>
                                    <input type="number" name="no_surat" id="no_surat" class="form-control @error('no_surat') is-invalid @enderror" value="{{ old('no_surat') }}" placeholder="Contoh: 800/123/IV" required>
                                    @error('no_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="tgl_surat" class="form-label">Tanggal Surat</label>
                                    <div class="input-group">
                                        <input type="text" name="tgl_surat" id="tanggal_disposisi" class="form-control @error('tgl_surat') is-invalid @enderror" value="{{ old('tgl_surat') }}" required>
                                        <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_disposisi" for="tanggal_disposisi">
                                            <i class="bi bi-calendar3"></i>
                                        </button>
                                    </div>
                                    @error('tgl_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="tgl_diterima" class="form-label">Tanggal Diterima</label>
                                    <div class="input-group">
                                        <input type="text" name="tgl_diterima" id="tanggal_diterima" class="form-control @error('tgl_diterima') is-invalid @enderror" value="{{ old('tgl_diterima') }}" required>
                                        <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_diterima" for="tanggal_diterima">
                                            <i class="bi bi-calendar3"></i>
                                        </button>
                                    </div>
                                    @error('tgl_diterima')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="no_agenda" class="form-label">Nomor Agenda</label>
                            <input type="number" name="no_agenda" id="no_agenda" class="form-control @error('no_agenda') is-invalid @enderror" value="{{ old('no_agenda') }}" required>
                            @error('no_agenda')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sifat" class="form-label">Sifat Surat</label>
                            <select name="sifat" id="sifat" class="form-select @error('sifat') is-invalid @enderror" required>
                                <option value="">Pilih Sifat</option>
                                @foreach($sifat_options as $sifat)
                                    <option value="{{ $sifat }}" {{ old('sifat') == $sifat ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $sifat)) }}</option>
                                @endforeach
                            </select>
                            @error('sifat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hal" class="form-label">Hal</label>
                            <input type="text" name="hal" id="hal" class="form-control @error('hal') is-invalid @enderror" value="{{ old('hal') }}" required>
                            @error('hal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="diteruskan_kepada" class="form-label">Diteruskan Kepada</label>
                            <select name="diteruskan_kepada[]" id="diteruskan_kepada" class="form-select @error('diteruskan_kepada') is-invalid @enderror" multiple required>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ in_array($pegawai->id, old('diteruskan_kepada', [])) ? 'selected' : '' }}>
                                        {{ $pegawai->nama }} - {{ $pegawai->nip ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('diteruskan_kepada')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Harap</label>
                            <div class="row">
                                @foreach($harap_options as $harap)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input @error('harap') is-invalid @enderror" type="checkbox" name="harap[]" value="{{ $harap }}" id="harap_{{ \Str::slug($harap) }}" {{ in_array($harap, old('harap', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="harap_{{ \Str::slug($harap) }}">
                                                {{ ucwords($harap) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                @error('harap')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="penandatangan_id" class="form-label">Penandatangan</label>
                            <select name="penandatangan_id" id="penandatangan_id" class="form-select @error('penandatangan_id') is-invalid @enderror" required>
                                <option value="">Pilih Penandatangan</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('penandatangan_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            @error('penandatangan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan Disposisi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
