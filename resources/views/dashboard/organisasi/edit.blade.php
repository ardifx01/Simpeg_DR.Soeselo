@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Organisasi | <small>Ubah Organisasi</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('organisasi.index') }}">Riwayat Organisasi</a></li>
                            <li class="breadcrumb-item active">Tambah Organisasi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div><!-- End Organisasi Edit Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Fiklat Organisasi Edit -->
            <div class="container rounded shadow p-4">
                <form action="{{ route('organisasi.update', $organisasi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="row mb-3">
                            <label for="pegawai_id" class="col-md-4 col-lg-3 col-form-label">1. Pegawai</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select" aria-label="Default select example" name="pegawai_id" id="pegawai_id">
                                    <option selected>...</option>
                                    @foreach($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}" {{ $organisasi->pegawai_id == $pegawai->id ? 'selected' : '' }}>
                                            {{ $pegawai->nip }} - {{ $pegawai->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nama" class="col-md-4 col-lg-3 col-form-label">2. Nama Organisasi</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') ?? $organisasi->nama }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jenis" class="col-md-4 col-lg-3 col-form-label">3. Jenis Organisasi</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="jenis" type="text" class="form-control @error('jenis') is-invalid @enderror" id="jenis" value="{{ old('jenis') ?? $organisasi->jenis }}" required>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jabatan" class="col-md-4 col-lg-3 col-form-label">4. Jabatan</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="jabatan" type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" value="{{ old('jabatan') ?? $organisasi->jabatan }}" required>
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tmt" class="col-md-4 col-lg-3 col-form-label">5. TMT</label>
                            <div class="col-md-4 col-lg-3">
                                <input name="tmt" type="text" class="form-control @error('tmt') is-invalid @enderror" id="tmt" value="{{ old('tmt') ?? $organisasi->tmt }}" required>
                                @error('tmt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="text-center p-2">
                                <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> save</button>
                            </div>
                            <div class="text-center p-2">
                                <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-arrow-90deg-left"></i> cancel</button>
                            </div>
                        </div>
                    </form>
            </div><!-- End Organisasi Edit -->

        </div>
        </section>

@endsection