@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Jabatan | <small>Tambah Jabatan</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('jabatan.index') }}">Riwayat Jabatan</a></li>
                            <li class="breadcrumb-item active">Tambah Jabatan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div><!-- End Jabatan Update Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Fiklat Jabatan Update -->
            <div class="container rounded shadow p-4">
                <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST">
                    @csrf
                    @method("PUT")
                    <div class="row mb-3">
                        <div class="row mb-3">
                            <label for="Pegawai" class="col-md-4 col-lg-3 col-form-label">1. Pegawai</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select" aria-label="Default select example" name="pegawai_id" id="pegawai_id" require>
                                    <option selected disabled>-- Pilih Pegawai --</option>
                                    @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ $jabatan->pegawai_id == $pegawai->id ? 'selected' : '' }}>
                                        {{ $pegawai->nip }} - {{ $pegawai->nama }}
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Nama" class="col-md-4 col-lg-3 col-form-label">2. Nama Jabatan</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') ?? $jabatan->nama }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="skpd" class="col-md-4 col-lg-3 col-form-label">3. SKPD</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="skpd" type="text" class="form-control @error('skpd') is-invalid @enderror" id="skpd" value="{{ old('skpd') ?? $jabatan->skpd }}" required>
                                @error('skpd')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tmt" class="col-md-4 col-lg-3 col-form-label">4. TMT</label>
                            <div class="col-md-4 col-lg-3">
                                <input name="tmt" type="text" class="form-control @error('tmt') is-invalid @enderror" id="tmt" value="{{ old('tmt') ?? $jabatan->tmt }}" required>
                                @error('tmt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        

                        <div class="row mb-3">
                            <label for="eselon" class="col-md-4 col-lg-3 col-form-label">5. Eselon</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-select" aria-label="Default select example" name="eselon" id="eselon" required>
                                    <option selected>...</option>
                                    <option value="V" {{ (old('eselon') ?? $jabatan->eselon)=='V' ? 'selected': '' }} >V</option>
                                    <option value="IV.b" {{ (old('eselon') ?? $jabatan->eselon)=='IV.b' ? 'selected': '' }} >IV.b</option>
                                    <option value="IV.a" {{ (old('eselon') ?? $jabatan->eselon)=='IV.a' ? 'selected': '' }} >IV.a</option>
                                    <option value="III.b" {{ (old('eselon') ?? $jabatan->eselon)=='III.b' ? 'selected': '' }} >III.b</option>
                                    <option value="III.a" {{ (old('eselon') ?? $jabatan->eselon)=='III.a' ? 'selected': '' }} >III.a</option>
                                    <option value="II.b" {{ (old('eselon') ?? $jabatan->eselon)=='II.b' ? 'selected': '' }} >II.b</option>
                                    <option value="II.a" {{ (old('eselon') ?? $jabatan->eselon)=='II.a' ? 'selected': '' }} >II.a</option>
                                </select>
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
            </div><!-- End Jabatan Update -->

        </div>
        </section>

@endsection