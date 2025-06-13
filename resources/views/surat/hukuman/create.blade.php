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
                    <form action="{{ route('hukuman.store') }}" method="POST">
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
                                        <label for="pangkat">Pangkat</label>
                                        <input type="text" class="form-control" name="pangkat" id="pangkat" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="golongan_ruang">Golongan Ruang</label>
                                        <input type="text" class="form-control" name="golongan_ruang" id="golongan_ruang" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Hukuman -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2">Data Hukuman</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bentuk_pelanggaran">Bentuk Pelanggaran</label>
                                        <input type="text" class="form-control @error('bentuk_pelanggaran') is-invalid @enderror" id="bentuk_pelanggaran" name="bentuk_pelanggaran" value="{{ old('bentuk_pelanggaran') }}">
                                        @error('bentuk_pelanggaran')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="waktu">Waktu</label>
                                        <input type="text" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" value="{{ old('waktu') }}">
                                        @error('waktu')
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
                                        <label for="tempat">Tempat</label>
                                        <input type="text" class="form-control @error('tempat') is-invalid @enderror" id="tempat" name="tempat" value="{{ old('tempat') }}">
                                        @error('tempat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="faktor_meringankan">Faktor yang Meringankan</label>
                                        <input type="text" class="form-control @error('faktor_meringankan') is-invalid @enderror" id="faktor_meringankan" name="faktor_meringankan" value="{{ old('faktor_meringankan') }}">
                                        @error('faktor_meringankan')
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
                                        <label for="faktor_memberatkan">Faktor yang Memberatkan</label>
                                        <input type="text" class="form-control @error('faktor_memberatkan') is-invalid @enderror" id="faktor_memberatkan" name="faktor_memberatkan" value="{{ old('faktor_memberatkan') }}">
                                        @error('faktor_memberatkan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pwkt">PWKT</label>
                                        <input type="text" class="form-control @error('pwkt') is-invalid @enderror" id="pwkt" name="pwkt" value="{{ old('pwkt') }}">
                                        @error('pwkt')
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
                                        <label for="no">Nomor</label>
                                        <input type="text" class="form-control @error('no') is-invalid @enderror" id="no" name="no" value="{{ old('no') }}">
                                        @error('no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tahun">Tahun</label>
                                        <input type="text" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun') }}">
                                        @error('tahun')
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
                                        <label for="pasal">Pasal</label>
                                        <input type="text" class="form-control @error('pasal') is-invalid @enderror" id="pasal" name="pasal" value="{{ old('pasal') }}">
                                        @error('pasal')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tentang">Tentang</label>
                                        <input type="text" class="form-control @error('tentang') is-invalid @enderror" id="tentang" name="tentang" value="{{ old('tentang') }}">
                                        @error('tentang')
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
                                        <label for="jenis_hukuman">Jenis Hukuman</label>
                                        <input type="text" class="form-control @error('jenis_hukuman') is-invalid @enderror" id="jenis_hukuman" name="jenis_hukuman" value="{{ old('jenis_hukuman') }}">
                                        @error('jenis_hukuman')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="keterangan_hukuman">Keterangan Hukuman</label>
                                        <input type="text" class="form-control @error('keterangan_hukuman') is-invalid @enderror" id="keterangan_hukuman" name="keterangan_hukuman" value="{{ old('keterangan_hukuman') }}">
                                        @error('keterangan_hukuman')
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
                                        <label for="peraturan">Peraturan</label>
                                        <input type="text" class="form-control @error('peraturan') is-invalid @enderror" id="peraturan" name="peraturan" value="{{ old('peraturan') }}">
                                        @error('peraturan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hari">Hari</label>
                                        <input type="text" class="form-control @error('hari') is-invalid @enderror" id="hari" name="hari" value="{{ old('hari') }}">
                                        @error('hari')
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
                                        <label for="tanggal">Tanggal</label>
                                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal') }}">
                                        @error('tanggal')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jam">Jam</label>
                                        <input type="text" class="form-control @error('jam') is-invalid @enderror" id="jam" name="jam" value="{{ old('jam') }}">
                                        @error('jam')
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
                                        <label for="dampak">Dampak Perbuatan</label>
                                        <input type="date" class="form-control @error('dampak') is-invalid @enderror" id="dampak" name="dampak" value="{{ old('dampak') }}">
                                        @error('dampak')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
                    $('#pangkat').val(data.pangkat || '-');
                    $('#golongan_ruang').val(data.golongan_ruang || '-');
                    $('#jabatan').val(data.jabatan || '-');
                    $('#unit_kerja').val(data.unit_kerja || '-');
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
            $('#pangkat').val('');
            $('#golongan_ruang').val('');
            $('#jabatan').val('');
            $('#unit_kerja').val('');
        }
    });
</script>
@endsection