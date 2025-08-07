@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat Pembinaan</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pembinaan.index') }}">Daftar Pengajuan Surat Pembinaan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengajuan Surat Pembinaan</li>
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
                    <h4 class="mb-0 fw-bold">Form Pengajuan Pembinaan Pegawai</h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('pembinaan.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Data Pegawai</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="pegawai_id" class="form-label">Nama Lengkap Pegawai</label>
                                    <select class="form-select @error('pegawai_id') is-invalid @enderror" aria-label="Pilih Pegawai" name="pegawai_id" id="pegawai_id" required>
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
                                    <select class="form-select @error('atasan_id') is-invalid @enderror" aria-label="Pilih Atasan" name="atasan_id" id="atasan_id" required>
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
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Data Pembinaan</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama_pasangan" class="form-label">Nama Suami/Istri</label>
                                    <input type="text" class="form-control @error('nama_pasangan') is-invalid @enderror" id="nama_pasangan" name="nama_pasangan" value="{{ old('nama_pasangan') }}">
                                    @error('nama_pasangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                    <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}">
                                    @error('pekerjaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="agama" class="form-label">Agama</label>
                                    <select class="form-select @error('agama') is-invalid @enderror" id="agama" name="agama">
                                        <option value="">-- Pilih Agama --</option>
                                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Protestan" {{ old('agama') == 'Protestan' ? 'selected' : '' }}>Protestan</option>
                                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    </select>
                                    @error('agama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status Hubungan</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input @error('hubungan') is-invalid @enderror" type="radio" name="hubungan" id="suami" value="Suami" {{ old('hubungan') == 'Suami' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="suami">Suami</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input @error('hubungan') is-invalid @enderror" type="radio" name="hubungan" id="istri" value="Istri" {{ old('hubungan') == 'Istri' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="istri">Istri</label>
                                        </div>
                                    </div>
                                    @error('hubungan')
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="status_perceraian" class="form-label">Status Perceraian</label>
                                    <select class="form-select @error('status_perceraian') is-invalid @enderror" id="status_perceraian" name="status_perceraian">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Permohonan" {{ old('status_perceraian') == 'Permohonan' ? 'selected' : '' }}>Permohonan</option>
                                        <option value="DiGugat" {{ old('status_perceraian') == 'DiGugat' ? 'selected' : '' }}>DiGugat</option>
                                    </select>
                                    @error('status_perceraian')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary d-block w-100">
                                    <i class="fas fa-paper-plane me-2"></i> Ajukan Surat Pembinaan
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
                    // Mengakses properti langsung dari objek data
                    $('#nip').val(data.nip || '-');
                    $('#pangkat').val(data.pangkat || '-');
                    $('#golongan_ruang').val(data.golongan_ruang || '-');
                    $('#nama_jabatan').val(data.nama_jabatan || '-');
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
                    // Mengakses properti langsung dari objek data
                    $('#atasan_nip').val(data.nip || '-');
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
            $('#pangkat').val('');
            $('#golongan_ruang').val('');
            $('#nama_jabatan').val('');
            $('#unit_kerja').val('');
        }

        // Fungsi untuk mengosongkan form data atasan
        function clearAtasanForm() {
            $('#atasan_nip').val('');
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