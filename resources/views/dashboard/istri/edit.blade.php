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
                        <label for="pegawai_id" class="col-md-4 col-lg-3 col-form-label">Pegawai</label>
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

                    <!-- Nama -->
                    <div class="row mb-3">
                        <label for="nama_{{ $istri->id }}" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="nama" type="text" class="form-control" id="nama_{{ $istri->id }}" value="{{ old('nama', $istri->nama) }}" required>
                        </div>
                    </div>

                    <!-- Tempat, Tanggal Lahir -->
                    <div class="row mb-3">
                        <label for="tempat_lahir_{{ $istri->id }}" class="col-md-4 col-lg-3 col-form-label">Tempat, Tanggal Lahir</label>
                        <div class="col-md-4 col-lg-3">
                            <input name="tempat_lahir" type="text" class="form-control" id="tempat_lahir_{{ $istri->id }}" value="{{ old('tempat_lahir', $istri->tempat_lahir) }}" required>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="input-group">
                                <input name="tanggal_lahir_istri" type="text" class="form-control" id="tanggal_lahir_istri_edit_{{ $istri->id }}" value="{{ old('tanggal_lahir_istri', \Carbon\Carbon::parse($istri->tanggal_lahir_istri)->format('d-m-Y')) }}" required>
                                <button class="btn btn-outline-secondary" type="button" for="tanggal_lahir_istri_edit_{{ $istri->id }}"><i class="bi bi-calendar3"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Profesi -->
                    <div class="row mb-3">
                        <label for="profesi_{{ $istri->id }}" class="col-md-4 col-lg-3 col-form-label">Profesi</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="profesi" type="text" class="form-control" id="profesi_{{ $istri->id }}" value="{{ old('profesi', $istri->profesi) }}" required>
                        </div>
                    </div>

                    <!-- Tanggal Nikah -->
                    <div class="row mb-3">
                        <label for="tanggal_nikah_edit_{{ $istri->id }}" class="col-md-4 col-lg-3 col-form-label">Tanggal Nikah</label>
                        <div class="col-md-4 col-lg-3">
                            <div class="input-group">
                                <input name="tanggal_nikah" type="text" class="form-control" id="tanggal_nikah_edit_{{ $istri->id }}" value="{{ old('tanggal_nikah', \Carbon\Carbon::parse($istri->tanggal_nikah)->format('d-m-Y')) }}" required>
                                <button class="btn btn-outline-secondary" type="button" for="tanggal_nikah_edit_{{ $istri->id }}"><i class="bi bi-calendar3"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Status Hubungan -->
                    <div class="row mb-3">
                        <label for="status_hubungan_{{ $istri->id }}" class="col-md-4 col-lg-3 col-form-label">Status Hubungan</label>
                        <div class="col-md-4 col-lg-3">
                            <select class="form-select" name="status_hubungan" id="status_hubungan_{{ $istri->id }}" required>
                                <option disabled>-- Pilihan --</option>
                                <option value="Suami" {{ old('status_hubungan', $istri->status_hubungan) == 'Suami' ? 'selected' : '' }}>Suami</option>
                                <option value="Istri" {{ old('status_hubungan', $istri->status_hubungan) == 'Istri' ? 'selected' : '' }}>Istri</option>
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