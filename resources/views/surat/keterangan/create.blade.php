@extends('surat.layouts.main')

@section('main')

<div class="pagetitle">
    <div class="row justify-content-between">
        <div class="col">
            <h1>Surat keterangan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Pengajuan Surat Keterangan</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Pengajuan Surat Keterangan Title -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Form Pengajuan Keterangan Pegawai</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('keterangan.store') }}" method="POST">
                        @csrf
                        <!-- Data Pegawai -->
                        <div class="mt-2 mb-4">
                            <h5 class="border-bottom pb-2">Data Pegawai</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama">Nama Lengkap</label>
                                        <select class="form-select" aria-label="Default select example" name="pegawai_id" id="pegawai_id" require>
                                            <option selected>-- Pilih Pegawai --</option>
                                            @foreach($pegawais as $pegawai)
                                            <option value="{{ $pegawai->id }}">{{ $pegawai->gelar_depan }}. {{ $pegawai->nama }}, {{ $pegawai->gelar_belakang }}</option>
                                            @endforeach
                                        </select>
                                        <small id="pegawai-loading" style="display:none; color:gray;">
                                            Mengambil data pegawai...
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nip">NIP</label>
                                        <input type="text" class="form-control" name="nip" id="nip" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jabatan">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan" id="jabatan" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="unit_kerja">Unit Kerja</label>
                                        <input type="text" class="form-control" name="unit_kerja" id="unit_kerja" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                        <input type="text" class="form-control" name="tanggal_lahir" id="tanggal_lahir" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tingkat">Pendidikan</label>
                                        <input type="text" class="form-control" name="tingkat" id="tingkat" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" class="form-control" name="alamat" id="alamat" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data keterangan -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2">Data Keterangan</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_keterangan">Jenis Keterangan</label>
                                        <select class="form-control @error('jenis_keterangan') is-invalid @enderror" id="jenis_keterangan" name="jenis_keterangan" onchange="handleJenisKeteranganChange()" required>
                                            <option value="">-- Pilih Jenis Keterangan --</option>
                                            <option value="keluarga" {{ old('jenis_keterangan') == 'keluarga' ? 'selected' : '' }}>Keterangan Hubungan Keluarga</option>
                                            <option value="keterangan" {{ old('jenis_keterangan') == 'keterangan' ? 'selected' : '' }}>Keterangan Rawat Inap</option>
                                        </select>
                                        @error('jenis_keterangan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Form untuk Hubungan Keluarga -->
                            <div id="form-keluarga" class="mt-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hubungan">Status Hubungan</label>
                                            <select class="form-control @error('hubungan') is-invalid @enderror" id="hubungan" name="hubungan">
                                                <option value="">-- Pilih Status Hubungan --</option>
                                                <option value="Suami" {{ old('hubungan') == 'Suami' ? 'selected' : '' }}>Suami</option>
                                                <option value="Istri" {{ old('hubungan') == 'Istri' ? 'selected' : '' }}>Istri</option>
                                                <option value="Anak" {{ old('hubungan') == 'Anak' ? 'selected' : '' }}>Anak</option>
                                            </select>
                                            @error('hubungan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
                                            @error('nama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nik">NIK</label>
                                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}">
                                            @error('nik')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tempat_lahir">Tempat Lahir</label>
                                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                            @error('tempat_lahir')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                            @error('tanggal_lahir')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pekerjaan">Pekerjaan</label>
                                            <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}">
                                            @error('pekerjaan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="agama">Agama</label>
                                            <select class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama">
                                                <option value="">-- Pilih Agama --</option>
                                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                <option value="Protestan" {{ old('agama') == 'Protestan' ? 'selected' : '' }}>Protestan</option>
                                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                            </select>
                                            @error('agama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}">
                                            @error('alamat')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form untuk Rawat Inap -->
                            <div id="form-rawat-inap" class="mt-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">menjalani rawat inap di RSUD dr Soeselo Kab. Tegal?</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioDefault" id="radioDefault1">
                                                <label class="form-check-label" for="radioDefault1">
                                                    Sedang
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioDefault" id="radioDefault2" checked>
                                                <label class="form-check-label" for="radioDefault2">
                                                    Telah
                                                </label>
                                            </div>
                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Ajukan Surat Keterangan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            const pegawaiId = $(this).val(); // Ambil nilai dari Select2

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
                    $('#jabatan').val(data.jabatan || '-');
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
            $('#jabatan').val('');
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
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('jenis_keterangan');
        if (select) {
            select.addEventListener('change', handleJenisKeteranganChange);
            
            // Cek nilai awal
            if (select.value) {
                handleJenisKeteranganChange();
            }
        }
    });
</script>
@endsection