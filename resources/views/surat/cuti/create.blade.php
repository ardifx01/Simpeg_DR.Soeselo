@extends('surat.layouts.main')

@section('main')

<div class="pagetitle">
    <div class="row justify-content-between">
        <div class="col">
            <h1>Surat Cuti</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Pengajuan Surat Cuti / Ijin</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Pengajuan Surat Cuti Title -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Form Pengajuan Cuti Pegawai</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('cuti.store') }}" method="POST">
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
                        </div>

                        <!-- Data Cuti -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2">Data Cuti</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_cuti">Jenis Cuti</label>
                                        <select class="form-control @error('jenis_cuti') is-invalid @enderror" id="jenis_cuti" name="jenis_cuti" required>
                                            <option value="">-- Pilih Jenis Cuti --</option>
                                            <option value="tahunan">Cuti Tahunan</option>
                                            <option value="melahirkan">Cuti Melahirkan</option>
                                            <option value="penting">Cuti di Luar Tanggungan Negara</option>
                                            <option value="sakit">Ijin Sakit</option>
                                            <option value="penting">Ijin Penting</option>
                                        </select>
                                        @error('jenis_cuti')
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
                                        <label for="tanggal_mulai">Tanggal Mulai</label>
                                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_selesai">Tanggal Selesai</label>
                                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lama_hari">Lama Cuti (hari)</label>
                                        <input type="number" class="form-control @error('lama_hari') is-invalid @enderror" id="lama_hari" name="lama_hari" min="1" readonly required>
                                        @error('lama_hari')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alasan">Alasan Cuti</label>
                                    <select class="form-control @error('alasan') is-invalid @enderror" id="alasan" name="alasan" required>
                                        <option value="">-- Pilih Alasan Cuti --</option>
                                        <option value="cuti_tahunan">Cuti Tahunan</option>
                                        <option value="cuti_melahirkan">Cuti Melahirkan</option>
                                        <option value="ijin_sakit">Sakit</option>
                                        <option value="istri_meninggal">Istri / Suami Meninggal</option>
                                        <option value="orang_tua_meninggal">Orang Tua /Mertua Pegawai Meninggal</option>
                                        <option value="istri_melahirkan">Istri Pegawai Melahirkan</option>
                                        <option value="saudara_meninggal">Saudara Kandung Meninggal</option>
                                        <option value="keluarga_sakit">Istri / Suami/Anak Pegawai Sakit Keras</option>
                                        <option value="musibah">Mendapat Musibah Kebakaran/Kebajiran /Bencana Alam</option>
                                        <option value="menikah">Pegawai Menikah</option>
                                        <option value="anak_menikah">Pernikahan Anak Pegawai</option>
                                        <option value="saudara_menikah">Pernikahan Saudara Kandung Pegawai</option>
                                        <option value="khitan_anak">Mengkhitankan, Membaptis Anak Pegawai</option>
                                        <option value="haji">Melaksanakan Ibadah haji untuk yang pertama kali</option>
                                        <option value="ibadah_lainnya">Melaksanakan ibadah lainya diluar Ibadah Haji</option>
                                        <option value="panggilan_dinas">Mendapatkan panggilan Dinas</option>
                                        <option value="pemilu">Melaksanakan hak dalam Pemilu</option>
                                        <option value="seminar">Training, Seminar dan/atau  Lokakarya</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                    <!-- Input text untuk alasan lainnya -->
                                    <div id="alasanLainnya" style="display: none; margin-top: 10px;">
                                        <input type="text" class="form-control" name="alasan_lainnya" id="alasan_lainnya" placeholder="Masukkan alasan cuti lainnya">
                                    </div>
                                @error('alasan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat_cuti">Alamat Selama Cuti</label>
                                <textarea class="form-control @error('alamat_cuti') is-invalid @enderror" id="alamat_cuti" name="alamat_cuti" rows="2" required></textarea>
                                @error('alamat_cuti')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="telepon">Telepon/HP</label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" rows="2" required></input>
                                @error('telepon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Ajukan Cuti
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
                    $('#nip').val(data.nip || '-');
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
            $('#jabatan').val('');
            $('#unit_kerja').val('');
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Select2 untuk alasan
        $('#jenis_cuti').select2({
            placeholder: "-- Pilih Jenis Cuti --"
        });
    });
    
    document.addEventListener('DOMContentLoaded', function () {
        const tanggalMulai = document.getElementById('tanggal_mulai');
        const tanggalSelesai = document.getElementById('tanggal_selesai');
        const lamaCuti = document.getElementById('lama_hari');

        function hitungLamaCuti() {
            const mulai = new Date(tanggalMulai.value);
            const selesai = new Date(tanggalSelesai.value);

            if (tanggalMulai.value && tanggalSelesai.value && selesai >= mulai) {
                const selisih = Math.floor((selesai - mulai) / (1000 * 60 * 60 * 24)) + 1;
                lamaCuti.value = selisih;
            } else {
                lamaCuti.value = '';
            }
        }

        tanggalMulai.addEventListener('change', hitungLamaCuti);
        tanggalSelesai.addEventListener('change', hitungLamaCuti);
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Select2 untuk alasan
        $('#alasan').select2({
            placeholder: "-- Pilih Alasan Cuti --"
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Select2 untuk alasan
        $('#alasan').select2({
            placeholder: "-- Pilih Alasan Cuti --"
        });

        // Event listener untuk perubahan nilai pada Select2
        $('#alasan').on('change', function() {
            const alasanLainnya = document.getElementById('alasanLainnya');
            
            if (this.value === 'lainnya') {
                alasanLainnya.style.display = 'block';
                document.getElementById('alasan_lainnya').required = true;
            } else {
                alasanLainnya.style.display = 'none';
                document.getElementById('alasan_lainnya').required = false;
            }
        });
    });
</script>
@endsection