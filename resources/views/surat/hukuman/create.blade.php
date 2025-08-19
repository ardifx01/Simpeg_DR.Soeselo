@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat Hukuman</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('hukuman.index') }}">Daftar Surat Hukuman</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengajuan Surat Hukuman</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0 fw-bold">Form Pengajuan Serat Hukuman Pegawai</h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('hukuman.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Data Pegawai</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="pegawai_id" class="form-label">Nama Lengkap Pegawai</label>
                                    <select class="form-select @error('pegawai_id') is-invalid @enderror" aria-label="Default select example" name="pegawai_id" id="pegawai_id" required>
                                        <option value="">-- Pilih Pegawai --</option>
                                        @foreach($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}" {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                    <small id="pegawai-loading" class="form-text text-muted" style="display:none;">
                                        Mengambil data pegawai...
                                    </small>
                                    @error('pegawai_id')
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control" name="nip" id="nip" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="nama_jabatan" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="unit_kerja" class="form-label">Unit Kerja</label>
                                    <input type="text" class="form-control" name="unit_kerja" id="unit_kerja" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="pangkat" class="form-label">Pangkat</label>
                                    <input type="text" class="form-control" name="pangkat" id="pangkat" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="golongan_ruang" class="form-label">Golongan Ruang</label>
                                    <input type="text" class="form-control" name="golongan_ruang" id="golongan_ruang" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Data Atasan</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="atasan_id" class="form-label">Nama Lengkap Atasan</label>
                                    <select class="form-select @error('atasan_id') is-invalid @enderror" aria-label="Default select example" name="atasan_id" id="atasan_id" required>
                                        <option value="">-- Pilih Atasan --</option>
                                        @foreach($pegawais as $atasan)
                                        <option value="{{ $atasan->id }}" {{ old('atasan_id') == $atasan->id ? 'selected' : '' }}>{{ $atasan->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                    <small id="atasan-loading" class="form-text text-muted" style="display:none;">
                                        Mengambil data atasan...
                                    </small>
                                    @error('atasan_id')
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="atasan_nip" class="form-label">NIP Atasan</label>
                                    <input type="text" class="form-control" id="atasan_nip" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="atasan_jabatan" class="form-label">Jabatan Atasan</label>
                                    <input type="text" class="form-control" id="atasan_jabatan" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="atasan_pangkat" class="form-label">Pangkat Atasan</label>
                                    <input type="text" class="form-control" id="atasan_pangkat" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="atasan_golongan_ruang" class="form-label">Golongan Ruang Atasan</label>
                                    <input type="text" class="form-control" id="atasan_golongan_ruang" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Data Hukuman</h5>

                            <div class="mb-4">
                                <h6 class="border-bottom pb-1 mb-3">Identifikasi Pelanggaran</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="bentuk_pelanggaran" class="form-label">Bentuk Pelanggaran</label>
                                        <input type="text" class="form-control @error('bentuk_pelanggaran') is-invalid @enderror" id="bentuk_pelanggaran" name="bentuk_pelanggaran" value="{{ old('bentuk_pelanggaran') }}">
                                        @error('bentuk_pelanggaran')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="waktu" class="form-label">Waktu</label>
                                        <input type="number" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" value="{{ old('waktu') }}">
                                        @error('waktu')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tempat" class="form-label">Tempat</label>
                                        <input type="text" class="form-control @error('tempat') is-invalid @enderror" id="tempat" name="tempat" value="{{ old('tempat') }}">
                                        @error('tempat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="border-bottom pb-1 mb-3">Faktor dan Dampak</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="faktor_meringankan" class="form-label">Faktor yang Meringankan</label>
                                        <textarea class="form-control @error('faktor_meringankan') is-invalid @enderror" id="faktor_meringankan" name="faktor_meringankan">{{ old('faktor_meringankan') }}</textarea>
                                        @error('faktor_meringankan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="faktor_memberatkan" class="form-label">Faktor yang Memberatkan</label>
                                        <textarea class="form-control @error('faktor_memberatkan') is-invalid @enderror" id="faktor_memberatkan" name="faktor_memberatkan">{{ old('faktor_memberatkan') }}</textarea>
                                        @error('faktor_memberatkan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dampak" class="form-label">Dampak Perbuatan</label>
                                        <textarea class="form-control @error('dampak') is-invalid @enderror" id="dampak" name="dampak">{{ old('dampak') }}</textarea>
                                        @error('dampak')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="border-bottom pb-1 mb-3">Detail Surat Hukuman</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="pwkt" class="form-label">PWKT</label>
                                        <input type="text" class="form-control @error('pwkt') is-invalid @enderror" id="pwkt" name="pwkt" value="{{ old('pwkt') }}">
                                        @error('pwkt')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="no" class="form-label">Nomor</label>
                                        <input type="text" class="form-control @error('no') is-invalid @enderror" id="no" name="no" value="{{ old('no') }}">
                                        @error('no')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tahun" class="form-label">Tahun</label>
                                        <input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun') }}">
                                        @error('tahun')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pasal" class="form-label">Pasal</label>
                                        <input type="text" class="form-control @error('pasal') is-invalid @enderror" id="pasal" name="pasal" value="{{ old('pasal') }}">
                                        @error('pasal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tentang" class="form-label">Tentang</label>
                                        <textarea class="form-control @error('tentang') is-invalid @enderror" id="tentang" name="tentang">{{ old('tentang') }}</textarea>
                                        @error('tentang')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jenis_hukuman" class="form-label">Jenis Hukuman</label>
                                        <input type="text" class="form-control @error('jenis_hukuman') is-invalid @enderror" id="jenis_hukuman" name="jenis_hukuman" value="{{ old('jenis_hukuman') }}">
                                        @error('jenis_hukuman')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="keterangan_hukuman" class="form-label">Keterangan Hukuman</label>
                                        <textarea class="form-control @error('keterangan_hukuman') is-invalid @enderror" id="keterangan_hukuman" name="keterangan_hukuman">{{ old('keterangan_hukuman') }}</textarea>
                                        @error('keterangan_hukuman')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="peraturan" class="form-label">Peraturan</label>
                                        <textarea class="form-control @error('peraturan') is-invalid @enderror" id="peraturan" name="peraturan">{{ old('peraturan') }}</textarea>
                                        @error('peraturan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="hari" class="form-label">Hari</label>
                                        <input type="text" class="form-control @error('hari') is-invalid @enderror" id="hari" name="hari" value="{{ old('hari') }}">
                                        @error('hari')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="tanggal_hukuman" value="{{ old('tanggal') }}">
                                            <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_hukuman" for="tanggal_hukuman">
                                                <i class="bi bi-calendar3"></i>
                                            </button>
                                        </div>                                        
                                        @error('tanggal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jam" class="form-label">Jam</label>
                                        <input type="time" class="form-control @error('jam') is-invalid @enderror" id="jam" name="jam" value="{{ old('jam') }}">
                                        @error('jam')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary d-block w-100">
                                    <i class="fas fa-paper-plane me-2"></i> Ajukan Surat Hukuman
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('form').addEventListener('submit', function (e) {
        const pegawaiId = document.getElementById('pegawai_id').value;
        const atasanId = document.getElementById('atasan_id').value; // Get atasan_id

        if (!pegawaiId || pegawaiId === '') { // Check for empty string, not just '-- Pilih Pegawai --'
            alert('Silakan pilih pegawai terlebih dahulu.');
            e.preventDefault();
            return; // Stop further execution
        }

        if (!atasanId || atasanId === '') { // Check for empty string for atasan_id
            alert('Silakan pilih atasan terlebih dahulu.');
            e.preventDefault();
            return; // Stop further execution
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Select2 untuk pegawai_id
        $('#pegawai_id').select2({
            placeholder: "-- Pilih Pegawai --",
            allowClear: true // Allows clearing the selection
        });

        // Inisialisasi Select2 untuk atasan_id
        $('#atasan_id').select2({
            placeholder: "-- Pilih Atasan --",
            allowClear: true // Allows clearing the selection
        });

        // Event listener untuk perubahan pada select pegawai_id
        $('#pegawai_id').on('change', function () {
            const pegawaiId = $(this).val();

            if (!pegawaiId) {
                clearPegawaiForm();
                return;
            }

            $('#pegawai-loading').show();

            fetch(`/api/pegawai/${pegawaiId}`)
                .then(response => {
                    if (!response.ok) throw new Error("Gagal ambil data pegawai");
                    return response.json();
                })
                .then(data => {
                    $('#nip').val(data.nip || '-');
                    $('#pangkat').val(data.pangkat || '-');
                    $('#golongan_ruang').val(data.golongan_ruang || '-');
                    $('#nama_jabatan').val(data.nama_jabatan || '-');
                    $('#unit_kerja').val(data.unit_kerja || '-');
                })
                .catch(error => {
                    alert('Gagal mengambil data pegawai: ' + error.message);
                    clearPegawaiForm();
                })
                .finally(() => {
                    $('#pegawai-loading').hide();
                });
        });

        // Event listener untuk perubahan pada select atasan_id
        $('#atasan_id').on('change', function () {
            const atasanId = $(this).val();

            if (!atasanId) {
                clearAtasanForm();
                return;
            }

            $('#atasan-loading').show();

            fetch(`/api/pegawai/${atasanId}`)
                .then(response => {
                    if (!response.ok) throw new Error("Gagal ambil data atasan");
                    return response.json();
                })
                .then(data => {
                    $('#atasan_nip').val(data.nip || '-');
                    $('#atasan_jabatan').val(data.nama_jabatan || '-');
                    $('#atasan_pangkat').val(data.pangkat || '-');
                    $('#atasan_golongan_ruang').val(data.golongan_ruang || '-');
                })
                .catch(error => {
                    alert('Gagal mengambil data atasan: ' + error.message);
                    clearAtasanForm();
                })
                .finally(() => {
                    $('#atasan-loading').hide();
                });
        });

        // Fungsi untuk mengosongkan form data pegawai
        function clearPegawaiForm() {
            $('#nip').val('');
            $('#pangkat').val('');
            $('#golongan_ruang').val('');
            $('#nama_jabatan').val('');
            $('#unit_kerja').val('');
        }

        // Fungsi untuk mengosongkan form data atasan
        function clearAtasanForm() {
            $('#atasan_nip').val('');
            $('#atasan_jabatan').val('');
            $('#atasan_pangkat').val('');
            $('#atasan_golongan_ruang').val('');
        }

        // Trigger change event on page load if old values exist to populate the fields
        if ($('#pegawai_id').val()) {
            $('#pegawai_id').trigger('change');
        }
        if ($('#atasan_id').val()) {
            $('#atasan_id').trigger('change');
        }
    });
</script>
@endsection