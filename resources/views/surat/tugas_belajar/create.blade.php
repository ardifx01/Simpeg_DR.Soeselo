@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1>Surat Tugas Belajar</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tugas_belajar.index') }}">Daftar Surat Tugas Belajar</a></li>
                    <li class="breadcrumb-item active">Pengajuan Surat Tugas Belajar</li>
                </ol>
            </nav>
        </div>
    </div>
</div><div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form Pengajuan Tugas Belajar Pegawai</h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('tugas_belajar.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Data Pegawai</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pegawai_id" class="form-label">Nama Lengkap Pegawai</label>
                                        <select class="form-select @error('pegawai_id') is-invalid @enderror" aria-label="Default select example" name="pegawai_id" id="pegawai_id" required>
                                            <option value="">-- Pilih Pegawai --</option>
                                            @foreach($pegawais as $pegawai)
                                            <option value="{{ $pegawai->id }}" {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                        <small id="pegawai-loading" class="text-muted" style="display:none;">
                                            Mengambil data pegawai...
                                        </small>
                                        @error('pegawai_id')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nip" class="form-label">NIP</label>
                                        <input type="text" class="form-control" name="nip" id="nip" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pangkat" class="form-label">Pangkat</label>
                                        <input type="text" class="form-control" name="pangkat" id="pangkat" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="golongan_ruang" class="form-label">Golongan Ruang</label>
                                        <input type="text" class="form-control" name="golongan_ruang" id="golongan_ruang" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_jabatan" class="form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="unit_kerja" class="form-label">Unit Kerja</label>
                                        <input type="text" class="form-control" name="unit_kerja" id="unit_kerja" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="text" class="form-control" name="tanggal_lahir" id="tanggal_lahir" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tingkat" class="form-label">Pendidikan</label>
                                        <input type="text" class="form-control" name="tingkat" id="tingkat" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" name="alamat" id="alamat" readonly></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telepon" class="form-label">telepon/HP</label>
                                        <input type="text" class="form-control" name="telepon" id="telepon" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Data Atasan</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="atasan_id" class="form-label">Nama Lengkap Atasan</label>
                                        <select class="form-select @error('atasan_id') is-invalid @enderror" aria-label="Default select example" name="atasan_id" id="atasan_id" required>
                                            <option value="">-- Pilih Atasan --</option>
                                            @foreach($pegawais as $atasan)
                                            <option value="{{ $atasan->id }}" {{ old('atasan_id') == $atasan->id ? 'selected' : '' }}>{{ $atasan->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                        <small id="atasan-loading" class="text-muted" style="display:none;">
                                            Mengambil data atasan...
                                        </small>
                                        @error('atasan_id')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="atasan_nip" class="form-label">NIP Atasan</label>
                                        <input type="text" class="form-control" id="atasan_nip" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="atasan_pangkat" class="form-label">Pangkat Atasan</label>
                                        <input type="text" class="form-control" id="atasan_pangkat" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="atasan_golongan_ruang" class="form-label">Golongan Ruang Atasan</label>
                                        <input type="text" class="form-control" id="atasan_golongan_ruang" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="atasan_jabatan" class="form-label">Jabatan Atasan</label>
                                        <input type="text" class="form-control" id="atasan_jabatan" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Data Tugas Belajar</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="program" class="form-label">Program</label>
                                        <input type="text" class="form-control @error('program') is-invalid @enderror" name="program" value="{{ old('program') }}" required>
                                        @error('program')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lembaga" class="form-label">Lembaga Pendidikan</label>
                                        <input type="text" class="form-control @error('lembaga') is-invalid @enderror" name="lembaga" value="{{ old('lembaga') }}" required>
                                        @error('lembaga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fakultas" class="form-label">Fakultas</label>
                                        <input type="text" class="form-control @error('fakultas') is-invalid @enderror" name="fakultas" value="{{ old('fakultas') }}" required>
                                        @error('fakultas')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="program_studi" class="form-label">Program Studi</label>
                                        <input type="text" class="form-control @error('program_studi') is-invalid @enderror" name="program_studi" value="{{ old('program_studi') }}" required>
                                        @error('program_studi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary d-block w-100">
                                    <i class="fas fa-paper-plane me-2"></i> Ajukan Surat Tugas Belajar
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
        const atasanId = document.getElementById('atasan_id').value;

        if (!pegawaiId || pegawaiId === '') {
            alert('Silakan pilih pegawai terlebih dahulu.');
            e.preventDefault();
            return;
        }

        if (!atasanId || atasanId === '') {
            alert('Silakan pilih atasan terlebih dahulu.');
            e.preventDefault();
            return;
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Select2 untuk pegawai_id
        $('#pegawai_id').select2({
            placeholder: "-- Pilih Pegawai --",
            allowClear: true
        });

        // Inisialisasi Select2 untuk atasan_id
        $('#atasan_id').select2({
            placeholder: "-- Pilih Atasan --",
            allowClear: true
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
                    $('#tempat_lahir').val(data.tempat_lahir || '-');
                    $('#tanggal_lahir').val(data.tanggal_lahir || '-');
                    $('#alamat').val(data.alamat || '-');
                    $('#nama_jabatan').val(data.nama_jabatan || '-');
                    $('#pangkat').val(data.pangkat || '-');
                    $('#golongan_ruang').val(data.golongan_ruang || '-');
                    $('#telepon').val(data.telepon || '-');
                    $('#unit_kerja').val(data.unit_kerja || '-');
                    $('#tingkat').val(data.tingkat || '-');
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
                    $('#atasan_pangkat').val(data.pangkat || '-');
                    $('#atasan_golongan_ruang').val(data.golongan_ruang || '-');
                    $('#atasan_jabatan').val(data.nama_jabatan || '-');
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
            $('#tempat_lahir').val('');
            $('#tanggal_lahir').val('');
            $('#alamat').val('');
            $('#nama_jabatan').val('');
            $('#pangkat').val('');
            $('#golongan_ruang').val('');
            $('#telepon').val('');
            $('#unit_kerja').val('');
            $('#tingkat').val('');
        }

        // Fungsi untuk mengosongkan form data atasan
        function clearAtasanForm() {
            $('#atasan_nip').val('');
            $('#atasan_pangkat').val('');
            $('#atasan_golongan_ruang').val('');
            $('#atasan_jabatan').val('');
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