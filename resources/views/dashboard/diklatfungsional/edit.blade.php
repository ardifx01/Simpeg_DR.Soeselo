@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Diklat Fungsional | <small>Tambah Diklat Fungsional</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="[{{ route('diklatfungsional.index') }}]">Riwayat Diklat Fungsional</a></li>
                            <li class="breadcrumb-item active">Tambah Diklat Fungsional</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div><!-- End Diklat Fungsional Edit Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Fiklat Fungsional Edit -->
            <div class="container rounded shadow p-4">
                <form action="{{ route('diklatfungsional.update', $diklatfungsional->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="row mb-3">
                            <label for="pegawai_id" class="col-md-4 col-lg-3 col-form-label">1. Pegawai</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select" aria-label="Default select example" name="pegawai_id" id="pegawai_id">
                                    <option selected>...</option>
                                    @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ $diklatfungsional->pegawai_id == $pegawai->id ? 'selected' : '' }}>
                                        {{ $pegawai->nip }} - {{ $pegawai->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nama" class="col-md-4 col-lg-3 col-form-label">2. Nama Diklat</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') ?? $diklatfungsional->nama }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="penyelenggara" class="col-md-4 col-lg-3 col-form-label">3. Penyelenggara</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="penyelenggara" type="text" class="form-control @error('penyelenggara') is-invalid @enderror" id="penyelenggara" value="{{ old('penyelenggara') ?? $diklatfungsional->penyelenggara }}" required>
                                @error('penyelenggara')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jumlah_jam" class="col-md-4 col-lg-3 col-form-label">4. Jumlah Jam</label>
                            <div class="col-md-4 col-lg-3">
                                <input name="jumlah_jam" type="text" class="form-control @error('jumlah_jam') is-invalid @enderror" id="jumlah_jam" value="{{ old('jumlah_jam') ?? $diklatfungsional->jumlah_jam }}" required>
                                @error('jumlah_jam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                </div>
                        </div>
                        

                        <div class="row mb-3">
                            <label for="tanggal_selesai" class="col-md-4 col-lg-3 col-form-label">5. Tanggal Selesai</label>
                            <div class="col-md-4 col-lg-3">
                                <div class="input-group mb-3">
                                    <input name="tanggal_selesai" type="text" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tangga_selesai') ?? $diklatfungsional->tanggal_selesai }}">
                                        @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    <button class="btn btn-outline-secondary" type="button" for="tanggal_selesai" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                </div>
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
            </div><!-- End Diklat Fungsional Edit -->

        </div>
        </section>

@endsection