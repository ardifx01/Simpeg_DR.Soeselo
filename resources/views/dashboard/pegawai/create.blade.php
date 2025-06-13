@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Pegawai | <small>Create Pegawai</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Data Pegawai</a></li>
                            <li class="breadcrumb-item active">Create Pegawai</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div><!-- End Pegawai create Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Pegawai create -->
            <div class="container rounded shadow p-4">
                <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3 form-group">
                        <label for="image" class="col-md-6 col-lg-3 col-form-label">1. Foto Profil</label>
                        <div class="col-md-6 col-lg-4">
                            <input name="image" type="file" class="form-control @error('image') is-invalid @enderror" id="image">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="nip" class="col-md-4 col-lg-3 col-form-label">2. NIP</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="nip" type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" value="{{ old('nip') }}">
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3 form-group">
                        <label for="nip_lama" class="col-md-4 col-lg-3 col-form-label">3. NIP Lama</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="nip_lama" type="text" class="form-control @error('nip_lama') is-invalid @enderror" id="nip_lama" value="{{ old('nip_lama') }}">
                            @error('nip_lama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3 form-group">
                        <label for="no_karpeg" class="col-md-4 col-lg-3 col-form-label">4. No. Karpeg</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="no_karpeg" type="text" class="form-control @error('no_karpeg') is-invalid @enderror" id="no_karpeg" value="{{ old('no_karpeg') }}">
                            @error('no_karpeg')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3 form-group">
                        <label for="no_kpe" class="col-md-4 col-lg-3 col-form-label">5. No. KPE</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="no_kpe" type="text" class="form-control @error('no_kpe') is-invalid @enderror" id="no_kpe" value="{{ old('no_kpe') }}">
                            @error('no_kpe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3 form-group">
                        <label for="no_ktp" class="col-md-4 col-lg-3 col-form-label">6. a. No. KTP</label>
                        <div class="col-md-4 col-lg-4">
                            <input name="no_ktp" type="text" class="form-control @error('no_ktp') is-invalid @enderror" id="no_ktp" value="{{ old('no_ktp') }}">
                            @error('no_ktp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <label for="no_npwp" class="col-md-2 col-lg-1 col-form-label">b. No. NPWP</label>
                        <div class="col-md-4 col-lg-4">
                            <input name="no_npwp" type="text" class="form-control @error('no_npwp') is-invalid @enderror" id="no_npwp" value="{{ old('no_npwp') }}">
                            @error('no_npwp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="nama" class="col-md-4 col-lg-3 col-form-label">7. Nama Lengkap</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label class="col-md-4 col-lg-3 col-form-label">8. Gelar Kesarjanaan</label>
                        <div class="col-md-4 col-lg-3">
                            <input name="gelar_depan" type="text" class="form-control" id="gelar_depan"  value="{{ old('gelar_depan') }}">
                        </div>
                        <label for="gelar_depan" class="col-md-2 col-lg-1 col-form-label">(Gelar Depan)</label>
                        <div class="col-md-4 col-lg-3">
                            <input name="gelar_belakang" type="text" class="form-control @error('gelar_belakang') is-invalid @enderror" id="gelar_belakang" value="{{ old('gelar_belakang') }}">
                            @error('gelar_belakang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <label for="gelar_belakang" class="col-md-2 col-lg-2 col-form-label">(Gelar Belakang)</label>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="tempat_lahir" class="col-md-4 col-lg-3 col-form-label">9. Tempat, Tanggal Lahir</label>
                        <div class="col-md-4 col-lg-3">
                            <input name="tempat_lahir" type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" value="{{ old('tempat_lahir') }}">
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="input-group">
                                <input name="tanggal_lahir" type="text" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tanggal_lahir') }}">
                                <button class="btn btn-outline-secondary" type="button" for="tanggal_lahir" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="jenis_kelamin" class="col-md-4 col-lg-3 col-form-label">10. Jenis Kelamin</label>
                        <div class="col-md-4 col-lg-3">
                            <select class="form-select" aria-label="Default select example" name="jenis_kelamin" id="jenis_kelamin">
                                <option selected disabled>...</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin')=='Laki-laki' ? 'selected': '' }} >1. Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin')=='Perempuan' ? 'selected': '' }} >2. Perempuan</option>
                            </select>
                        </div>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="agama" class="col-md-4 col-lg-3 col-form-label">11. Agama</label>
                        <div class="col-md-4 col-lg-3">
                            <select class="form-select" aria-label="Default select example" name="agama" id="agama">
                                <option selected disabled>...</option>
                                <option value="Islam" {{ old('agama')=='Islam' ? 'selected': '' }} >1. Islam</option>
                                <option value="Protestan" {{ old('agama')=='Protestan' ? 'selected': '' }} >2. Protestan</option>
                                <option value="Khatolik" {{ old('agama')=='Khatolik' ? 'selected': '' }} >3. Khatolik</option>
                                <option value="Hindu" {{ old('agama')=='Hindu' ? 'selected': '' }} >4. Hindu</option>
                                <option value="Budha" {{ old('agama')=='Budha' ? 'selected': '' }} >5. Budha</option>
                            </select>
                        </div>
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="status_nikah" class="col-md-4 col-lg-3 col-form-label">12. Status Perkawinan</label>
                        <div class="col-md-4 col-lg-3">
                            <select class="form-select" aria-label="Default select example" name="status_nikah" id="status_nikah">
                                <option selected disabled>...</option>
                                <option value="Sudah Kawin" {{ old('status_nikah')=='Sudah Kawin' ? 'selected': '' }} >1. Sudah Kawin</option>
                                <option value="Belum" {{ old('status_nikah')=='Belum' ? 'selected': '' }} >2. Belum</option>
                                <option value="Janda" {{ old('status_nikah')=='Janda' ? 'selected': '' }} >3. Janda</option>
                                <option value="Duda" {{ old('status_nikah')=='Duda' ? 'selected': '' }} >4. Duda</option>
                            </select>
                            @error('status_nikah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="alamat" class="col-md-4 col-lg-3 col-form-label">13. Alamat</label>
                        <div class="col-md-8 col-lg-9">
                            <textarea name="alamat" class="form-control" id="alamat" style="height: 100px">{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="rt" class="col-md-4 col-lg-3 col-form-label">RT</label>
                        <div class="col-md-4 col-lg-3">
                            <input name="rt" type="text" class="form-control @error('rt') is-invalid @enderror" id="rt" value="{{ old('rt') }}">
                            @error('rt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <label for="rw" class="col-md-2 col-lg-1 col-form-label">RW</label>
                        <div class="col-md-4 col-lg-3">
                            <input name="rw" type="text" class="form-control @error('rw') is-invalid @enderror" id="rw" value="{{ old('rw') }}">
                            @error('rw')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3 form-group">
                        <label for="desa" class="col-md-4 col-lg-3 col-form-label">Desa</label>
                        <div class="col-md-4 col-lg-3">
                            <input name="desa" type="text" class="form-control @error('desa') is-invalid @enderror" id="desa" value="{{ old('desa') }}">
                            @error('desa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <label for="kecamatan" class="col-md-2 col-lg-1 col-form-label">Kecamatan</label>
                        <div class="col-md-4 col-lg-3">
                            <input name="kecamatan" type="text" class="form-control @error('kecamatan') is-invalid @enderror" id="kecamatan" value="{{ old('kecamatan') }}">
                            @error('kecamatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3 form-group">
                        <label for="kabupaten" class="col-md-4 col-lg-3 col-form-label">Kabupaten</label>
                        <div class="col-md-4 col-lg-3">
                            <input name="kabupaten" type="text" class="form-control @error('kabupaten') is-invalid @enderror" id="kabupaten" value="{{ old('kabupaten') }}">
                            @error('kabupaten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <label for="provinsi" class="col-md-2 col-lg-1 col-form-label">Provinsi</label>
                        <div class="col-md-4 col-lg-3">
                            <input name="provinsi" type="text" class="form-control @error('provinsi') is-invalid @enderror" id="provinsi" value="{{ old('provinsi') }}">
                            @error('provinsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3 form-group">
                        <label for="pos" class="col-md-4 col-lg-3 col-form-label">Kode POS</label>
                        <div class="col-md-4 col-lg-3">
                            <input name="pos" type="text" class="form-control @error('pos') is-invalid @enderror" id="pos" value="{{ old('pos') }}">
                            @error('pos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="telepon" class="col-md-4 col-lg-3 col-form-label">14. Telepon</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="telepon" type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" value="{{ old('telepon') }}" >
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="golongan_ruang" class="col-md-4 col-lg-3 col-form-label">15. Golongan Ruang</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="golongan_ruang" type="text" class="form-control @error('golongan_ruang') is-invalid @enderror" id="golongan_ruang" value="{{ old('golongan_ruang') }}">
                            @error('golongan_ruang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="tmt_golongan_ruang" class="col-md-4 col-lg-3 col-form-label">16. TMT Golongan Ruang</label>
                        <div class="col-md-4 col-lg-3">
                            <div class="input-group">
                                <input name="tmt_golongan_ruang" type="text" class="form-control @error('tmt_golongan_ruang') is-invalid @enderror" id="tmt_golongan_ruang" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tmt_golongan_ruang') }}">
                                <button class="btn btn-outline-secondary" type="button" for="tmt_golongan_ruang" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                @error('tmt_golongan_ruang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="golongan_ruang_cpns" class="col-md-4 col-lg-3 col-form-label">17. Golongan Ruang CPNS</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="golongan_ruang_cpns" type="text" class="form-control @error('golongan_ruang_cpns') is-invalid @enderror" id="golongan_ruang_cpns" value="{{ old('golongan_ruang_cpns') }}">
                            @error('golongan_ruang_cpns')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="tmt_golongan_ruang_cpns" class="col-md-4 col-lg-3 col-form-label">18. TMT Golongan Ruang CPNS</label>
                        <div class="col-md-4 col-lg-3">
                            <div class="input-group">
                                <input name="tmt_golongan_ruang_cpns" type="text" class="form-control @error('tmt_golongan_ruang_cpns') is-invalid @enderror" id="tmt_golongan_ruang_cpns" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tmt_golongan_ruang_cpns') }}">
                                <button class="btn btn-outline-secondary" type="button" for="tmt_golongan_ruang_cpns" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                @error('tmt_golongan_ruang_cpns')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="tmt_pns" class="col-md-4 col-lg-3 col-form-label">19. TMT PNS</label>
                        <div class="col-md-4 col-lg-3">
                            <div class="input-group">
                                <input name="tmt_pns" type="text" class="form-control @error('tmt_pns') is-invalid @enderror" id="tmt_pns" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tmt_pns') }}">
                                <button class="btn btn-outline-secondary" type="button" for="tmt_pns" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                @error('tmt_pns')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="text-center p-2">
                            <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Tambah</button>
                        </div>
                        <div class="text-center p-2">
                            <a href="{{ route('pegawai.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-90deg-left"></i> cancel</a>
                        </div>
                    </div>
                </form>
            </div><!-- End Pegawai Create -->

        </div>
        </section>

@endsection