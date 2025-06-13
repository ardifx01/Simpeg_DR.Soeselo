@extends('surat.layouts.main')

@section('main')

<div class="pagetitle">
    <div class="row justify-content-between">
        <div class="col">
            <h1>Surat Pembinaan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Pengajuan Surat Pembinaan</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Pengajuan Surat Pembinaan Title -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Form Pengajuan Pembinaan Pegawai</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('pembinaan.store') }}" method="POST">
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
                                        <label for="agama">Agama</label>
                                        <input type="text" class="form-control" name="agama" id="agama" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea type="text" class="form-control" name="alamat" id="alamat" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Pembinaan -->
                        <div class="mt-2 mb-4">
                            <h5 class="border-bottom pb-2">Data Pembinaan</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama">nama Suami/Istri</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="hubungan">Status Hubungan</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hubungan" id="suami" value="Suami">
                                            <label class="form-check-label" for="suami">
                                                Suami
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hubungan" id="istri" value="Istri" checked>
                                            <label class="form-check-label" for="istri">
                                                Istri
                                            </label>
                                        </div>
                                        @error('hubungan')
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
                                        <label for="pekerjaan">Pekerjaan</label>
                                        <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}">
                                        @error('pekerjaan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
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
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}"></textarea>
                                        @error('alamat')
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
                                    <i class="fas fa-paper-plane"></i> Ajukan Surat Pembinaan
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
                    console.log(data);
                    $('#nip').val(data.nip || '-');
                    $('#pangkat').val(data.pangkat || '-');
                    $('#golongan_ruang').val(data.golongan_ruang || '-');
                    $('#jabatan').val(data.jabatan || '-');
                    $('#agama').val(data.agama || '-');
                    $('#alamat').val(data.alamat || '-');
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
            $('#agama').val('');
            $('#alamat').val('');
        }
    });
</script>
@endsection