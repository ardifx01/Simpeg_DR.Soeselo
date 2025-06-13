@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Ijin Belajar | <small>Ubah Ijin Belajar</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('ijinbelajar.index') }}">Riwayat Ijin Belajar</a></li>
                            <li class="breadcrumb-item active">Ubah Ijin Belajar</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div><!-- End Ijin Belajar create Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Fiklat Ijin Belajar create -->
            <div class="container rounded shadow p-4">
                <form action="{{ route('ijinbelajar.update', $ijinbelajar->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="row mb-3">
                            <label for="pegawai_id" class="col-md-4 col-lg-3 col-form-label">1. Pegawai</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select" aria-label="Default select example" name="pegawai_id" id="pegawai_id">
                                    <option selected>...</option>
                                    @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ $ijinbelajar->pegawai_id == $pegawai->id ? 'selected' : '' }}>
                                        {{ $pegawai->nip }} - {{ $pegawai->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tingkat" class="col-md-4 col-lg-3 col-form-label">2. Tingkat Pendidikan</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="tingkat" type="text" class="form-control @error('tingkat') is-invalid @enderror" id="tingkat" value="{{ old('tingkat') ?? $ijinbelajar->tingkat }}" required>
                                @error('tingkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jenis" class="col-md-4 col-lg-3 col-form-label">3. Jenis Bantuan</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-select" aria-label="Default select example" name="jenis" id="jenis">
                                    <option selected>...</option>
                                    <option value="Ijin Belajar" {{ (old('jenis') ?? $ijinbelajar->jenis)=='Ijin Belajar' ? 'selected': '' }}>1. Ijin Belajar</option>
                                    <option value="Tugas Belajar" {{ (old('jenis') ?? $ijinbelajar->jenis)=='Tugas Belajar' ? 'selected': '' }}>2. Tugas Belajar</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nama" class="col-md-4 col-lg-3 col-form-label">4. Nama Sekolah</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') ?? $ijinbelajar->nama }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tahun_lulus" class="col-md-4 col-lg-3 col-form-label">5. Tahun Lulus</label>
                            <div class="col-md-4 col-lg-3">
                                <div class="input-group mb-3">
                                    <input name="tahun_lulus" type="text" class="form-control @error('tahun_lulus') is-invalid @enderror" id="tahun_lulus" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tahun_lulus') ?? $ijinbelajar->tahun_lulus }}" required>
                                    <button class="btn btn-outline-secondary" type="button" for="tahun_lulus" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                    @error('tahun_lulus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="no_ijazah" class="col-md-4 col-lg-3 col-form-label">6. No Ijazah</label>
                            <div class="col-md-4 col-lg-3">
                                <input name="no_ijazah" type="text" class="form-control @error('no_ijazah') is-invalid @enderror" id="no_ijazah" value="{{ old('no_ijazah') ?? $ijinbelajar->no_ijazah }}" required>
                                @error('no_ijazah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tanggal_ijazah" class="col-md-4 col-lg-3 col-form-label">7. Tanggal Ijazah</label>
                            <div class="col-md-4 col-lg-3">
                                <div class="input-group mb-3">
                                    <input name="tanggal_ijazah" type="text" class="form-control @error('tanggal_ijazah') is-invalid @enderror" id="tanggal_ijazah" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tanggal_ijazah') ?? $ijinbelajar->tanggal_ijazah }}" required>
                                    <button class="btn btn-outline-secondary" type="button" for="tanggal_ijazah" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                    @error('tanggal_ijazah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
            </div><!-- End Ijin Belajar create -->

        </div>
        </section>

@endsection