@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat Keterangan</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('keterangan.index') }}">Daftar Surat Keterangan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengajuan Surat Keterangan</li>
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
                    <h4 class="mb-0 fw-bold">Form Pengajuan Keterangan Pegawai</h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('keterangan.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Data Pegawai</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="pegawai_id" class="form-label">Nama Lengkap</label>
                                    <select class="form-select" aria-label="Default select example" name="pegawai_id" id="pegawai_id" required>
                                        <option selected>-- Pilih Pegawai --</option>
                                        @foreach($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}">{{ $pegawai->gelar_depan }}. {{ $pegawai->nama }}, {{ $pegawai->gelar_belakang }}</option>
                                        @endforeach
                                    </select>
                                    <small id="pegawai-loading" class="form-text text-muted" style="display:none;">
                                        Mengambil data pegawai...
                                    </small>
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
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="text" class="form-control" name="tanggal_lahir" id="tanggal_lahir" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="tingkat" class="form-label">Pendidikan</label>
                                    <input type="text" class="form-control" name="tingkat" id="tingkat" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" name="alamat" id="alamat" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Data Keterangan</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="jenis_keterangan" class="form-label">Jenis Keterangan</label>
                                    <select class="form-select @error('jenis_keterangan') is-invalid @enderror" id="jenis_keterangan" name="jenis_keterangan" onchange="handleJenisKeteranganChange()" required>
                                        <option value="">-- Pilih Jenis Keterangan --</option>
                                        <option value="keluarga" {{ old('jenis_keterangan') == 'keluarga' ? 'selected' : '' }}>Keterangan Hubungan Keluarga</option>
                                        <option value="keterangan" {{ old('jenis_keterangan') == 'keterangan' ? 'selected' : '' }}>Keterangan Rawat Inap</option>
                                    </select>
                                    @error('jenis_keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div id="form-keluarga" class="mt-4" style="display: none;">
                                <h6 class="mb-3">Detail Hubungan Keluarga</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="hubungan" class="form-label">Status Hubungan</label>
                                        <select class="form-select @error('hubungan') is-invalid @enderror" id="hubungan" name="hubungan">
                                            <option value="">-- Pilih Status Hubungan --</option>
                                            <option value="Suami" {{ old('hubungan') == 'Suami' ? 'selected' : '' }}>Suami</option>
                                            <option value="Istri" {{ old('hubungan') == 'Istri' ? 'selected' : '' }}>Istri</option>
                                            <option value="Anak" {{ old('hubungan') == 'Anak' ? 'selected' : '' }}>Anak</option>
                                        </select>
                                        @error('hubungan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
                                        @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}">
                                        @error('nik')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tempat_lahir_keluarga" class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir_keluarga" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                        @error('tempat_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" id="tanggal_lahir_keluarga" value="{{ old('tanggal_lahir') }}">
                                            <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_lahir_keluarga" for="tanggal_lahir">
                                                <i class="bi bi-calendar3"></i>
                                            </button>
                                        </div>
                                        @error('tanggal_lahir')
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
                                        <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}">
                                        @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div id="form-rawat-inap" class="mt-4" style="display: none;">
                                <h6 class="mb-3">Detail Rawat Inap</h6>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Apakah menjalani rawat inap di RSUD dr Soeselo Kab. Tegal?</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status_rawat" value="sedang" id="radioDefault1">
                                                <label class="form-check-label" for="radioDefault1">Sedang</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status_rawat" value="telah" id="radioDefault2" checked>
                                                <label class="form-check-label" for="radioDefault2">Telah</label>
                                            </div>
                                        </div>
                                        @error('status_rawat')
                                        <div class="invalid-feedback d-block">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary d-block w-100">
                                    <i class="fas fa-paper-plane me-2"></i> Ajukan Surat Keterangan
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

        if (!pegawaiId || pegawaiId === '-- Pilih Pegawai --') {
            alert('Silakan pilih pegawai terlebih dahulu.');
            e.preventDefault();
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Select2
        $('#pegawai_id').select2({
            placeholder: "-- Pilih Pegawai --"
        });

        $('#pegawai_id').on('change', function () {
            const pegawaiId = $(this).val();

            if (!pegawaiId) {
                clearForm();
                return;
            }

            $('#pegawai-loading').show();

            fetch(`/api/pegawai/${pegawaiId}`)
                .then(response => {
                    if (!response.ok) throw new Error("Gagal ambil data");
                    return response.json();
                })
                .then(data => {
                    $('#nip').val(data.nip || '-');
                    $('#tempat_lahir').val(data.tempat_lahir || '-');
                    $('#tanggal_lahir').val(data.tanggal_lahir || '-');
                    $('#alamat').val(data.alamat || '-');
                    $('#nama_jabatan').val(data.nama_jabatan || '-');
                    $('#unit_kerja').val(data.unit_kerja || '-');
                    $('#tingkat').val(data.tingkat || '-');
                })
                .catch(error => {
                    alert('Gagal mengambil data pegawai.');
                    clearForm();
                })
                .finally(() => {
                    $('#pegawai-loading').hide();
                });
        });

        function clearForm() {
            $('#nip').val('');
            $('#tempat_lahir').val('');
            $('#tanggal_lahir').val('');
            $('#alamat').val('');
            $('#nama_jabatan').val('');
            $('#unit_kerja').val('');
            $('#tingkat').val('');
        }
    });

    function handleJenisKeteranganChange() {
        const select = document.getElementById('jenis_keterangan');
        const formKeluarga = document.getElementById('form-keluarga');
        const formRawatInap = document.getElementById('form-rawat-inap');
        
        const value = select.value;
        
        // Sembunyikan semua form
        formKeluarga.style.display = 'none';
        formRawatInap.style.display = 'none';
        
        // Tampilkan sesuai pilihan
        if (value === 'keluarga') {
            formKeluarga.style.display = 'block';
        } else if (value === 'keterangan') {
            formRawatInap.style.display = 'block';
        }
    }

    // Tambahkan event listener setelah DOM ready
    function handleJenisKeteranganChange() {
        const value = document.getElementById('jenis_keterangan').value;
        const formKeluarga = document.getElementById('form-keluarga');
        const formRawatInap = document.getElementById('form-rawat-inap');

        // Sembunyikan dua-duanya dulu
        formKeluarga.style.display = 'none';
        formRawatInap.style.display = 'none';

        if (value === 'keluarga') {
            formKeluarga.style.display = 'block';
        } else if (value === 'keterangan') {
            formRawatInap.style.display = 'block';
        }
    }

    // Trigger saat halaman selesai dimuat (biar tetep tampil kalau ada input lama)
    document.addEventListener('DOMContentLoaded', function () {
        handleJenisKeteranganChange();
    });
</script>
@endsection