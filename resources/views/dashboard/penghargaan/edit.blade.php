@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Penghargaan | <small>Ubah Penghargaan</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('penghargaan.index') }}">Riwayat Penghargaan</a></li>
                            <li class="breadcrumb-item active">Ubah Penghargaan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div><!-- End Penghargaan Edit Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Fiklat Penghargaan Edit -->
            <div class="container rounded shadow p-4">
                <form action="{{ route('penghargaan.update', $penghargaan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="row mb-3">
                            <label for="pegawai_id" class="col-md-4 col-lg-3 col-form-label">1. Pegawai</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select" aria-label="Default select example" name="pegawai_id" id="pegawai_id" required>
                                    <option selected>...</option>
                                    @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ $penghargaan->pegawai_id == $pegawai->id ? 'selected' : '' }}>
                                        {{ $pegawai->nip }} - {{ $pegawai->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nama" class="col-md-4 col-lg-3 col-form-label">2. Nama Tanda Jasa / Penghargaan</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') ?? $penghargaan->nama }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="pemberi" class="col-md-4 col-lg-3 col-form-label">3. Pemberi</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="pemberi" type="text" class="form-control @error('pemberi') is-invalid @enderror" id="pemberi" value="{{ old('pemberi') ?? $penghargaan->pemberi }}" required>
                                @error('pemberi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tahun" class="col-md-4 col-lg-3 col-form-label">4. Tahun</label>
                            <div class="col-md-4 col-lg-3">
                                <div class="input-group">
                                    <input name="tahun" type="text" class="form-control @error('tahun') is-invalid @enderror" id="tahun" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tahun') ?? $penghargaan->tahun }}" required>
                                    @error('tahun')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <button class="btn btn-outline-secondary" type="button" for="tahun" id="button-addon2"><i class="bi bi-calendar3"></i></button>
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
                    </div>
                </form>
            </div><!-- End Penghargaan Edit -->

        </div>
        </section>

@endsection