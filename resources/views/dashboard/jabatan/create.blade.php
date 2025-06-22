@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Jabatan | <small>Tambah Jabatan</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('jabatan.index') }}">Riwayat Jabatan</a></li>
                            <li class="breadcrumb-item active">Tambah Jabatan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div><!-- End Jabatan create Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Fiklat Jabatan create -->
            <div class="container rounded shadow p-4">
                <form action="{{ route('jabatan.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="row mb-3">
                            <label for="pegawai_id" class="col-md-4 col-lg-3 col-form-label">1. Pegawai</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select" aria-label="Default select example" name="pegawai_id" id="pegawai_id" require>
                                    <option selected disabled>-- Pilih Pegawai --</option>
                                    @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}">{{ $pegawai->nip }} - {{ $pegawai->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="skpd" class="col-md-4 col-lg-3 col-form-label">2. SKPD</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="skpd" type="text" class="form-control @error('skpd') is-invalid @enderror" id="skpd" value="RSUD dr. Soeselo Slawi" disabled>
                                @error('skpd')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="unit_kerja" class="col-md-4 col-lg-3 col-form-label">3. Unit Kerja</label>
                            <div class="col-md-4 col-lg-9">
                                <select class="form-select" aria-label="Default select example" name="unit_kerja" id="unit_kerja" required>
                                    <option selected disabled>RSUD dr Soeselo Slawi</option>
                                    <option value="Direktur RSUD dr Soeselo" {{ old('unit_kerja')=='Direktur RSUD dr Soeselo' ? 'selected': '' }} >Direktur RSUD dr Soeselo</option>
                                    <option value="Wakil Direktur Pelayanan" {{ old('unit_kerja')=='Wakil Direktur Pelayanan' ? 'selected': '' }} >Wakil Direktur Pelayanan</option>
                                    <option value="Kepala Bidang Pelayanan Medis" {{ old('unit_kerja')=='Kepala Bidang Pelayanan Medis' ? 'selected': '' }} >Kepala Bidang Pelayanan Medis</option>
                                    <option value="Dokter Ahli Utama" {{ old('unit_kerja')=='Dokter Ahli Utama' ? 'selected': '' }} >Dokter Ahli Utama</option>
                                    <option value="Dokter Ahli Madya" {{ old('unit_kerja')=='Dokter Ahli Madya' ? 'selected': '' }} >Dokter Ahli Madya</option>
                                    <option value="Dokter Ahli Muda" {{ old('unit_kerja')=='Dokter Ahli Muda' ? 'selected': '' }} >Dokter Ahli Muda</option>
                                    <option value="Dokter Ahli Pertama" {{ old('unit_kerja')=='Dokter Ahli Pertama' ? 'selected': '' }} >Dokter Ahli Pertama</option>
                                    <option value="Dokter Gigi Ahli Madya " {{ old('unit_kerja')=='Dokter Gigi Ahli Madya ' ? 'selected': '' }} >Dokter Gigi Ahli Madya </option>
                                    <option value="Penata Kelola Layanan Kesehatan" {{ old('unit_kerja')=='Penata Kelola Layanan Kesehatan' ? 'selected': '' }} >Penata Kelola Layanan Kesehatan</option>
                                    <option value="Pengadministrasi Perkantoran" {{ old('unit_kerja')=='Pengadministrasi Perkantoran' ? 'selected': '' }} >Pengadministrasi Perkantoran</option>
                                    <option value="Kepala Bidang Pelayanan Keperawatan" {{ old('unit_kerja')=='Kepala Bidang Pelayanan Keperawatan' ? 'selected': '' }} >Kepala Bidang Pelayanan Keperawatan</option>
                                    <option value="Perawat Ahli Madya" {{ old('unit_kerja')=='Perawat Ahli Madya' ? 'selected': '' }} >Perawat Ahli Madya</option>
                                    <option value="Perawat Ahli Muda" {{ old('unit_kerja')=='Perawat Ahli Muda' ? 'selected': '' }} >Perawat Ahli Muda</option>
                                    <option value="Perawat Ahli Pertama" {{ old('unit_kerja')=='Perawat Ahli Pertama' ? 'selected': '' }} >Perawat Ahli Pertama</option>
                                    <option value="Perawat Penyelia" {{ old('unit_kerja')=='Perawat Penyelia' ? 'selected': '' }} >Perawat Penyelia</option>
                                    <option value="Perawat Mahir" {{ old('unit_kerja')=='Perawat Mahir' ? 'selected': '' }} >Perawat Mahir</option>
                                    <option value="Perawat Terampil" {{ old('unit_kerja')=='Perawat Terampil' ? 'selected': '' }} >Perawat Terampil</option>
                                    <option value="Terapis Gigi dan Mulut Mahir" {{ old('unit_kerja')=='Terapis Gigi dan Mulut Mahir' ? 'selected': '' }} >Terapis Gigi dan Mulut Mahir</option>
                                    <option value="Terapis Gigi dan Mulut Terampil" {{ old('unit_kerja')=='Terapis Gigi dan Mulut Terampil' ? 'selected': '' }} >Terapis Gigi dan Mulut Terampil</option>
                                    <option value="Bidan Ahli Madya" {{ old('unit_kerja')=='Bidan Ahli Madya' ? 'selected': '' }} >Bidan Ahli Madya</option>
                                    <option value="Bidan Ahli Muda" {{ old('unit_kerja')=='Bidan Ahli Muda' ? 'selected': '' }} >Bidan Ahli Muda</option>
                                    <option value="Bidan Ahli Pertama" {{ old('unit_kerja')=='Bidan Ahli Pertama' ? 'selected': '' }} >Bidan Ahli Pertama</option>
                                    <option value="Bidan Penyelia" {{ old('unit_kerja')=='Bidan Penyelia' ? 'selected': '' }} >Bidan Penyelia</option>
                                    <option value="Bidan Mahir" {{ old('unit_kerja')=='Bidan Mahir' ? 'selected': '' }} >Bidan Mahir</option>
                                    <option value="Bidan Terampil" {{ old('unit_kerja')=='Bidan Terampil' ? 'selected': '' }} >Bidan Terampil</option>
                                    <option value="Penata Kelola Layanan Kesehatan " {{ old('unit_kerja')=='Penata Kelola Layanan Kesehatan ' ? 'selected': '' }} >Penata Kelola Layanan Kesehatan </option>
                                    <option value="Pengelola Layanan Kesehatan" {{ old('unit_kerja')=='Pengelola Layanan Kesehatan' ? 'selected': '' }} >Pengelola Layanan Kesehatan</option>
                                    <option value="Pengadministrasi Perkantoran " {{ old('unit_kerja')=='Pengadministrasi Perkantoran ' ? 'selected': '' }} >Pengadministrasi Perkantoran </option>
                                    <option value="Operator Layanan Operasional " {{ old('unit_kerja')=='Operator Layanan Operasional ' ? 'selected': '' }} >Operator Layanan Operasional </option>
                                    <option value="Kepala Bidang Pelayanan Penunjang" {{ old('unit_kerja')=='Kepala Bidang Pelayanan Penunjang' ? 'selected': '' }} >Kepala Bidang Pelayanan Penunjang</option>
                                    <option value="Administrator Kesehatan Ahli Muda" {{ old('unit_kerja')=='Administrator Kesehatan Ahli Muda' ? 'selected': '' }} >Administrator Kesehatan Ahli Muda</option>
                                    <option value="Administrator Kesehatan Ahli Pertama" {{ old('unit_kerja')=='Administrator Kesehatan Ahli Pertama' ? 'selected': '' }} >Administrator Kesehatan Ahli Pertama</option>
                                    <option value="Apoteker Ahli Utama " {{ old('unit_kerja')=='Apoteker Ahli Utama ' ? 'selected': '' }} >Apoteker Ahli Utama </option>
                                    <option value="Apoteker Ahli Madya" {{ old('unit_kerja')=='Apoteker Ahli Madya' ? 'selected': '' }} >Apoteker Ahli Madya</option>
                                    <option value="Apoteker Ahli Pertama" {{ old('unit_kerja')=='Apoteker Ahli Pertama' ? 'selected': '' }} >Apoteker Ahli Pertama</option>
                                    <option value="Asisten Apoteker Penyelia" {{ old('unit_kerja')=='Asisten Apoteker Penyelia' ? 'selected': '' }} >Asisten Apoteker Penyelia</option>
                                    <option value="Asisten Apoteker Terampil" {{ old('unit_kerja')=='Asisten Apoteker Terampil' ? 'selected': '' }} >Asisten Apoteker Terampil</option>
                                    <option value="Nutrisionis Ahli Madya" {{ old('unit_kerja')=='Nutrisionis Ahli Madya' ? 'selected': '' }} >Nutrisionis Ahli Madya</option>
                                    <option value="Nutrisionis Ahli Pertama " {{ old('unit_kerja')=='Nutrisionis Ahli Pertama ' ? 'selected': '' }} >Nutrisionis Ahli Pertama </option>
                                    <option value="Nutrisionis Penyelia" {{ old('unit_kerja')=='Nutrisionis Penyelia' ? 'selected': '' }} >Nutrisionis Penyelia</option>
                                    <option value="Radiografer Ahli Madya " {{ old('unit_kerja')=='Radiografer Ahli Madya ' ? 'selected': '' }} >Radiografer Ahli Madya </option>
                                    <option value="Radiografer Ahli Muda " {{ old('unit_kerja')=='Radiografer Ahli Muda ' ? 'selected': '' }} >Radiografer Ahli Muda </option>
                                    <option value="Radiografer Ahli Pertama " {{ old('unit_kerja')=='Radiografer Ahli Pertama ' ? 'selected': '' }} >Radiografer Ahli Pertama </option>
                                    <option value="Radiografer Penyelia " {{ old('unit_kerja')=='Radiografer Penyelia ' ? 'selected': '' }} >Radiografer Penyelia </option>
                                    <option value="Radiografer Terampil " {{ old('unit_kerja')=='Radiografer Terampil ' ? 'selected': '' }} >Radiografer Terampil </option>
                                    <option value="Pranata Laboratorium Kesehatan Ahli Madya" {{ old('unit_kerja')=='Pranata Laboratorium Kesehatan Ahli Madya' ? 'selected': '' }} >Pranata Laboratorium Kesehatan Ahli Madya</option>
                                    <option value="Pranata Laboratorium Kesehatan Ahli Muda" {{ old('unit_kerja')=='Pranata Laboratorium Kesehatan Ahli Muda' ? 'selected': '' }} >Pranata Laboratorium Kesehatan Ahli Muda</option>
                                    <option value="Pranata Laboratorium Kesehatan Penyelia" {{ old('unit_kerja')=='Pranata Laboratorium Kesehatan Penyelia' ? 'selected': '' }} >Pranata Laboratorium Kesehatan Penyelia</option>
                                    <option value="Pranata Laboratorium Kesehatan Mahir" {{ old('unit_kerja')=='Pranata Laboratorium Kesehatan Mahir' ? 'selected': '' }} >Pranata Laboratorium Kesehatan Mahir</option>
                                    <option value="Pranata Laboratorium Kesehatan Terampil" {{ old('unit_kerja')=='Pranata Laboratorium Kesehatan Terampil' ? 'selected': '' }} >Pranata Laboratorium Kesehatan Terampil</option>
                                    <option value="Fisioterapis Ahli Madya" {{ old('unit_kerja')=='Fisioterapis Ahli Madya' ? 'selected': '' }} >Fisioterapis Ahli Madya</option>
                                    <option value="Fisioterapis Ahli Muda" {{ old('unit_kerja')=='Fisioterapis Ahli Muda' ? 'selected': '' }} >Fisioterapis Ahli Muda</option>
                                    <option value="Fisioterapis Ahli Pertama" {{ old('unit_kerja')=='Fisioterapis Ahli Pertama' ? 'selected': '' }} >Fisioterapis Ahli Pertama</option>
                                    <option value="Fisioterapis Penyelia" {{ old('unit_kerja')=='Fisioterapis Penyelia' ? 'selected': '' }} >Fisioterapis Penyelia</option>
                                    <option value="Fisioterapis Terampil" {{ old('unit_kerja')=='Fisioterapis Terampil' ? 'selected': '' }} >Fisioterapis Terampil</option>
                                    <option value="Refraksionis Optisien Penyelia" {{ old('unit_kerja')=='Refraksionis Optisien Penyelia' ? 'selected': '' }} >Refraksionis Optisien Penyelia</option>
                                    <option value="Refraksionis Optisien Mahir" {{ old('unit_kerja')=='Refraksionis Optisien Mahir' ? 'selected': '' }} >Refraksionis Optisien Mahir</option>
                                    <option value="Perekam Medis Penyelia" {{ old('unit_kerja')=='Perekam Medis Penyelia' ? 'selected': '' }} >Perekam Medis Penyelia</option>
                                    <option value="Perekam Medis Mahir" {{ old('unit_kerja')=='Perekam Medis Mahir' ? 'selected': '' }} >Perekam Medis Mahir</option>
                                    <option value="Perekam Medis Terampil" {{ old('unit_kerja')=='Perekam Medis Terampil' ? 'selected': '' }} >Perekam Medis Terampil</option>
                                    <option value="Okupasi Terapis Mahir" {{ old('unit_kerja')=='Okupasi Terapis Mahir' ? 'selected': '' }} >Okupasi Terapis Mahir</option>
                                    <option value="Okupasi Terapis Terampil" {{ old('unit_kerja')=='Okupasi Terapis Terampil' ? 'selected': '' }} >Okupasi Terapis Terampil</option>
                                    <option value="Penata Anestesi Ahli Madya" {{ old('unit_kerja')=='Penata Anestesi Ahli Madya' ? 'selected': '' }} >Penata Anestesi Ahli Madya</option>
                                    <option value="Penata Anestesi Ahli Muda" {{ old('unit_kerja')=='Penata Anestesi Ahli Muda' ? 'selected': '' }} >Penata Anestesi Ahli Muda</option>
                                    <option value="Penata Anestesi Ahli Pertama" {{ old('unit_kerja')=='Penata Anestesi Ahli Pertama' ? 'selected': '' }} >Penata Anestesi Ahli Pertama</option>
                                    <option value="Asisten Penata Anestesi Penyelia" {{ old('unit_kerja')=='Asisten Penata Anestesi Penyelia' ? 'selected': '' }} >Asisten Penata Anestesi Penyelia</option>
                                    <option value="Asisten Penata Anestesi Terampil" {{ old('unit_kerja')=='Asisten Penata Anestesi Terampil' ? 'selected': '' }} >Asisten Penata Anestesi Terampil</option>
                                    <option value="Psikolog Klinis Ahli Pertama" {{ old('unit_kerja')=='Psikolog Klinis Ahli Pertama' ? 'selected': '' }} >Psikolog Klinis Ahli Pertama</option>
                                    <option value="Tenaga Sanitasi Lingkungan Ahli Madya " {{ old('unit_kerja')=='Tenaga Sanitasi Lingkungan Ahli Madya ' ? 'selected': '' }} >Tenaga Sanitasi Lingkungan Ahli Madya </option>
                                    <option value="Tenaga Sanitasi Lingkungan Ahli Muda" {{ old('unit_kerja')=='Tenaga Sanitasi Lingkungan Ahli Muda' ? 'selected': '' }} >Tenaga Sanitasi Lingkungan Ahli Muda</option>
                                    <option value="Tenaga Sanitasi Lingkungan Ahli Pertama" {{ old('unit_kerja')=='Tenaga Sanitasi Lingkungan Ahli Pertama' ? 'selected': '' }} >Tenaga Sanitasi Lingkungan Ahli Pertama</option>
                                    <option value="Tenaga Sanitasi Lingkungan Terampil" {{ old('unit_kerja')=='Tenaga Sanitasi Lingkungan Terampil' ? 'selected': '' }} >Tenaga Sanitasi Lingkungan Terampil</option>
                                    <option value="Teknisi Elektromedis Ahli Pertama" {{ old('unit_kerja')=='Teknisi Elektromedis Ahli Pertama' ? 'selected': '' }} >Teknisi Elektromedis Ahli Pertama</option>
                                    <option value="Teknisi Elektromedis Penyelia" {{ old('unit_kerja')=='Teknisi Elektromedis Penyelia' ? 'selected': '' }} >Teknisi Elektromedis Penyelia</option>
                                    <option value="Teknisi Elektromedis Mahir" {{ old('unit_kerja')=='Teknisi Elektromedis Mahir' ? 'selected': '' }} >Teknisi Elektromedis Mahir</option>
                                    <option value="Teknisi Elektromedis Terampil" {{ old('unit_kerja')=='Teknisi Elektromedis Terampil' ? 'selected': '' }} >Teknisi Elektromedis Terampil</option>
                                    <option value="Fisikawan Medis Ahli Pertama" {{ old('unit_kerja')=='Fisikawan Medis Ahli Pertama' ? 'selected': '' }} >Fisikawan Medis Ahli Pertama</option>
                                    <option value="Pembimbing Kesehatan Kerja Ahli Pertama" {{ old('unit_kerja')=='Pembimbing Kesehatan Kerja Ahli Pertama' ? 'selected': '' }} >Pembimbing Kesehatan Kerja Ahli Pertama</option>
                                    <option value="Teknisi Transfusi Darah Terampil" {{ old('unit_kerja')=='Teknisi Transfusi Darah Terampil' ? 'selected': '' }} >Teknisi Transfusi Darah Terampil</option>
                                    <option value="Terapis Wicara Mahir" {{ old('unit_kerja')=='Terapis Wicara Mahir' ? 'selected': '' }} >Terapis Wicara Mahir</option>
                                    <option value="Terapis Wicara Terampil" {{ old('unit_kerja')=='Terapis Wicara Terampil' ? 'selected': '' }} >Terapis Wicara Terampil</option>
                                    <option value="Ortotis Prostetis Terampil" {{ old('unit_kerja')=='Ortotis Prostetis Terampil' ? 'selected': '' }} >Ortotis Prostetis Terampil</option>
                                    <option value="Penata Kelola Layanan Kesehatan" {{ old('unit_kerja')=='Penata Kelola Layanan Kesehatan' ? 'selected': '' }} >Penata Kelola Layanan Kesehatan</option>
                                    <option value="Pengelola Layanan Operasional" {{ old('unit_kerja')=='Pengelola Layanan Operasional' ? 'selected': '' }} >Pengelola Layanan Operasional</option>
                                    <option value="Operator Layanan Kesehatan" {{ old('unit_kerja')=='Operator Layanan Kesehatan' ? 'selected': '' }} >Operator Layanan Kesehatan</option>
                                    <option value="Pengadministrasi Perkantoran" {{ old('unit_kerja')=='Pengadministrasi Perkantoran' ? 'selected': '' }} >Pengadministrasi Perkantoran</option>
                                    <option value="Pengelola Umum Operasional" {{ old('unit_kerja')=='Pengelola Umum Operasional' ? 'selected': '' }} >Pengelola Umum Operasional</option>
                                    <option value="Wakil Direktur Umum dan Keuangan" {{ old('unit_kerja')=='Wakil Direktur Umum dan Keuangan' ? 'selected': '' }} >Wakil Direktur Umum dan Keuangan</option>
                                    <option value="Kepala Bagian Tata Usaha" {{ old('unit_kerja')=='Kepala Bagian Tata Usaha' ? 'selected': '' }} >Kepala Bagian Tata Usaha</option>
                                    <option value="Kepala Subbagian Umum" {{ old('unit_kerja')=='Kepala Subbagian Umum' ? 'selected': '' }} >Kepala Subbagian Umum</option>
                                    <option value="Pranata Komputer Ahli Pertama" {{ old('unit_kerja')=='Pranata Komputer Ahli Pertama' ? 'selected': '' }} >Pranata Komputer Ahli Pertama</option>
                                    <option value="Penyuluh Kesehatan Masyarakat Ahli Pertama" {{ old('unit_kerja')=='Penyuluh Kesehatan Masyarakat Ahli Pertama' ? 'selected': '' }} >Penyuluh Kesehatan Masyarakat Ahli Pertama</option>
                                    <option value="Pranata Komputer Terampil " {{ old('unit_kerja')=='Pranata Komputer Terampil ' ? 'selected': '' }} >Pranata Komputer Terampil </option>
                                    <option value="Arsiparis Terampil" {{ old('unit_kerja')=='Arsiparis Terampil' ? 'selected': '' }} >Arsiparis Terampil</option>
                                    <option value="Penelaah Teknis Kebijakan" {{ old('unit_kerja')=='Penelaah Teknis Kebijakan' ? 'selected': '' }} >Penelaah Teknis Kebijakan</option>
                                    <option value="Penata Layanan Operasional" {{ old('unit_kerja')=='Penata Layanan Operasional' ? 'selected': '' }} >Penata Layanan Operasional</option>
                                    <option value="Pengelola Layanan Operasional" {{ old('unit_kerja')=='Pengelola Layanan Operasional' ? 'selected': '' }} >Pengelola Layanan Operasional</option>
                                    <option value="Pengolah Data dan Informasi" {{ old('unit_kerja')=='Pengolah Data dan Informasi' ? 'selected': '' }} >Pengolah Data dan Informasi</option>
                                    <option value="Dokumentalis Hukum" {{ old('unit_kerja')=='Dokumentalis Hukum' ? 'selected': '' }} >Dokumentalis Hukum</option>
                                    <option value="Pengadministrasi Perkantoran" {{ old('unit_kerja')=='Pengadministrasi Perkantoran' ? 'selected': '' }} >Pengadministrasi Perkantoran</option>
                                    <option value="Operator Layanan Operasiona" {{ old('unit_kerja')=='Operator Layanan Operasiona' ? 'selected': '' }} >Operator Layanan Operasiona</option>
                                    <option value="Kepala Subbagian Kepegawaian" {{ old('unit_kerja')=='Kepala Subbagian Kepegawaian' ? 'selected': '' }} >Kepala Subbagian Kepegawaian</option>
                                    <option value="Penata Layanan Operasional" {{ old('unit_kerja')=='Penata Layanan Operasional' ? 'selected': '' }} >Penata Layanan Operasional</option>
                                    <option value="Pengelola Layanan Operasional" {{ old('unit_kerja')=='Pengelola Layanan Operasional' ? 'selected': '' }} >Pengelola Layanan Operasional</option>
                                    <option value="Operator Layanan Operasional" {{ old('unit_kerja')=='Operator Layanan Operasional' ? 'selected': '' }} >Operator Layanan Operasional</option>
                                    <option value="Pengadministrasi Perkantoran" {{ old('unit_kerja')=='Pengadministrasi Perkantoran' ? 'selected': '' }} >Pengadministrasi Perkantoran</option>
                                    <option value="Kepala Bagian Keuangan" {{ old('unit_kerja')=='Kepala Bagian Keuangan' ? 'selected': '' }} >Kepala Bagian Keuangan</option>
                                    <option value="Analis Keuangan Pusat dan Daerah Ahli Muda" {{ old('unit_kerja')=='Analis Keuangan Pusat dan Daerah Ahli Muda' ? 'selected': '' }} >Analis Keuangan Pusat dan Daerah Ahli Muda</option>
                                    <option value="Analis Keuangan Pusat dan Daerah Ahli Pertama" {{ old('unit_kerja')=='Analis Keuangan Pusat dan Daerah Ahli Pertama' ? 'selected': '' }} >Analis Keuangan Pusat dan Daerah Ahli Pertama</option>
                                    <option value="Penelaah Teknis Kebijakan" {{ old('unit_kerja')=='Penelaah Teknis Kebijakan' ? 'selected': '' }} >Penelaah Teknis Kebijakan</option>
                                    <option value="Fasilitator Pemerintahan" {{ old('unit_kerja')=='Fasilitator Pemerintahan' ? 'selected': '' }} >Fasilitator Pemerintahan</option>
                                    <option value="Pengolah Data dan Informasi " {{ old('unit_kerja')=='Pengolah Data dan Informasi ' ? 'selected': '' }} >Pengolah Data dan Informasi </option>
                                    <option value="Operator Layanan Operasional " {{ old('unit_kerja')=='Operator Layanan Operasional ' ? 'selected': '' }} >Operator Layanan Operasional </option>
                                    <option value="Kepala Bagian Perencanaan" {{ old('unit_kerja')=='Kepala Bagian Perencanaan' ? 'selected': '' }} >Kepala Bagian Perencanaan</option>
                                    <option value="Perencana Ahli Pertama" {{ old('unit_kerja')=='Perencana Ahli Pertama' ? 'selected': '' }} >Perencana Ahli Pertama</option>
                                    <option value="Penelaah Teknis Kebijakan" {{ old('unit_kerja')=='Penelaah Teknis Kebijakan' ? 'selected': '' }} >Penelaah Teknis Kebijakan</option>
                                    <option value="Pengadministrasi Perkantoran" {{ old('unit_kerja')=='Pengadministrasi Perkantoran' ? 'selected': '' }} >Pengadministrasi Perkantoran</option>
                                </select>
                                @error('unit_kerja')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nama" class="col-md-4 col-lg-3 col-form-label">4. Pangkat</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nama" class="col-md-4 col-lg-3 col-form-label">4. Jabatan</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nama" class="col-md-4 col-lg-3 col-form-label">4. formasi Jabatan</label>
                            <div class="col-md-4 col-lg-3">
                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 form-group">
                            <label for="jenis_kepegawaian" class="col-md-4 col-lg-3 col-form-label">5. Jenis Kepegawaian</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-select" aria-label="Default select example" name="jenis_kepegawaian" id="jenis_kepegawaian" required>
                                    <option selected disabled>...</option>
                                    <option value="PNS" {{ old('jenis_kepegawaian')=='PNS' ? 'selected': '' }} >1. PNS</option>
                                    <option value="PPPK" {{ old('jenis_kepegawaian')=='PPPK' ? 'selected': '' }} >2. PPPK</option>
                                    <option value="CPNS" {{ old('jenis_kepegawaian')=='CPNS' ? 'selected': '' }} >3. CPNS</option>
                                    <option value="BLUD" {{ old('jenis_kepegawaian')=='BLUD' ? 'selected': '' }} >4. BLUD</option>
                                    <option value="Mitra" {{ old('jenis_kepegawaian')=='Mitra' ? 'selected': '' }} >5. Mitra</option>
                                    <option value="Ahli Daya" {{ old('jenis_kepegawaian')=='Ahli Daya' ? 'selected': '' }} >6. Ahli Daya</option>
                                </select>
                            </div>
                            @error('jenis_kepegawaian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3 form-group">
                            <label for="jenis_jabatan" class="col-md-4 col-lg-3 col-form-label">6. Jenis Jabatan</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-select" aria-label="Default select example" name="jenis_jabatan" id="jenis_jabatan">
                                    <option selected disabled>...</option>
                                    <option value="Struktural" {{ old('jenis_jabatan')=='Struktural' ? 'selected': '' }} >1. Struktural</option>
                                    <option value="Fungsional" {{ old('jenis_jabatan')=='Fungsional' ? 'selected': '' }} >2. Fungsional</option>
                                    <option value="Fungsional Pelaksana" {{ old('jenis_jabatan')=='Fungsional Pelaksana' ? 'selected': '' }} >3. Fungsional Pelaksana</option>
                                    <option value="Tenaga Ahli Daya" {{ old('jenis_jabatan')=='Tenaga Ahli Daya' ? 'selected': '' }} >4. Tenaga Ahli Daya</option>
                                    <option value="Tenaga Mitra" {{ old('jenis_jabatan')=='Tenaga Mitra' ? 'selected': '' }} >5. Tenaga Mitra</option>
                                </select>
                            </div>
                            @error('jenis_jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3 form-group">
                            <label for="status" class="col-md-4 col-lg-3 col-form-label">7. Status Hukum</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-select" aria-label="Default select example" name="status" id="status">
                                    <option selected disabled>...</option>
                                    <option value="Aktif" {{ old('status')=='Aktif' ? 'selected': '' }} >1. Aktif</option>
                                    <option value="CLTN" {{ old('status')=='CLTN' ? 'selected': '' }} >2. CLTN</option>
                                    <option value="Tugas Belajar" {{ old('status')=='Tugas Belajar' ? 'selected': '' }} >3. Tugas Belajar</option>
                                    <option value="Pemberhentian sementara" {{ old('status')=='Pemberhentian sementara' ? 'selected': '' }} >4. Pemberhentian sementara</option>
                                    <option value="Penerima Uang Tunggu" {{ old('status')=='Penerima Uang Tunggu' ? 'selected': '' }} >5. Penerima Uang Tunggu</option>
                                    <option value="Wajib Militer" {{ old('status')=='Wajib Militer' ? 'selected': '' }} >6. Wajib Militer</option>
                                    <option value="Pejabat Negara" {{ old('status')=='Pejabat Negara' ? 'selected': '' }} >7. Pejabat Negara</option>
                                    <option value="Proses Banding BAPEK" {{ old('status')=='Proses Banding BAPEK' ? 'selected': '' }} >8. Proses Banding BAPEK</option>
                                    <option value="Masa Persiapan Pensiun" {{ old('status')=='Masa Persiapan Pensiun' ? 'selected': '' }} >9. Masa Persiapan Pensiun</option>
                                    <option value="Pensiun" {{ old('status')=='Pensiun' ? 'selected': '' }} >10. Pensiun</option>
                                    <option value="Calon CPNS" {{ old('status')=='Calon CPNS' ? 'selected': '' }} >11. Calon CPNS</option>
                                    <option value="Hukuman Disiplin" {{ old('status')=='Hukuman Disiplin' ? 'selected': '' }} >12. Hukuman Disiplin</option>
                                </select>
                            </div>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <label for="tmt" class="col-md-4 col-lg-3 col-form-label">8. TMT</label>
                            <div class="col-md-4 col-lg-3">
                                <input name="tmt" type="text" class="form-control @error('tmt') is-invalid @enderror" id="tmt" value="{{ old('tmt') }}" required>
                                @error('tmt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        

                        <div class="row mb-3">
                            <label for="eselon" class="col-md-4 col-lg-3 col-form-label">9. Eselon</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-select" aria-label="Default select example" name="eselon" id="eselon" required>
                                    <option selected>...</option>
                                    <option value="II.b" {{ old('eselon')=='II.b' ? 'selected': '' }} >II.b</option>
                                    <option value="III.a" {{ old('eselon')=='III.a' ? 'selected': '' }} >III.a</option>
                                    <option value="III.b" {{ old('eselon')=='III.b' ? 'selected': '' }} >III.b</option>
                                    <option value="IV.a" {{ old('eselon')=='IV.a' ? 'selected': '' }} >IV.a</option>
                                    <option value="IV.b" {{ old('eselon')=='IV.b' ? 'selected': '' }} >IV.b</option>
                                    <option value="Kepala Instalasi" {{ old('eselon')=='Kepala Instalasi' ? 'selected': '' }} >Kepala Instalasi</option>
                                    <option value="Kepala Ruang" {{ old('eselon')=='Kepala Ruang' ? 'selected': '' }} >Kepala Ruang</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            <div class="text-center p-2">
                                <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> save</button>
                            </div>
                            <div class="text-center p-2">
                                <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-arrow-90deg-left"></i> cancel</button>
                            </div>
                        </div>
                    </form>
            </div><!-- End Jabatan create -->

        </div>
        </section>

@endsection