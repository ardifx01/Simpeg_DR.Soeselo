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
        </div><!-- End Pegawai Edit Title -->

        <section class="section dashboard">
            <div class="row">
                <!-- Pegawai Edit -->
                <div class="container rounded shadow p-4">
                    <form action="{{ route('pegawai.update',['pegawai' => $pegawai->id]) }}" method="POST" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="row mb-3 form-group">
                            <label for="image" class="col-md-4 col-lg-3 col-form-label">1. Foto Profil</label>
                            <div class="col-md-4 col-lg-4 d-flex flex-column align-items-center">
                                <img id="preview-image" src="{{ $pegawai->image ? asset('storage/' . $pegawai->image) : asset('assets/img/nophoto.jpg') }}" alt="Foto Pegawai" class="rounded mb-2" style="width: 150px; height: 200px; object-fit: cover; border:1px solid #ccc;">
                                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" accept="image/*" onchange="previewGambar(event)">
                                @error('image')
                                    <div class="text-danger mt-2">{{ $message }}</div>
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
                            <div class="col-md-4 col-lg-4">
                                <input name="no_ktp" type="text" class="form-control @error('no_ktp') is-invalid @enderror" id="no_ktp" value="{{ old('no_ktp') ?? $pegawai->no_ktp }}" required>
                                @error('no_ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="no_npwp" class="col-md-2 col-lg-1 col-form-label">b. No. NPWP</label>
                            <div class="col-md-4 col-lg-4">
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
                                <input name="tempat_lahir" type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" value="{{ old('tempat_lahir') ?? $pegawai->tempat_lahir }}">
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <div class="input-group">
                                    @php
                                        $tanggalLahir = old('tanggal_lahir') ?? ($pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d-m-Y') : '');
                                    @endphp
                                    <input name="tanggal_lahir" type="text" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" value="{{ $tanggalLahir }}">
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <button class="btn btn-outline-secondary" type="button" for="tanggal_lahir" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 form-group">
                            <label class="col-md-4 col-lg-3 col-form-label">Jenis Kelamin</label>
                            <div class="col-md-8 col-lg-9 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="laki_laki" value="Laki-laki"
                                        {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="laki_laki">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan"
                                        {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 form-group">
                            <label for="agama" class="col-md-4 col-lg-3 col-form-label">11. Agama</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-select" aria-label="Default select example" name="agama" id="agama" required>
                                    <option selected disabled>...</option>
                                    <option value="Islam" {{ (old('agama') ?? $pegawai->agama)=='Islam' ? 'selected': '' }} >Islam</option>
                                    <option value="Protestan" {{ (old('agama') ?? $pegawai->agama)=='Protestan' ? 'selected': '' }} >Protestan</option>
                                    <option value="Khatolik" {{ (old('agama') ?? $pegawai->agama)=='Khatolik' ? 'selected': '' }} >Khatolik</option>
                                    <option value="Hindu" {{ (old('agama') ?? $pegawai->agama)=='Hindu' ? 'selected': '' }} >Hindu</option>
                                    <option value="Budha" {{ (old('agama') ?? $pegawai->agama)=='Budha' ? 'selected': '' }} >Budha</option>
                                </select>
                                @error('agama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 form-group">
                            <label for="status_nikah" class="col-md-4 col-lg-3 col-form-label">12. Status Perkawinan</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-select" aria-label="Default select example" name="status_nikah" id="status_nikah">
                                    <option selected disabled>...</option>
                                    <option value="Sudah Kawin" {{ (old('status_nikah') ?? $pegawai->status_nikah)=='Sudah Kawin' ? 'selected': '' }} >Sudah Kawin</option>
                                    <option value="Belum" {{ (old('status_nikah') ?? $pegawai->status_nikah)=='Belum' ? 'selected': '' }} >Belum</option>
                                    <option value="Janda" {{ (old('status_nikah') ?? $pegawai->status_nikah)=='Janda' ? 'selected': '' }} >Janda</option>
                                    <option value="Duda" {{ (old('status_nikah') ?? $pegawai->status_nikah)=='Duda' ? 'selected': '' }} >Duda</option>
                                </select>
                                @error('status_nikah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 form-group">
                            <label for="alamat" class="col-md-4 col-lg-3 col-form-label">13. Alamat</label>
                            <div class="col-md-8 col-lg-9">
                                <textarea name="alamat" class="form-control" id="alamat" style="height: 100px">{{ old('alamat')  ?? $pegawai->alamat }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3 form-group">
                            <label for="rt" class="col-md-4 col-lg-3 col-form-label">RT</label>
                            <div class="col-md-4 col-lg-3">
                                <input name="rt" type="text" class="form-control @error('rt') is-invalid @enderror" id="rt" value="{{ old('rt')  ?? $pegawai->rt }}">
                                @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="rw" class="col-md-2 col-lg-1 col-form-label">RW</label>
                            <div class="col-md-4 col-lg-3">
                                <input name="rw" type="text" class="form-control @error('rw') is-invalid @enderror" id="rw" value="{{ old('rw')  ?? $pegawai->rw }}">
                                @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3 form-group">
                            <label for="desa" class="col-md-4 col-lg-3 col-form-label">Desa</label>
                            <div class="col-md-4 col-lg-3">
                                <input name="desa" type="text" class="form-control @error('desa') is-invalid @enderror" id="desa" value="{{ old('desa')  ?? $pegawai->desa }}">
                                @error('desa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="kecamatan" class="col-md-2 col-lg-1 col-form-label">Kecamatan</label>
                            <div class="col-md-4 col-lg-3">
                                <input name="kecamatan" type="text" class="form-control @error('kecamatan') is-invalid @enderror" id="kecamatan" value="{{ old('kecamatan')  ?? $pegawai->kecamatan }}">
                                @error('kecamatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3 form-group">
                            <label for="kabupaten" class="col-md-4 col-lg-3 col-form-label">Kabupaten</label>
                            <div class="col-md-4 col-lg-3">
                                <input name="kabupaten" type="text" class="form-control @error('kabupaten') is-invalid @enderror" id="kabupaten" value="{{ old('kabupaten')  ?? $pegawai->kabupaten }}">
                                @error('kabupaten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="provinsi" class="col-md-2 col-lg-1 col-form-label">Provinsi</label>
                            <div class="col-md-4 col-lg-3">
                                <input name="provinsi" type="text" class="form-control @error('provinsi') is-invalid @enderror" id="provinsi" value="{{ old('provinsi')  ?? $pegawai->provinsi }}">
                                @error('provinsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3 form-group">
                            <label for="pos" class="col-md-4 col-lg-3 col-form-label">Kode POS</label>
                            <div class="col-md-4 col-lg-3">
                                <input name="pos" type="text" class="form-control @error('pos') is-invalid @enderror" id="pos" value="{{ old('pos')  ?? $pegawai->pos }}">
                                @error('pos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="telepon" class="col-md-2 col-lg-1 col-form-label">Telepon</label>
                            <div class="col-md-4 col-lg-3">
                                <input name="telepon" type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" value="{{ old('telepon') ?? $pegawai->telepon }}"  required>
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            <div class="text-center p-2">
                                <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Simpan</button>
                            </div>
                            <div class="text-center p-2">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-90deg-left"></i> Batal</a>
                            </div>
                        </div>
                    </form>
                </div><!-- End Pegawai Edit -->
            </div>
        </section>
<script>
    function previewGambar(event) {
        const file = event.target.files[0];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (file && file.size > maxSize) {
            alert("Ukuran gambar maksimal 5MB!");
            event.target.value = "";
            document.getElementById('preview-image').src = "{{ $pegawai->image ? asset('storage/' . $pegawai->image) : asset('assets/img/nophoto.jpg') }}";
            return;
        }

        const reader = new FileReader();
        reader.onload = function(){
            document.getElementById('preview-image').src = reader.result;
        }
        if (file) reader.readAsDataURL(file);
    }
</script>


@endsection