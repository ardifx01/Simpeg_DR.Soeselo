<form method="POST" action="{{ route('pegawai.update', $pegawai->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <!-- Tampilan Gambar dan Tombol Ubah -->
        <div class="col-xl-3 pt-4 d-flex flex-column align-items-center">
            <img id="preview-image" src="{{ $pegawai->image ? asset('storage/' . $pegawai->image) : asset('assets/img/nophoto.jpg') }}" alt="Foto Pegawai" class="rounded mb-2" style="width: 150px; height: 200px; object-fit: cover; border:1px solid #ccc;">
            <div class="mb-3">
                <label class="btn btn-primary">
                    Pilih Foto
                    <input type="file" name="image" id="image" accept="image/*" style="display: none;" onchange="validateAndPreview(event)">
                </label>
            </div>
        </div>

        <div class="col-xl-8 mt-4 container"><small>
            
            <div class="row mb-3">
                <label for="nama_lengkap" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                <div class="col-md-8 col-lg-9">
                    <input type="text" id="nama_lengkap" class="form-control" value="{{ $pegawai->nama_lengkap }}" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                <div class="col-md-8 col-lg-9">
                    <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', $pegawai->nama) }}" oninput="updateNamaLengkap()">
                </div>
            </div>

            <div class="row mb-3">
                <label for="gelar_depan" class="col-md-4 col-lg-3 col-form-label">Gelar Depan</label>
                <div class="col-md-4 col-lg-3">
                    <input type="text" id="gelar_depan" name="gelar_depan" class="form-control" value="{{ old('gelar_depan', $pegawai->gelar_depan) }}" oninput="updateNamaLengkap()">
                </div>
                <label for="gelar_belakang" class="col-md-4 col-lg-3 col-form-label">Gelar Belakang</label>
                <div class="col-md-4 col-lg-3">
                    <input type="text" id="gelar_belakang" name="gelar_belakang" class="form-control" value="{{ old('gelar_belakang', $pegawai->gelar_belakang) }}" oninput="updateNamaLengkap()">
                </div>
            </div>

            <div class="row mb-3 form-group">
                <label for="nip" class="col-md-4 col-lg-3 col-form-label">NIP</label>
                <div class="col-md-8 col-lg-9">
                    <input name="nip" type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" value="{{ old('nip') ?? $pegawai->nip }}">
                    @error('nip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3 form-group">
                <label for="nip_lama" class="col-md-4 col-lg-3 col-form-label">NIP Lama</label>
                <div class="col-md-8 col-lg-9">
                    <input name="nip_lama" type="text" class="form-control @error('nip_lama') is-invalid @enderror" id="nip_lama" value="{{ old('nip_lama') ?? $pegawai->nip_lama }}">
                    @error('nip_lama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3 form-group">
                <label for="no_karpeg" class="col-md-4 col-lg-3 col-form-label">No. Karpeg</label>
                <div class="col-md-8 col-lg-9">
                    <input name="no_karpeg" type="text" class="form-control @error('no_karpeg') is-invalid @enderror" id="no_karpeg" value="{{ old('no_karpeg') ?? $pegawai->no_karpeg }}">
                    @error('no_karpeg')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3 form-group">
                <label for="no_kpe" class="col-md-4 col-lg-3 col-form-label">No. KPE</label>
                <div class="col-md-8 col-lg-9">
                    <input name="no_kpe" type="text" class="form-control @error('no_kpe') is-invalid @enderror" id="no_kpe" value="{{ old('no_kpe') ?? $pegawai->no_kpe }}">
                    @error('no_kpe')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3 form-group">
                <label for="no_ktp" class="col-md-4 col-lg-3 col-form-label">No. KTP</label>
                <div class="col-md-4 col-lg-3">
                    <input name="no_ktp" type="text" class="form-control @error('no_ktp') is-invalid @enderror" id="no_ktp" value="{{ old('no_ktp') ?? $pegawai->no_ktp }}">
                    @error('no_ktp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <label for="no_npwp" class="col-md-4 col-lg-3 col-form-label">No. NPWP</label>
                <div class="col-md-4 col-lg-3">
                    <input name="no_npwp" type="text" class="form-control @error('no_npwp') is-invalid @enderror" id="no_npwp" value="{{ old('no_npwp') ?? $pegawai->no_npwp }}">
                    @error('no_npwp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3 form-group">
                <label for="tempat_lahir" class="col-md-4 col-lg-3 col-form-label">Tempat Lahir</label>
                <div class="col-md-4 col-lg-3">
                    <input name="tempat_lahir" type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" value="{{ old('tempat_lahir') ?? $pegawai->tempat_lahir }}">
                    @error('tempat_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <label for="tanggal_lahir" class="col-md-4 col-lg-3 col-form-label">Tanggal Lahir</label>
                <div class="col-md-4 col-lg-3">
                    <div class="input-group">
                        @php
                            $tanggalLahir = old('tanggal_lahir') ?? ($pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d-m-Y') : '');
                        @endphp
                        <input name="tanggal_lahir" type="text" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" value="{{ $tanggalLahir }}">
                        <button class="btn btn-outline-secondary" type="button" for="tanggal_lahir" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                <label for="agama" class="col-md-4 col-lg-3 col-form-label">Agama</label>
                <div class="col-md-4 col-lg-3">
                    <select class="form-select" aria-label="Default select example" name="agama" id="agama" required>
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
                <label for="status_nikah" class="col-md-4 col-lg-3 col-form-label">Status Perkawinan</label>
                <div class="col-md-4 col-lg-3">
                    <select class="form-select" aria-label="Default select example" name="status_nikah" id="status_nikah">
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
                <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
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
                <label for="rw" class="col-md-4 col-lg-3 col-form-label">RW</label>
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
                <label for="kecamatan" class="col-md-4 col-lg-3 col-form-label">Kecamatan</label>
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
                <label for="provinsi" class="col-md-4 col-lg-3 col-form-label">Provinsi</label>
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
                <label for="telepon" class="col-md-4 col-lg-3 col-form-label">Telepon</label>
                <div class="col-md-4 col-lg-3">
                    <input name="telepon" type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" value="{{ old('telepon')  ?? $pegawai->telepon }}">
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mt-4 mb-3">
                <div class="col text-center">
                    <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Simpan Perubahan</button>
                </div>
            </div>
            </small>
        </div>
    </div>
</form>

<script>
function validateAndPreview(event) {
    const file = event.target.files[0];
    const maxSize = 5 * 1024 * 1024; // 5 MB

    if (file && file.size > maxSize) {
        alert("Ukuran file melebihi 5MB. Silakan pilih file yang lebih kecil.");
        event.target.value = ""; // reset input
        document.getElementById('preview-image').src = "{{ asset('assets/img/nophoto.jpg') }}";
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('preview-image').src = e.target.result;
    };
    if (file) {
        reader.readAsDataURL(file);
    }
}

function updateNamaLengkap() {
    const depan = document.getElementById('gelar_depan').value.trim();
    const nama = document.getElementById('nama').value.trim();
    const belakang = document.getElementById('gelar_belakang').value.trim();

    let hasil = nama;

    if (depan) {
        hasil = `${depan} ${hasil}`;
    }

    if (belakang) {
        hasil = `${hasil}, ${belakang}`;
    }

    document.getElementById('nama_lengkap').value = hasil;
}
</script>

