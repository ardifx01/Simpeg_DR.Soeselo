<form method="POST" action="{{ route('pegawai.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Bagian Tampilan Gambar dan Tombol Upload -->
        <div class="col-xl-3 pt-4 d-flex flex-column align-items-center">
            <img id="preview-image" src="{{ asset('assets/img/nophoto.jpg') }}" alt="Foto Pegawai" class="rounded mb-2" style="width: 150px; height: 200px; object-fit: cover; border:1px solid #ccc;">
            <div class="mb-3">
                <label class="btn btn-primary">
                    Pilih Foto
                    <input type="file" name="image" id="image" accept="image/*" style="display: none;" onchange="validateAndPreview(event)">
                </label>
            </div>
        </div>

        <div class="col-xl-8 mt-4">
            <div class="row mb-3 form-group">
                <label for="nip" class="col-md-4 col-lg-3 col-form-label">NIP</label>
                <div class="col-md-8 col-lg-9">
                    <input name="nip" type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" value="{{ old('nip') }}">
                    @error('nip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3 form-group">
                <label for="nip_lama" class="col-md-4 col-lg-3 col-form-label">NIP Lama</label>
                <div class="col-md-8 col-lg-9">
                    <input name="nip_lama" type="text" class="form-control @error('nip_lama') is-invalid @enderror" id="nip_lama" value="{{ old('nip_lama') }}">
                    @error('nip_lama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3 form-group">
                <label for="no_karpeg" class="col-md-4 col-lg-3 col-form-label">No. Karpeg</label>
                <div class="col-md-8 col-lg-9">
                    <input name="no_karpeg" type="text" class="form-control @error('no_karpeg') is-invalid @enderror" id="no_karpeg" value="{{ old('no_karpeg') }}">
                    @error('no_karpeg')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3 form-group">
                <label for="no_kpe" class="col-md-4 col-lg-3 col-form-label">No. KPE</label>
                <div class="col-md-8 col-lg-9">
                    <input name="no_kpe" type="text" class="form-control @error('no_kpe') is-invalid @enderror" id="no_kpe" value="{{ old('no_kpe') }}">
                    @error('no_kpe')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3 form-group">
                <label for="no_ktp" class="col-md-4 col-lg-3 col-form-label">No. KTP</label>
                <div class="col-md-4 col-lg-4">
                    <input name="no_ktp" type="text" class="form-control @error('no_ktp') is-invalid @enderror" id="no_ktp" value="{{ old('no_ktp') }}">
                    @error('no_ktp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <label for="no_npwp" class="col-md-2 col-lg-1 col-form-label">NPWP</label>
                <div class="col-md-4 col-lg-4">
                    <input name="no_npwp" type="text" class="form-control @error('no_npwp') is-invalid @enderror" id="no_npwp" value="{{ old('no_npwp') }}">
                    @error('no_npwp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3 form-group">
                <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                <div class="col-md-8 col-lg-9">
                    <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3 form-group">
                <label class="col-md-4 col-lg-3 col-form-label">Gelar Kesarjanaan</label>
                <div class="col-md-4 col-lg-2">
                    <input name="gelar_depan" type="text" class="form-control" id="gelar_depan"  value="{{ old('gelar_depan') }}">
                </div>
                <label for="gelar_depan" class="col-md-2 col-lg-2 col-form-label">(Gelar Depan)</label>
                <div class="col-md-4 col-lg-2">
                    <input name="gelar_belakang" type="text" class="form-control @error('gelar_belakang') is-invalid @enderror" id="gelar_belakang" value="{{ old('gelar_belakang') }}">
                    @error('gelar_belakang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <label for="gelar_belakang" class="col-md-2 col-lg-2 col-form-label">(Gelar Belakang)</label>
            </div>

            <div class="row mb-3 form-group">
                <label for="tempat_lahir" class="col-md-4 col-lg-3 col-form-label">Tempat, Tanggal Lahir</label>
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
                <label class="col-md-4 col-lg-3 col-form-label">Jenis Kelamin</label>
                <div class="col-md-8 col-lg-9 mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="laki_laki" value="Laki-laki">
                        <label class="form-check-label" for="laki_laki">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan">
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
                        <option selected disabled>-- Pilihan --</option>
                        <option value="Islam">Islam</option>
                        <option value="Protestan">Protestan</option>
                        <option value="Khatolik">Khatolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Budha">Budha</option>
                    </select>
                    @error('agama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <label for="status_nikah" class="col-md-4 col-lg-3 col-form-label">Status Perkawinan</label>
                <div class="col-md-4 col-lg-3">
                    <select class="form-select" aria-label="Default select example" name="status_nikah" id="status_nikah">
                        <option selected disabled>-- Pilihan --</option>
                        <option value="Sudah Kawin">Sudah Kawin</option>
                        <option value="Belum">Belum</option>
                        <option value="Janda">Janda</option>
                        <option value="Duda">Duda</option>
                    </select>
                    @error('status_nikah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3 form-group">
                <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                <div class="col-md-8 col-lg-9">
                    <textarea name="alamat" class="form-control" id="alamatLengkap" style="height: 100px"></textarea>
                </div>
            </div>

            <div class="row mb-3 form-group">
                <label for="rt" class="col-md-4 col-lg-3 col-form-label">RT</label>
                <div class="col-md-4 col-lg-3">
                    <input name="rt" type="text" class="form-control @error('rt') is-invalid @enderror" id="rt" value="" oninput="updateAlamatLengkap()">
                    @error('rt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <label for="rw" class="col-md-4 col-lg-3 col-form-label">RW</label>
                <div class="col-md-4 col-lg-3">
                    <input name="rw" type="text" class="form-control @error('rw') is-invalid @enderror" id="rw" value="" oninput="updateAlamatLengkap()">
                    @error('rw')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3 form-group">
                <label for="desa" class="col-md-4 col-lg-3 col-form-label">Desa</label>
                <div class="col-md-4 col-lg-3">
                    <input name="desa" type="text" class="form-control @error('desa') is-invalid @enderror" id="desa" value="" oninput="updateAlamatLengkap()">
                    @error('desa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <label for="kecamatan" class="col-md-4 col-lg-3 col-form-label">Kecamatan</label>
                <div class="col-md-4 col-lg-3">
                    <input name="kecamatan" type="text" class="form-control @error('kecamatan') is-invalid @enderror" id="kecamatan" value="" oninput="updateAlamatLengkap()">
                    @error('kecamatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3 form-group">
                <label for="kabupaten" class="col-md-4 col-lg-3 col-form-label">Kabupaten</label>
                <div class="col-md-4 col-lg-3">
                    <input name="kabupaten" type="text" class="form-control @error('kabupaten') is-invalid @enderror" id="kabupaten" value="" oninput="updateAlamatLengkap()">
                    @error('kabupaten')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <label for="provinsi" class="col-md-4 col-lg-3 col-form-label">Provinsi</label>
                <div class="col-md-4 col-lg-3">
                    <input name="provinsi" type="text" class="form-control @error('provinsi') is-invalid @enderror" id="provinsi" value="" oninput="updateAlamatLengkap()">
                    @error('provinsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3 form-group">
                <label for="pos" class="col-md-4 col-lg-3 col-form-label">Kode POS</label>
                <div class="col-md-4 col-lg-3">
                    <input name="pos" type="text" class="form-control @error('pos') is-invalid @enderror" id="pos" value="" oninput="updateAlamatLengkap()">
                    @error('pos')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <label for="telepon" class="col-md-4 col-lg-3 col-form-label">telepon</label>
                <div class="col-md-4 col-lg-3">
                    <input name="telepon" type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" value="">
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
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

function previewGambar(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('preview-image');
        output.src = reader.result;
    };
    if(event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}

function updateAlamatLengkap() {
    // Ambil nilai dari setiap input
    const rt = document.getElementById('rt').value;
    const rw = document.getElementById('rw').value;
    const desa = document.getElementById('desa').value;
    const kecamatan = document.getElementById('kecamatan').value;
    const kabupaten = document.getElementById('kabupaten').value;
    const provinsi = document.getElementById('provinsi').value;
    const pos = document.getElementById('pos').value;

    // Gabungkan nilai-nilai tersebut untuk membentuk alamat lengkap
    let alamatLengkap = alamat;

    if (desa) {
        alamatLengkap += `, ${desa}`;
    }
    if (rt || rw) {
        alamatLengkap += ` RT ${rt}/RW ${rw}`;
    }
    if (desa) {
        alamatLengkap += `, Desa ${desa}`;
    }
    if (kecamatan) {
        alamatLengkap += `, Kecamatan ${kecamatan}`;
    }
    if (kabupaten) {
        alamatLengkap += `, Kabupaten ${kabupaten}`;
    }
    if (provinsi) {
        alamatLengkap += `, Provinsi ${provinsi}`;
    }
    if (pos) {
        alamatLengkap += ` Kode Pos:${pos}`;
    }

    console.log("Alamat Lengkap:", alamatLengkap);
}
</script>
