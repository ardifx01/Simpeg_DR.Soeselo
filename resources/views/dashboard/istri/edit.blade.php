@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Suami / Istri | <small>Ubah Suami / Istri</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('istri.index') }}">Data Istri</a></li>
                            <li class="breadcrumb-item active">Ubah Suami / Istri</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div><!-- End Istri Edit Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Istri Edit -->
            <div class="container rounded shadow p-4">
                <form action="{{ route('istri.update', $istri->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="pegawai_id" class="col-md-4 col-lg-3 col-form-label">1. Pegawai</label>
                        <div class="col-md-8 col-lg-9">
                            <select class="form-select" aria-label="Default select example" name="pegawai_id" id="pegawai_id" required>
                                <option selected disabled>-- Pilih Pegawai --</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ $istri->pegawai_id == $pegawai->id ? 'selected' : '' }}>
                                        {{ $pegawai->nip }} - {{ $pegawai->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nama" class="col-md-4 col-lg-3 col-form-label">2. Nama</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="nama" type="text" class="form-control" id="nama" value="{{ old('nama') ?? $istri->nama }}" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="tempat_lahir" class="col-md-4 col-lg-3 col-form-label">3. Tempat Lahir</label>
                        <div class="col-md-4 col-lg-3">
                            <input name="tempat_lahir" type="text" class="form-control" id="tempat_lahir" value="{{ old('tempat_lahir') ?? $istri->tempat_lahir }}" required>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="input-group mb-3">
                                <input name="tanggal_lahir" type="text" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tanggal_lahir') ?? $istri->tanggal_lahir }}" required>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <button class="btn btn-outline-secondary" type="button" for="tanggal_lahir" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="profesi" class="col-md-4 col-lg-3 col-form-label">4. Profesi</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="profesi" type="text" class="form-control" id="profesi" value="{{ old('profesi') ?? $istri->profesi }}">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="tanggal_nikah" class="col-md-4 col-lg-3 col-form-label">5. Tanggal Nikah</label>
                        <div class="col-md-4 col-lg-3">
                            <div class="input-group mb-3">
                                <input name="tanggal_nikah" type="text" class="form-control @error('tanggal_nikah') is-invalid @enderror" id="tanggal_nikah" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tanggal_nikah') ?? $istri->tanggal_nikah }}" required>
                                @error('tanggal_nikah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <button class="btn btn-outline-secondary" type="button" for="tanggal_nikah" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="status_hubungan" class="col-md-4 col-lg-3 col-form-label">6. Status Hubungan</label>
                        <div class="col-md-4 col-lg-3">
                            <select class="form-select" aria-label="Default select example" name="status_hubungan" id="status_hubungan">
                                <option selected>...</option>
                                <option value="Suami" {{ (old('status_hubungan') ?? $istri->status_hubungan)=='Suami' ? 'selected': '' }} >1. Suami</option>
                                <option value="Istri" {{ (old('status_hubungan') ?? $istri->status_hubungan)=='Istri' ? 'selected': '' }} >2. Istri</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="text-center p-2">
                            <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> save</button>
                        </div>
                        <div class="text-center p-2">
                            <a href="{{ route('pegawai.show', $istri->pegawai_id) }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-90deg-left"></i> cancel</a>
                        </div>
                    </div>
                </form>
            </div><!-- End Istri Edit -->

        </div>
        </section>

@endsection