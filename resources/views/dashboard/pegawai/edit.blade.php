@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Pegawai | <small>Edit Pegawai</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Data Pegawai</a></li>
                            <li class="breadcrumb-item active">Edit Pegawai</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div><!-- End Pegawai create Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Pegawai create -->
            <div class="container rounded shadow p-4">
                <form action="{{ route('pegawai.update',['pegawai' => $pegawai->id]) }}" method="POST" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="row mb-3 form-group">
                        <label for="image" class="col-md-4 col-lg-3 col-form-label">1. Foto Profil</label>
                        <div class="col-md-4 col-lg-3">
                            <input type="hidden" name="oldImage" value="{{ $pegawai->image }}">
                            <input name="image" type="file" class="form-control @error('image') is-invalid @enderror" id="image">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="nip" class="col-md-4 col-lg-3 col-form-label">2. NIP</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="nip" type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" value="{{ old('nip') ?? $pegawai->nip }}" required>
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3 form-group">
                        <label for="nip_lama" class="col-md-4 col-lg-3 col-form-label">3. NIP Lama</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="nip_lama" type="text" class="form-control @error('nip_lama') is-invalid @enderror" id="nip_lama" value="{{ old('nip_lama') ?? $pegawai->nip_lama }}" required>
                            @error('nip_lama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3 form-group">
                        <label for="no_karpeg" class="col-md-4 col-lg-3 col-form-label">4. No. Karpeg</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="no_karpeg" type="text" class="form-control @error('no_karpeg') is-invalid @enderror" id="no_karpeg" value="{{ old('no_karpeg') ?? $pegawai->no_karpeg }}">
                            @error('no_karpeg')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3 form-group">
                        <label for="no_kpe" class="col-md-4 col-lg-3 col-form-label">5. No. KPE</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="no_kpe" type="text" class="form-control @error('no_kpe') is-invalid @enderror" id="no_kpe" value="{{ old('no_kpe') ?? $pegawai->no_kpe }}">
                            @error('no_kpe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3 form-group">
                        <label for="no_ktp" class="col-md-4 col-lg-3 col-form-label">6. a. No. KTP</label>
                        <div class="col-md-4 col-lg-3">
                            <input name="no_ktp" type="text" class="form-control @error('no_ktp') is-invalid @enderror" id="no_ktp" value="{{ old('no_ktp') ?? $pegawai->no_ktp }}" required>
                            @error('no_ktp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <label for="no_npwp" class="col-md-2 col-lg-1 col-form-label">b. No. NPWP</label>
                        <div class="col-md-4 col-lg-3 gx-0">
                            <input name="no_npwp" type="text" class="form-control @error('no_npwp') is-invalid @enderror" id="no_npwp" value="{{ old('no_npwp') ?? $pegawai->no_npwp }}">
                            @error('no_npwp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="nama" class="col-md-4 col-lg-3 col-form-label">7. Nama Lengkap</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') ?? $pegawai->nama }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label class="col-md-4 col-lg-3 col-form-label">8. Gelar Kesarjanaan</label>
                        <div class="col-md-4 col-lg-3">
                            <input name="gelar_depan" type="text" class="form-control" id="gelar_depan"  value="{{ old('gelar_depan') ?? $pegawai->gelar_depan }}">
                        </div>
                        <label for="gelar_depan" class="col-md-2 col-lg-1 col-form-label">(Gelar Depan)</label>
                        <div class="col-md-4 col-lg-3">
                            <input name="gelar_belakang" type="text" class="form-control @error('gelar_belakang') is-invalid @enderror" id="gelar_belakang" value="{{ old('gelar_belakang') ?? $pegawai->gelar_belakang }}">
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
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <button class="btn btn-outline-secondary" type="button" for="tanggal_lahir" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="jenis_kelamin" class="col-md-4 col-lg-3 col-form-label">10. Jenis Kelamin</label>
                        <div class="col-md-4 col-lg-3">
                            <select class="form-select" aria-label="Default select example" name="jenis_kelamin" id="jenis_kelamin" required>
                                <option selected disabled>...</option>
                                <option value="Laki-laki" {{ (old('jenis_kelamin') ?? $pegawai->jenis_kelamin)=='Laki-laki' ? 'selected': '' }} >1. Laki-laki</option>
                                <option value="Perempuan" {{ (old('jenis_kelamin') ?? $pegawai->jenis_kelamin)=='Perempuan' ? 'selected': '' }} >2. Perempuan</option>
                            </select>
                        </div>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="agama" class="col-md-4 col-lg-3 col-form-label">11. Agama</label>
                        <div class="col-md-4 col-lg-3">
                            <select class="form-select" aria-label="Default select example" name="agama" id="agama" required>
                                <option selected disabled>...</option>
                                <option value="Islam" {{ (old('agama') ?? $pegawai->agama)=='Islam' ? 'selected': '' }} >1. Islam</option>
                                <option value="Protestan" {{ (old('agama') ?? $pegawai->agama)=='Protestan' ? 'selected': '' }} >2. Protestan</option>
                                <option value="Khatolik" {{ (old('agama') ?? $pegawai->agama)=='Khatolik' ? 'selected': '' }} >3. Khatolik</option>
                                <option value="Hindu" {{ (old('agama') ?? $pegawai->agama)=='Hindu' ? 'selected': '' }} >4. Hindu</option>
                                <option value="Budha" {{ (old('agama') ?? $pegawai->agama)=='Budha' ? 'selected': '' }} >5. Budha</option>
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
                                <option value="Sudah Kawin" {{ (old('status_nikah') ?? $pegawai->status_nikah)=='Sudah Kawin' ? 'selected': '' }} >1. Sudah Kawin</option>
                                <option value="Belum" {{ (old('status_nikah') ?? $pegawai->status_nikah)=='Belum' ? 'selected': '' }} >2. Belum</option>
                                <option value="Janda" {{ (old('status_nikah') ?? $pegawai->status_nikah)=='Janda' ? 'selected': '' }} >3. Janda</option>
                                <option value="Duda" {{ (old('status_nikah') ?? $pegawai->status_nikah)=='Duda' ? 'selected': '' }} >4. Duda</option>
                            </select>
                            @error('status_nikah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="alamat" class="col-md-4 col-lg-3 col-form-label">13. Alamat</label>
                        <div class="col-md-8 col-lg-9">
                            <textarea name="alamat" class="form-control" id="alamat" style="height: 100px" required>{{ old('alamat')  ?? $pegawai->alamat }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="telepon" class="col-md-4 col-lg-3 col-form-label">14. Telepon</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="telepon" type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" value="{{ old('telepon') ?? $pegawai->telepon }}"  required>
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="tingkat_pendidikan" class="col-md-4 col-lg-3 col-form-label">15. Tingkat Pendidikan</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="tingkat_pendidikan" type="text" class="form-control @error('tingkat_pendidikan') is-invalid @enderror" id="tingkat_pendidikan" value="{{ old('tingkat_pendidikan') ?? $pegawai->tingkat_pendidikan }}">
                            @error('tingkat_pendidikan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="nama_pendidikan" class="col-md-4 col-lg-3 col-form-label">16. Nama Pendidikan</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="nama_pendidikan" type="text" class="form-control @error('nama_pendidikan') is-invalid @enderror" id="nama_pendidikan" value="{{ old('nama_pendidikan') ?? $pegawai->nama_pendidikan }}">
                            @error('nama_pendidikan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="nama_sekolah" class="col-md-4 col-lg-3 col-form-label">17. Nama Sekolah</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="nama_sekolah" type="text" class="form-control @error('nama_sekolah') is-invalid @enderror" id="nama_sekolah" value="{{ old('nama_sekolah') ?? $pegawai->nama_sekolah }}">
                            @error('nama_sekolah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="tahun_lulus" class="col-md-4 col-lg-3 col-form-label">18. Tahun Lulus</label>
                        <div class="col-md-4 col-lg-3">
                            <div class="input-group">
                                <input name="tahun_lulus" type="text" class="form-control @error('tahun_lulus') is-invalid @enderror" id="tahun_lulus" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tahun_lulus') ?? $pegawai->tahun_lulus }}">
                                <button class="btn btn-outline-secondary" type="button" for="tahun_lulus" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                @error('tahun_lulus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="pangkat" class="col-md-4 col-lg-3 col-form-label">19. Pangkat</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="pangkat" type="text" class="form-control @error('pangkat') is-invalid @enderror" id="pangkat" value="{{ old('pangkat') ?? $pegawai->pangkat }}">
                            @error('pangkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="row mb-3 form-group">
                        <label for="golongan_ruang" class="col-md-4 col-lg-3 col-form-label">20. Golongan Ruang</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="golongan_ruang" type="text" class="form-control @error('golongan_ruang') is-invalid @enderror" id="golongan_ruang" value="{{ old('golongan_ruang') ?? $pegawai->golongan_ruang }}">
                            @error('golongan_ruang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="tmt_golongan_ruang" class="col-md-4 col-lg-3 col-form-label">21. TMT Golongan Ruang</label>
                        <div class="col-md-4 col-lg-3">
                            <div class="input-group">
                                <input name="tmt_golongan_ruang" type="text" class="form-control @error('tmt_golongan_ruang') is-invalid @enderror" id="tmt_golongan_ruang" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tmt_golongan_ruang') ?? $pegawai->tmt_golongan_ruang }}">
                                <button class="btn btn-outline-secondary" type="button" for="tmt_golongan_ruang" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                @error('tmt_golongan_ruang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="golongan_ruang_cpns" class="col-md-4 col-lg-3 col-form-label">22. Golongan Ruang CPNS</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="golongan_ruang_cpns" type="text" class="form-control @error('golongan_ruang_cpns') is-invalid @enderror" id="golongan_ruang_cpns" value="{{ old('golongan_ruang_cpns') ?? $pegawai->golongan_ruang_cpns }}">
                            @error('golongan_ruang_cpns')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="tmt_golongan_ruang_cpns" class="col-md-4 col-lg-3 col-form-label">23. TMT Golongan Ruang CPNS</label>
                        <div class="col-md-4 col-lg-3">
                            <div class="input-group">
                                <input name="tmt_golongan_ruang_cpns" type="text" class="form-control @error('tmt_golongan_ruang_cpns') is-invalid @enderror" id="tmt_golongan_ruang_cpns" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tmt_golongan_ruang_cpns') ?? $pegawai->tmt_golongan_ruang_cpns }}">
                                <button class="btn btn-outline-secondary" type="button" for="tmt_golongan_ruang_cpns" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                @error('tmt_golongan_ruang_cpns')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="tmt_pns" class="col-md-4 col-lg-3 col-form-label">24. TMT PNS</label>
                        <div class="col-md-4 col-lg-3">
                            <div class="input-group">
                                <input name="tmt_pns" type="text" class="form-control @error('tmt_pns') is-invalid @enderror" id="tmt_pns" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tmt_pns') ?? $pegawai->tmt_pns }}">
                                <button class="btn btn-outline-secondary" type="button" for="tmt_pns" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                @error('tmt_pns')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="jenis_kepegawaian" class="col-md-4 col-lg-3 col-form-label">25. Jenis Kepegawaian</label>
                        <div class="col-md-4 col-lg-3">
                            <select class="form-select" aria-label="Default select example" name="jenis_kepegawaian" id="jenis_kepegawaian" required>
                                <option selected disabled>...</option>
                                <option value="PNS" {{ (old('jenis_kepegawaian') ?? $pegawai->jenis_kepegawaian ) =='PNS' ? 'selected': '' }} >1. PNS</option>
                                <option value="PPPK" {{ (old('jenis_kepegawaian') ?? $pegawai->jenis_kepegawaian )=='PPPK' ? 'selected': '' }} >2. PPPK</option>
                                <option value="CPNS" {{ (old('jenis_kepegawaian') ?? $pegawai->jenis_kepegawaian )=='CPNS' ? 'selected': '' }} >3. CPNS</option>
                                <option value="BLUD" {{ (old('jenis_kepegawaian') ?? $pegawai->jenis_kepegawaian )=='BLUD' ? 'selected': '' }} >4. BLUD</option>
                            </select>
                        </div>
                        @error('jenis_kepegawaian')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row mb-3 form-group">
                        <label for="status_hukum" class="col-md-4 col-lg-3 col-form-label">26. Status Hukum</label>
                        <div class="col-md-4 col-lg-3">
                            <select class="form-select" aria-label="Default select example" name="status_hukum" id="status_hukum">
                                <option selected disabled>...</option>
                                <option value="Aktif" {{ (old('status_hukum') ?? $pegawai->status_hukum )=='Aktif' ? 'selected': '' }} >1. Aktif</option>
                                <option value="CLTN" {{ (old('status_hukum') ?? $pegawai->status_hukum )=='CLTN' ? 'selected': '' }} >2. CLTN</option>
                                <option value="Tugas Belajar" {{ (old('status_hukum') ?? $pegawai->status_hukum )=='Tugas Belajar' ? 'selected': '' }} >3. Tugas Belajar</option>
                                <option value="Pemberhentian sementara" {{ (old('status_hukum') ?? $pegawai->status_hukum )=='Pemberhentian sementara' ? 'selected': '' }} >4. Pemberhentian sementara</option>
                                <option value="Penerima Uang Tunggu" {{ (old('status_hukum') ?? $pegawai->status_hukum )=='Penerima Uang Tunggu' ? 'selected': '' }} >5. Penerima Uang Tunggu</option>
                                <option value="Wajib Militer" {{ (old('status_hukum') ?? $pegawai->status_hukum )=='Wajib Militer' ? 'selected': '' }} >6. Wajib Militer</option>
                                <option value="Pejabat Negara" {{ (old('status_hukum') ?? $pegawai->status_hukum )=='Pejabat Negara' ? 'selected': '' }} >7. Pejabat Negara</option>
                                <option value="Kepala Desa" {{ (old('status_hukum') ?? $pegawai->status_hukum )=='Kepala Desa' ? 'selected': '' }} >8. Kepala Desa</option>
                                <option value="Proses Banding BAPEK" {{ (old('status_hukum') ?? $pegawai->status_hukum )=='Proses Banding BAPEK' ? 'selected': '' }} >9. Proses Banding BAPEK</option>
                                <option value="Masa Persiapan Pensiun" {{ (old('status_hukum') ?? $pegawai->status_hukum )=='Masa Persiapan Pensiun' ? 'selected': '' }} >10. Masa Persiapan Pensiun</option>
                                <option value="Pensiun" {{ (old('status_hukum') ?? $pegawai->status_hukum )=='Pensiun' ? 'selected': '' }} >11. Pensiun</option>
                                <option value="Calon CPNS" {{ (old('status_hukum') ?? $pegawai->status_hukum )=='Calon CPNS' ? 'selected': '' }} >12. Calon CPNS</option>
                            </select>
                        </div>
                        @error('status_hukum')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="skpd" class="col-md-4 col-lg-3 col-form-label">27. SKPD</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="skpd" type="text" class="form-control @error('skpd') is-invalid @enderror" id="skpd" value="{{ old('skpd') ?? $pegawai->skpd }}">
                            @error('skpd')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label for="jenis_jabatan" class="col-md-4 col-lg-3 col-form-label">27. Jenis Jabatan</label>
                        <div class="col-md-4 col-lg-3">
                            <select class="form-select" aria-label="Default select example" name="jenis_jabatan" id="jenis_jabatan">
                                <option selected disabled>...</option>
                                <option value="Struktural" {{ (old('jenis_jabatan') ?? $pegawai->jenis_jabatan )=='Struktural' ? 'selected': '' }} >1. Struktural</option>
                                <option value="Fungsional Khusus" {{ (old('jenis_jabatan') ?? $pegawai->jenis_jabatan )=='Fungsional Khusus' ? 'selected': '' }} >2. Fungsional Khusus</option>
                                <option value="Fungsional Umum" {{ (old('jenis_jabatan') ?? $pegawai->jenis_jabatan )=='Fungsional Umum' ? 'selected': '' }} >3. Fungsional Umum</option>
                                <option value="Sekretaris Desa" {{ (old('jenis_jabatan') ?? $pegawai->jenis_jabatan )=='Sekretaris Desa' ? 'selected': '' }} >4. Sekretaris Desa</option>
                            </select>
                        </div>
                        @error('jenis_jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row mb-3 form-group">
                        <label for="jabatan_fungsional" class="col-md-4 col-lg-3 col-form-label">29. Jabatan Fungsional</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="jabatan_fungsional" type="text" class="form-control @error('jabatan_fungsional') is-invalid @enderror" id="jabatan_fungsional" value="{{ old('jabatan_fungsional') ?? $pegawai->jabatan_fungsional }}">
                            @error('JabatanFungsional')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3 form-group">
                        <label for="tmt_jabatan" class="col-md-4 col-lg-3 col-form-label">30. TMT Jabatan</label>
                        <div class="col-md-4 col-lg-3">
                            <div class="input-group">
                                <input name="tmt_jabatan" type="text" class="form-control @error('tmt_jabatan') is-invalid @enderror" id="tmt_jabatan" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tmt_jabatan') ?? $pegawai->tmt_jabatan }}">
                                <button class="btn btn-outline-secondary" type="button" for="tmt_jabatan" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                @error('tmt_jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3 form-group">
                        <label for="diklat_pimpinan" class="col-md-4 col-lg-3 col-form-label">31. Diklat Pimpinan</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="diklat_pimpinan" type="text" class="form-control @error('diklat_pimpinan') is-invalid @enderror" id="diklat_pimpinan" value="{{ old('diklat_pimpinan') ?? $pegawai->diklat_pimpinan }}">
                            @error('diklat_pimpinan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3 form-group">
                        <label for="tahun_diklat_pimpinan" class="col-md-4 col-lg-3 col-form-label">32. Tahun Diklat Pimpinan</label>
                        <div class="col-md-4 col-lg-3">
                            <div class="input-group">
                                <input name="tahun_diklat_pimpinan" type="text" class="form-control @error('tahun_diklat_pimpinan') is-invalid @enderror" id="tahun_diklat_pimpinan" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tahun_diklat_pimpinan') ?? $pegawai->tahun_diklat_pimpinan }}">
                                <button class="btn btn-outline-secondary" type="button" for="tahun_diklat_pimpinan" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                @error('tahun_diklat_pimpinan')
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
                            <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-90deg-left"></i> cancel</a>
                        </div>
                    </div>
                </form>
            </div><!-- End Pegawai Edit -->

        </div>
        </section>

@endsection