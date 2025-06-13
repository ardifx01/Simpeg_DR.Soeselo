@extends('dashboard.layouts.main')

@section('main')
    <div class="pagetitle">
        <div class="row justify-content-between">
            <div class="col">
                <h1>Nominatif Pegawai</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Nominatif Pegawai</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Nominatif Pegawai Title -->

    <div class="py-4">
        <form action="{{ route('dashboard.nominatif.show') }}" method="POST">
        @csrf
            <div class="row">
                <!-- Filter Kiri -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <div class="row mb-3 form-group">
                            <label for="pegawai_id" class="col-md-4 col-lg-3 col-form-label">List Pegawai</label>
                            <div class="col-md-8 col-lg-9">
                            <select class="form-select" name="pegawai_id" id="pegawai_id">
                                <option value="">-- Pilihan --</option>
                                @foreach($allPegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}"
                                        {{ old('pegawai_id', request('pegawai_id')) == $pegawai->id ? 'selected' : '' }}>
                                        {{ $pegawai->nip }} - {{ $pegawai->nama }}
                                    </option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="row mb-3 form-group">
                            <label for="unit_kerja" class="col-md-4 col-lg-3 col-form-label">Unit Kerja</label>
                            <div class="col-md-6 col-lg-9">
                            <select class="form-select" aria-label="Default select example" name="unit_kerja" id="unit_kerja">
                                <option value="" selected>-- Pilihan --</option>
                                <option disabled>RSUD dr Soeselo Slawi</option>
                                <option value="Direktur RSUD dr Soeselo" {{ old('unit_kerja', request('unit_kerja'))=='Direktur RSUD dr Soeselo' ? 'selected': '' }} >Direktur RSUD dr Soeselo</option>
                                <option value="Wakil Direktur Pelayanan" {{ old('unit_kerja', request('unit_kerja'))=='Wakil Direktur Pelayanan' ? 'selected': '' }} >Wakil Direktur Pelayanan</option>
                                <option value="Kepala Bidang Pelayanan Medis" {{ old('unit_kerja', request('unit_kerja'))=='Kepala Bidang Pelayanan Medis' ? 'selected': '' }} >Kepala Bidang Pelayanan Medis</option>
                                <option value="Dokter Ahli Utama" {{ old('unit_kerja', request('unit_kerja'))=='Dokter Ahli Utama' ? 'selected': '' }} >Dokter Ahli Utama</option>
                                <option value="Dokter Ahli Madya" {{ old('unit_kerja', request('unit_kerja'))=='Dokter Ahli Madya' ? 'selected': '' }} >Dokter Ahli Madya</option>
                                <option value="Dokter Ahli Muda" {{ old('unit_kerja', request('unit_kerja'))=='Dokter Ahli Muda' ? 'selected': '' }} >Dokter Ahli Muda</option>
                                <option value="Dokter Ahli Pertama" {{ old('unit_kerja', request('unit_kerja'))=='Dokter Ahli Pertama' ? 'selected': '' }} >Dokter Ahli Pertama</option>
                                <option value="Dokter Gigi Ahli Madya " {{ old('unit_kerja', request('unit_kerja'))=='Dokter Gigi Ahli Madya ' ? 'selected': '' }} >Dokter Gigi Ahli Madya </option>
                                <option value="Penata Kelola Layanan Kesehatan" {{ old('unit_kerja', request('unit_kerja'))=='Penata Kelola Layanan Kesehatan' ? 'selected': '' }} >Penata Kelola Layanan Kesehatan</option>
                                <option value="Pengadministrasi Perkantoran" {{ old('unit_kerja', request('unit_kerja'))=='Pengadministrasi Perkantoran' ? 'selected': '' }} >Pengadministrasi Perkantoran</option>
                                <option value="Kepala Bidang Pelayanan Keperawatan" {{ old('unit_kerja', request('unit_kerja'))=='Kepala Bidang Pelayanan Keperawatan' ? 'selected': '' }} >Kepala Bidang Pelayanan Keperawatan</option>
                                <option value="Perawat Ahli Madya" {{ old('unit_kerja', request('unit_kerja'))=='Perawat Ahli Madya' ? 'selected': '' }} >Perawat Ahli Madya</option>
                                <option value="Perawat Ahli Muda" {{ old('unit_kerja', request('unit_kerja'))=='Perawat Ahli Muda' ? 'selected': '' }} >Perawat Ahli Muda</option>
                                <option value="Perawat Ahli Pertama" {{ old('unit_kerja', request('unit_kerja'))=='Perawat Ahli Pertama' ? 'selected': '' }} >Perawat Ahli Pertama</option>
                                <option value="Perawat Penyelia" {{ old('unit_kerja', request('unit_kerja'))=='Perawat Penyelia' ? 'selected': '' }} >Perawat Penyelia</option>
                                <option value="Perawat Mahir" {{ old('unit_kerja', request('unit_kerja'))=='Perawat Mahir' ? 'selected': '' }} >Perawat Mahir</option>
                                <option value="Perawat Terampil" {{ old('unit_kerja', request('unit_kerja'))=='Perawat Terampil' ? 'selected': '' }} >Perawat Terampil</option>
                                <option value="Terapis Gigi dan Mulut Mahir" {{ old('unit_kerja', request('unit_kerja'))=='Terapis Gigi dan Mulut Mahir' ? 'selected': '' }} >Terapis Gigi dan Mulut Mahir</option>
                                <option value="Terapis Gigi dan Mulut Terampil" {{ old('unit_kerja', request('unit_kerja'))=='Terapis Gigi dan Mulut Terampil' ? 'selected': '' }} >Terapis Gigi dan Mulut Terampil</option>
                                <option value="Bidan Ahli Madya" {{ old('unit_kerja', request('unit_kerja'))=='Bidan Ahli Madya' ? 'selected': '' }} >Bidan Ahli Madya</option>
                                <option value="Bidan Ahli Muda" {{ old('unit_kerja', request('unit_kerja'))=='Bidan Ahli Muda' ? 'selected': '' }} >Bidan Ahli Muda</option>
                                <option value="Bidan Ahli Pertama" {{ old('unit_kerja', request('unit_kerja'))=='Bidan Ahli Pertama' ? 'selected': '' }} >Bidan Ahli Pertama</option>
                                <option value="Bidan Penyelia" {{ old('unit_kerja', request('unit_kerja'))=='Bidan Penyelia' ? 'selected': '' }} >Bidan Penyelia</option>
                                <option value="Bidan Mahir" {{ old('unit_kerja', request('unit_kerja'))=='Bidan Mahir' ? 'selected': '' }} >Bidan Mahir</option>
                                <option value="Bidan Terampil" {{ old('unit_kerja', request('unit_kerja'))=='Bidan Terampil' ? 'selected': '' }} >Bidan Terampil</option>
                                <option value="Penata Kelola Layanan Kesehatan " {{ old('unit_kerja', request('unit_kerja'))=='Penata Kelola Layanan Kesehatan ' ? 'selected': '' }} >Penata Kelola Layanan Kesehatan </option>
                                <option value="Pengelola Layanan Kesehatan" {{ old('unit_kerja', request('unit_kerja'))=='Pengelola Layanan Kesehatan' ? 'selected': '' }} >Pengelola Layanan Kesehatan</option>
                                <option value="Pengadministrasi Perkantoran " {{ old('unit_kerja', request('unit_kerja'))=='Pengadministrasi Perkantoran ' ? 'selected': '' }} >Pengadministrasi Perkantoran </option>
                                <option value="Operator Layanan Operasional " {{ old('unit_kerja', request('unit_kerja'))=='Operator Layanan Operasional ' ? 'selected': '' }} >Operator Layanan Operasional </option>
                                <option value="Kepala Bidang Pelayanan Penunjang" {{ old('unit_kerja', request('unit_kerja'))=='Kepala Bidang Pelayanan Penunjang' ? 'selected': '' }} >Kepala Bidang Pelayanan Penunjang</option>
                                <option value="Administrator Kesehatan Ahli Muda" {{ old('unit_kerja', request('unit_kerja'))=='Administrator Kesehatan Ahli Muda' ? 'selected': '' }} >Administrator Kesehatan Ahli Muda</option>
                                <option value="Administrator Kesehatan Ahli Pertama" {{ old('unit_kerja', request('unit_kerja'))=='Administrator Kesehatan Ahli Pertama' ? 'selected': '' }} >Administrator Kesehatan Ahli Pertama</option>
                                <option value="Apoteker Ahli Utama " {{ old('unit_kerja', request('unit_kerja'))=='Apoteker Ahli Utama ' ? 'selected': '' }} >Apoteker Ahli Utama </option>
                                <option value="Apoteker Ahli Madya" {{ old('unit_kerja', request('unit_kerja'))=='Apoteker Ahli Madya' ? 'selected': '' }} >Apoteker Ahli Madya</option>
                                <option value="Apoteker Ahli Pertama" {{ old('unit_kerja', request('unit_kerja'))=='Apoteker Ahli Pertama' ? 'selected': '' }} >Apoteker Ahli Pertama</option>
                                <option value="Asisten Apoteker Penyelia" {{ old('unit_kerja', request('unit_kerja'))=='Asisten Apoteker Penyelia' ? 'selected': '' }} >Asisten Apoteker Penyelia</option>
                                <option value="Asisten Apoteker Terampil" {{ old('unit_kerja', request('unit_kerja'))=='Asisten Apoteker Terampil' ? 'selected': '' }} >Asisten Apoteker Terampil</option>
                                <option value="Nutrisionis Ahli Madya" {{ old('unit_kerja', request('unit_kerja'))=='Nutrisionis Ahli Madya' ? 'selected': '' }} >Nutrisionis Ahli Madya</option>
                                <option value="Nutrisionis Ahli Pertama " {{ old('unit_kerja', request('unit_kerja'))=='Nutrisionis Ahli Pertama ' ? 'selected': '' }} >Nutrisionis Ahli Pertama </option>
                                <option value="Nutrisionis Penyelia" {{ old('unit_kerja', request('unit_kerja'))=='Nutrisionis Penyelia' ? 'selected': '' }} >Nutrisionis Penyelia</option>
                                <option value="Radiografer Ahli Madya " {{ old('unit_kerja', request('unit_kerja'))=='Radiografer Ahli Madya ' ? 'selected': '' }} >Radiografer Ahli Madya </option>
                                <option value="Radiografer Ahli Muda " {{ old('unit_kerja', request('unit_kerja'))=='Radiografer Ahli Muda ' ? 'selected': '' }} >Radiografer Ahli Muda </option>
                                <option value="Radiografer Ahli Pertama " {{ old('unit_kerja', request('unit_kerja'))=='Radiografer Ahli Pertama ' ? 'selected': '' }} >Radiografer Ahli Pertama </option>
                                <option value="Radiografer Penyelia " {{ old('unit_kerja', request('unit_kerja'))=='Radiografer Penyelia ' ? 'selected': '' }} >Radiografer Penyelia </option>
                                <option value="Radiografer Terampil " {{ old('unit_kerja', request('unit_kerja'))=='Radiografer Terampil ' ? 'selected': '' }} >Radiografer Terampil </option>
                                <option value="Pranata Laboratorium Kesehatan Ahli Madya" {{ old('unit_kerja', request('unit_kerja'))=='Pranata Laboratorium Kesehatan Ahli Madya' ? 'selected': '' }} >Pranata Laboratorium Kesehatan Ahli Madya</option>
                                <option value="Pranata Laboratorium Kesehatan Ahli Muda" {{ old('unit_kerja', request('unit_kerja'))=='Pranata Laboratorium Kesehatan Ahli Muda' ? 'selected': '' }} >Pranata Laboratorium Kesehatan Ahli Muda</option>
                                <option value="Pranata Laboratorium Kesehatan Penyelia" {{ old('unit_kerja', request('unit_kerja'))=='Pranata Laboratorium Kesehatan Penyelia' ? 'selected': '' }} >Pranata Laboratorium Kesehatan Penyelia</option>
                                <option value="Pranata Laboratorium Kesehatan Mahir" {{ old('unit_kerja', request('unit_kerja'))=='Pranata Laboratorium Kesehatan Mahir' ? 'selected': '' }} >Pranata Laboratorium Kesehatan Mahir</option>
                                <option value="Pranata Laboratorium Kesehatan Terampil" {{ old('unit_kerja', request('unit_kerja'))=='Pranata Laboratorium Kesehatan Terampil' ? 'selected': '' }} >Pranata Laboratorium Kesehatan Terampil</option>
                                <option value="Fisioterapis Ahli Madya" {{ old('unit_kerja', request('unit_kerja'))=='Fisioterapis Ahli Madya' ? 'selected': '' }} >Fisioterapis Ahli Madya</option>
                                <option value="Fisioterapis Ahli Muda" {{ old('unit_kerja', request('unit_kerja'))=='Fisioterapis Ahli Muda' ? 'selected': '' }} >Fisioterapis Ahli Muda</option>
                                <option value="Fisioterapis Ahli Pertama" {{ old('unit_kerja', request('unit_kerja'))=='Fisioterapis Ahli Pertama' ? 'selected': '' }} >Fisioterapis Ahli Pertama</option>
                                <option value="Fisioterapis Penyelia" {{ old('unit_kerja', request('unit_kerja'))=='Fisioterapis Penyelia' ? 'selected': '' }} >Fisioterapis Penyelia</option>
                                <option value="Fisioterapis Terampil" {{ old('unit_kerja', request('unit_kerja'))=='Fisioterapis Terampil' ? 'selected': '' }} >Fisioterapis Terampil</option>
                                <option value="Refraksionis Optisien Penyelia" {{ old('unit_kerja', request('unit_kerja'))=='Refraksionis Optisien Penyelia' ? 'selected': '' }} >Refraksionis Optisien Penyelia</option>
                                <option value="Refraksionis Optisien Mahir" {{ old('unit_kerja', request('unit_kerja'))=='Refraksionis Optisien Mahir' ? 'selected': '' }} >Refraksionis Optisien Mahir</option>
                                <option value="Perekam Medis Penyelia" {{ old('unit_kerja', request('unit_kerja'))=='Perekam Medis Penyelia' ? 'selected': '' }} >Perekam Medis Penyelia</option>
                                <option value="Perekam Medis Mahir" {{ old('unit_kerja', request('unit_kerja'))=='Perekam Medis Mahir' ? 'selected': '' }} >Perekam Medis Mahir</option>
                                <option value="Perekam Medis Terampil" {{ old('unit_kerja', request('unit_kerja'))=='Perekam Medis Terampil' ? 'selected': '' }} >Perekam Medis Terampil</option>
                                <option value="Okupasi Terapis Mahir" {{ old('unit_kerja', request('unit_kerja'))=='Okupasi Terapis Mahir' ? 'selected': '' }} >Okupasi Terapis Mahir</option>
                                <option value="Okupasi Terapis Terampil" {{ old('unit_kerja', request('unit_kerja'))=='Okupasi Terapis Terampil' ? 'selected': '' }} >Okupasi Terapis Terampil</option>
                                <option value="Penata Anestesi Ahli Madya" {{ old('unit_kerja', request('unit_kerja'))=='Penata Anestesi Ahli Madya' ? 'selected': '' }} >Penata Anestesi Ahli Madya</option>
                                <option value="Penata Anestesi Ahli Muda" {{ old('unit_kerja', request('unit_kerja'))=='Penata Anestesi Ahli Muda' ? 'selected': '' }} >Penata Anestesi Ahli Muda</option>
                                <option value="Penata Anestesi Ahli Pertama" {{ old('unit_kerja', request('unit_kerja'))=='Penata Anestesi Ahli Pertama' ? 'selected': '' }} >Penata Anestesi Ahli Pertama</option>
                                <option value="Asisten Penata Anestesi Penyelia" {{ old('unit_kerja', request('unit_kerja'))=='Asisten Penata Anestesi Penyelia' ? 'selected': '' }} >Asisten Penata Anestesi Penyelia</option>
                                <option value="Asisten Penata Anestesi Terampil" {{ old('unit_kerja', request('unit_kerja'))=='Asisten Penata Anestesi Terampil' ? 'selected': '' }} >Asisten Penata Anestesi Terampil</option>
                                <option value="Psikolog Klinis Ahli Pertama" {{ old('unit_kerja', request('unit_kerja'))=='Psikolog Klinis Ahli Pertama' ? 'selected': '' }} >Psikolog Klinis Ahli Pertama</option>
                                <option value="Tenaga Sanitasi Lingkungan Ahli Madya " {{ old('unit_kerja', request('unit_kerja'))=='Tenaga Sanitasi Lingkungan Ahli Madya ' ? 'selected': '' }} >Tenaga Sanitasi Lingkungan Ahli Madya </option>
                                <option value="Tenaga Sanitasi Lingkungan Ahli Muda" {{ old('unit_kerja', request('unit_kerja'))=='Tenaga Sanitasi Lingkungan Ahli Muda' ? 'selected': '' }} >Tenaga Sanitasi Lingkungan Ahli Muda</option>
                                <option value="Tenaga Sanitasi Lingkungan Ahli Pertama" {{ old('unit_kerja', request('unit_kerja'))=='Tenaga Sanitasi Lingkungan Ahli Pertama' ? 'selected': '' }} >Tenaga Sanitasi Lingkungan Ahli Pertama</option>
                                <option value="Tenaga Sanitasi Lingkungan Terampil" {{ old('unit_kerja', request('unit_kerja'))=='Tenaga Sanitasi Lingkungan Terampil' ? 'selected': '' }} >Tenaga Sanitasi Lingkungan Terampil</option>
                                <option value="Teknisi Elektromedis Ahli Pertama" {{ old('unit_kerja', request('unit_kerja'))=='Teknisi Elektromedis Ahli Pertama' ? 'selected': '' }} >Teknisi Elektromedis Ahli Pertama</option>
                                <option value="Teknisi Elektromedis Penyelia" {{ old('unit_kerja', request('unit_kerja'))=='Teknisi Elektromedis Penyelia' ? 'selected': '' }} >Teknisi Elektromedis Penyelia</option>
                                <option value="Teknisi Elektromedis Mahir" {{ old('unit_kerja', request('unit_kerja'))=='Teknisi Elektromedis Mahir' ? 'selected': '' }} >Teknisi Elektromedis Mahir</option>
                                <option value="Teknisi Elektromedis Terampil" {{ old('unit_kerja', request('unit_kerja'))=='Teknisi Elektromedis Terampil' ? 'selected': '' }} >Teknisi Elektromedis Terampil</option>
                                <option value="Fisikawan Medis Ahli Pertama" {{ old('unit_kerja', request('unit_kerja'))=='Fisikawan Medis Ahli Pertama' ? 'selected': '' }} >Fisikawan Medis Ahli Pertama</option>
                                <option value="Pembimbing Kesehatan Kerja Ahli Pertama" {{ old('unit_kerja', request('unit_kerja'))=='Pembimbing Kesehatan Kerja Ahli Pertama' ? 'selected': '' }} >Pembimbing Kesehatan Kerja Ahli Pertama</option>
                                <option value="Teknisi Transfusi Darah Terampil" {{ old('unit_kerja', request('unit_kerja'))=='Teknisi Transfusi Darah Terampil' ? 'selected': '' }} >Teknisi Transfusi Darah Terampil</option>
                                <option value="Terapis Wicara Mahir" {{ old('unit_kerja', request('unit_kerja'))=='Terapis Wicara Mahir' ? 'selected': '' }} >Terapis Wicara Mahir</option>
                                <option value="Terapis Wicara Terampil" {{ old('unit_kerja', request('unit_kerja'))=='Terapis Wicara Terampil' ? 'selected': '' }} >Terapis Wicara Terampil</option>
                                <option value="Ortotis Prostetis Terampil" {{ old('unit_kerja', request('unit_kerja'))=='Ortotis Prostetis Terampil' ? 'selected': '' }} >Ortotis Prostetis Terampil</option>
                                <option value="Penata Kelola Layanan Kesehatan" {{ old('unit_kerja', request('unit_kerja'))=='Penata Kelola Layanan Kesehatan' ? 'selected': '' }} >Penata Kelola Layanan Kesehatan</option>
                                <option value="Pengelola Layanan Operasional" {{ old('unit_kerja', request('unit_kerja'))=='Pengelola Layanan Operasional' ? 'selected': '' }} >Pengelola Layanan Operasional</option>
                                <option value="Operator Layanan Kesehatan" {{ old('unit_kerja', request('unit_kerja'))=='Operator Layanan Kesehatan' ? 'selected': '' }} >Operator Layanan Kesehatan</option>
                                <option value="Pengadministrasi Perkantoran" {{ old('unit_kerja', request('unit_kerja'))=='Pengadministrasi Perkantoran' ? 'selected': '' }} >Pengadministrasi Perkantoran</option>
                                <option value="Pengelola Umum Operasional" {{ old('unit_kerja', request('unit_kerja'))=='Pengelola Umum Operasional' ? 'selected': '' }} >Pengelola Umum Operasional</option>
                                <option value="Wakil Direktur Umum dan Keuangan" {{ old('unit_kerja', request('unit_kerja'))=='Wakil Direktur Umum dan Keuangan' ? 'selected': '' }} >Wakil Direktur Umum dan Keuangan</option>
                                <option value="Kepala Bagian Tata Usaha" {{ old('unit_kerja', request('unit_kerja'))=='Kepala Bagian Tata Usaha' ? 'selected': '' }} >Kepala Bagian Tata Usaha</option>
                                <option value="Kepala Subbagian Umum" {{ old('unit_kerja', request('unit_kerja'))=='Kepala Subbagian Umum' ? 'selected': '' }} >Kepala Subbagian Umum</option>
                                <option value="Pranata Komputer Ahli Pertama" {{ old('unit_kerja', request('unit_kerja'))=='Pranata Komputer Ahli Pertama' ? 'selected': '' }} >Pranata Komputer Ahli Pertama</option>
                                <option value="Penyuluh Kesehatan Masyarakat Ahli Pertama" {{ old('unit_kerja', request('unit_kerja'))=='Penyuluh Kesehatan Masyarakat Ahli Pertama' ? 'selected': '' }} >Penyuluh Kesehatan Masyarakat Ahli Pertama</option>
                                <option value="Pranata Komputer Terampil " {{ old('unit_kerja', request('unit_kerja'))=='Pranata Komputer Terampil ' ? 'selected': '' }} >Pranata Komputer Terampil </option>
                                <option value="Arsiparis Terampil" {{ old('unit_kerja', request('unit_kerja'))=='Arsiparis Terampil' ? 'selected': '' }} >Arsiparis Terampil</option>
                                <option value="Penelaah Teknis Kebijakan" {{ old('unit_kerja', request('unit_kerja'))=='Penelaah Teknis Kebijakan' ? 'selected': '' }} >Penelaah Teknis Kebijakan</option>
                                <option value="Penata Layanan Operasional" {{ old('unit_kerja', request('unit_kerja'))=='Penata Layanan Operasional' ? 'selected': '' }} >Penata Layanan Operasional</option>
                                <option value="Pengelola Layanan Operasional" {{ old('unit_kerja', request('unit_kerja'))=='Pengelola Layanan Operasional' ? 'selected': '' }} >Pengelola Layanan Operasional</option>
                                <option value="Pengolah Data dan Informasi" {{ old('unit_kerja', request('unit_kerja'))=='Pengolah Data dan Informasi' ? 'selected': '' }} >Pengolah Data dan Informasi</option>
                                <option value="Dokumentalis Hukum" {{ old('unit_kerja', request('unit_kerja'))=='Dokumentalis Hukum' ? 'selected': '' }} >Dokumentalis Hukum</option>
                                <option value="Pengadministrasi Perkantoran" {{ old('unit_kerja', request('unit_kerja'))=='Pengadministrasi Perkantoran' ? 'selected': '' }} >Pengadministrasi Perkantoran</option>
                                <option value="Operator Layanan Operasiona" {{ old('unit_kerja', request('unit_kerja'))=='Operator Layanan Operasiona' ? 'selected': '' }} >Operator Layanan Operasiona</option>
                                <option value="Kepala Subbagian Kepegawaian" {{ old('unit_kerja', request('unit_kerja'))=='Kepala Subbagian Kepegawaian' ? 'selected': '' }} >Kepala Subbagian Kepegawaian</option>
                                <option value="Penata Layanan Operasional" {{ old('unit_kerja', request('unit_kerja'))=='Penata Layanan Operasional' ? 'selected': '' }} >Penata Layanan Operasional</option>
                                <option value="Pengelola Layanan Operasional" {{ old('unit_kerja', request('unit_kerja'))=='Pengelola Layanan Operasional' ? 'selected': '' }} >Pengelola Layanan Operasional</option>
                                <option value="Operator Layanan Operasional" {{ old('unit_kerja', request('unit_kerja'))=='Operator Layanan Operasional' ? 'selected': '' }} >Operator Layanan Operasional</option>
                                <option value="Pengadministrasi Perkantoran" {{ old('unit_kerja', request('unit_kerja'))=='Pengadministrasi Perkantoran' ? 'selected': '' }} >Pengadministrasi Perkantoran</option>
                                <option value="Kepala Bagian Keuangan" {{ old('unit_kerja', request('unit_kerja'))=='Kepala Bagian Keuangan' ? 'selected': '' }} >Kepala Bagian Keuangan</option>
                                <option value="Analis Keuangan Pusat dan Daerah Ahli Muda" {{ old('unit_kerja', request('unit_kerja'))=='Analis Keuangan Pusat dan Daerah Ahli Muda' ? 'selected': '' }} >Analis Keuangan Pusat dan Daerah Ahli Muda</option>
                                <option value="Analis Keuangan Pusat dan Daerah Ahli Pertama" {{ old('unit_kerja', request('unit_kerja'))=='Analis Keuangan Pusat dan Daerah Ahli Pertama' ? 'selected': '' }} >Analis Keuangan Pusat dan Daerah Ahli Pertama</option>
                                <option value="Penelaah Teknis Kebijakan" {{ old('unit_kerja', request('unit_kerja'))=='Penelaah Teknis Kebijakan' ? 'selected': '' }} >Penelaah Teknis Kebijakan</option>
                                <option value="Fasilitator Pemerintahan" {{ old('unit_kerja', request('unit_kerja'))=='Fasilitator Pemerintahan' ? 'selected': '' }} >Fasilitator Pemerintahan</option>
                                <option value="Pengolah Data dan Informasi " {{ old('unit_kerja', request('unit_kerja'))=='Pengolah Data dan Informasi ' ? 'selected': '' }} >Pengolah Data dan Informasi </option>
                                <option value="Operator Layanan Operasional " {{ old('unit_kerja', request('unit_kerja'))=='Operator Layanan Operasional ' ? 'selected': '' }} >Operator Layanan Operasional </option>
                                <option value="Kepala Bagian Perencanaan" {{ old('unit_kerja', request('unit_kerja'))=='Kepala Bagian Perencanaan' ? 'selected': '' }} >Kepala Bagian Perencanaan</option>
                                <option value="Perencana Ahli Pertama" {{ old('unit_kerja', request('unit_kerja'))=='Perencana Ahli Pertama' ? 'selected': '' }} >Perencana Ahli Pertama</option>
                                <option value="Penelaah Teknis Kebijakan" {{ old('unit_kerja', request('unit_kerja'))=='Penelaah Teknis Kebijakan' ? 'selected': '' }} >Penelaah Teknis Kebijakan</option>
                                <option value="Pengadministrasi Perkantoran" {{ old('unit_kerja', request('unit_kerja'))=='Pengadministrasi Perkantoran' ? 'selected': '' }} >Pengadministrasi Perkantoran</option>
                            </select>
                            @error('unit_kerja')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="row mb-3 form-group">
                            <label for="jenis_jabatan" class="col-md-4 col-lg-3 col-form-label">Jenis Jabatan</label>
                            <div class="col-md-6 col-lg-9">
                                <select class="form-select" name="jenis_jabatan" id="jenis_jabatan">
                                    <option value="" selected>-- pilihan --</option>
                                    <option value="Struktural" {{ old('jenis_jabatan', request('jenis_jabatan'))=='Struktural' ? 'selected': '' }}>Struktural</option>
                                    <option value="Fungsional Khusus" {{ old('jenis_jabatan', request('jenis_jabatan'))=='Fungsional Khusus' ? 'selected': '' }}>Fungsional Khusus</option>
                                    <option value="Fungsional Umum" {{ old('jenis_jabatan', request('jenis_jabatan'))=='Fungsional Umum' ? 'selected': '' }}>Fungsional Umum</option>
                                    <option value="Sekretaris Desa" {{ old('jenis_jabatan', request('jenis_jabatan'))=='Sekretaris Desa' ? 'selected': '' }}>Sekretaris Desa</option>
                                </select>
                            </div>
                            @error('jenis_jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="row mb-3 form-group">
                            <label for="golongan_dari" class="col-md-4 col-lg-3 col-form-label">Golongan</label>
                            <div class="col-md-6 col-lg-4">
                                <select class="form-select" aria-label="Default select example" name="golongan_dari" id="golongan_dari">
                                    <option value="" selected>-- pilihan --</option>
                                    <option value="I/a" {{ old('golongan_dari', request('golongan_dari'))=='I/a' ? 'selected': '' }} >I/a</option>
                                    <option value="I/b" {{ old('golongan_dari', request('golongan_dari'))=='I/b' ? 'selected': '' }} >I/b</option>
                                    <option value="II/a" {{ old('golongan_dari', request('golongan_dari'))=='II/a' ? 'selected': '' }} >II/a</option>
                                    <option value="II/b" {{ old('golongan_dari', request('golongan_dari'))=='II/b' ? 'selected': '' }} >II/b</option>
                                    <option value="III/a" {{ old('golongan_dari', request('golongan_dari'))=='III/a' ? 'selected': '' }} >III/a</option>
                                    <option value="III/b" {{ old('golongan_dari', request('golongan_dari'))=='III/b' ? 'selected': '' }} >III/b</option>
                                    <option value="IV/a" {{ old('golongan_dari', request('golongan_dari'))=='IV/a' ? 'selected': '' }} >IV/a</option>
                                    <option value="IV/b" {{ old('golongan_dari', request('golongan_dari'))=='IV/b' ? 'selected': '' }} >IV/b</option>
                                    <option value="V" {{ old('golongan_dari', request('golongan_dari'))=='V' ? 'selected': '' }} >V</option>
                                </select>
                            @error('golongan_dari')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>
                            <div class="col-md-1 col-lg-1">
                                <label class="col-form-label">s/d</label>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <select class="form-select" aria-label="Default select example" name="golongan_sampai" id="golongan_sampai">
                                    <option value="" selected>-- pilihan --</option>
                                    <option value="I/a" {{ old('golongan_sampai', request('golongan_sampai'))=='I/a' ? 'selected': '' }} >I/a</option>
                                    <option value="I/b" {{ old('golongan_sampai', request('golongan_sampai'))=='I/b' ? 'selected': '' }} >I/b</option>
                                    <option value="II/a" {{ old('golongan_sampai', request('golongan_sampai'))=='II/a' ? 'selected': '' }} >II/a</option>
                                    <option value="II/b" {{ old('golongan_sampai', request('golongan_sampai'))=='II/b' ? 'selected': '' }} >II/b</option>
                                    <option value="III/a" {{ old('golongan_sampai', request('golongan_sampai'))=='III/a' ? 'selected': '' }} >III/a</option>
                                    <option value="III/b" {{ old('golongan_sampai', request('golongan_sampai'))=='III/b' ? 'selected': '' }} >III/b</option>
                                    <option value="IV/a" {{ old('golongan_sampai', request('golongan_sampai'))=='IV/a' ? 'selected': '' }} >IV/a</option>
                                    <option value="IV/b" {{ old('golongan_sampai', request('golongan_sampai'))=='IV/b' ? 'selected': '' }} >IV/b</option>
                                    <option value="V" {{ old('golongan_sampai', request('golongan_sampai'))=='V' ? 'selected': '' }} >V</option>
                                </select>
                            @error('golongan_sampai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="arah" value="keatas" {{ old('arah', request('arah', 'keatas')) == 'keatas' ? 'checked' : '' }} checked>
                            <label class="form-check-label">Keatas</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="arah" value="kebawah" {{ old('arah', request('arah')) == 'kebawah' ? 'checked' : '' }}>
                            <label class="form-check-label">Kebawah</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="arah" value="antara" {{ old('arah', request('arah')) == 'antara' ? 'checked' : '' }}>
                            <label class="form-check-label">Antara</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="row mb-3 form-group">
                            <label for="jenis_kepegawaian" class="col-md-4 col-lg-3 col-form-label">Status Pegawai</label>
                            <div class="col-md-6 col-lg-9">
                            <select class="form-select" name="jenis_kepegawaian" id="jenis_kepegawaian">
                                <option value="" selected>-- pilihan --</option>
                                <option value="PNS" {{ old('jenis_kepegawaian', request('jenis_kepegawaian'))=='PNS' ? 'selected': '' }}>PNS</option>
                                <option value="PPPK" {{ old('jenis_kepegawaian', request('jenis_kepegawaian'))=='PPPK' ? 'selected': '' }}>PPPK</option>
                                <option value="CPNS" {{ old('jenis_kepegawaian', request('jenis_kepegawaian'))=='CPNS' ? 'selected': '' }}>CPNS</option>
                                <option value="BLUD" {{ old('jenis_kepegawaian', request('jenis_kepegawaian'))=='BLUD' ? 'selected': '' }}>BLUD</option>
                            </select>
                            @error('jenis_kepegawaian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="row mb-3">
                            <label for="eselon" class="col-md-4 col-lg-3 col-form-label">Eselon</label>
                            <div class="col-md-6 col-lg-9">
                            <select class="form-select" name="eselon" id="eselon">
                                <option value="" selected>-- pilihan --</option>
                                <option value="V" {{ old('eselon', request('eselon'))=='V' ? 'selected': '' }}>V</option>
                                <option value="IV.b" {{ old('eselon', request('eselon'))=='IV.b' ? 'selected': '' }}>IV.b</option>
                                <option value="IV.a" {{ old('eselon', request('eselon'))=='IV.a' ? 'selected': '' }}>IV.a</option>
                                <option value="III.b" {{ old('eselon', request('eselon'))=='III.b' ? 'selected': '' }}>III.b</option>
                                <option value="III.a" {{ old('eselon', request('eselon'))=='III.a' ? 'selected': '' }}>III.a</option>
                                <option value="II.b" {{ old('eselon', request('eselon'))=='II.b' ? 'selected': '' }}>II.b</option>
                                <option value="II.a" {{ old('eselon', request('eselon'))=='II.a' ? 'selected': '' }}>II.a</option>
                                <option value="I.b" {{ old('eselon', request('eselon'))=='I.b' ? 'selected': '' }}>I.b</option>
                                <option value="I.a" {{ old('eselon', request('eselon'))=='I.a' ? 'selected': '' }}>I.a</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="row mb-3 form-group">
                            <label for="jenis_kelamin" class="col-md-4 col-lg-3 col-form-label">Jenis Kelamin</label>
                            <div class="col-md-6 col-lg-9">
                            <select class="form-select" name="jenis_kelamin" id="jenis_kelamin">
                                <option value="" selected>-- pilihan --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', request('jenis_kelamin'))=='Laki-laki' ? 'selected': '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', request('jenis_kelamin'))=='Perempuan' ? 'selected': '' }}>Perempuan</option>
                            </select>
                            </div>
                            @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="row mb-3 form-group">
                            <label for="agama" class="col-md-4 col-lg-3 col-form-label">Agama</label>
                            <div class="col-md-6 col-lg-9">
                            <select class="form-select" name="agama" id="agama">
                                <option value="" selected>-- pilihan --</option>
                                <option value="Islam" {{ old('agama', request('agama'))=='Islam' ? 'selected': '' }}>Islam</option>
                                <option value="Protestan" {{ old('agama', request('agama'))=='Protestan' ? 'selected': '' }}>Protestan</option>
                                <option value="Khatolik" {{ old('agama', request('agama'))=='Khatolik' ? 'selected': '' }}>Khatolik</option>
                                <option value="Hindu" {{ old('agama', request('agama'))=='Hindu' ? 'selected': '' }}>Hindu</option>
                                <option value="Budha" {{ old('agama', request('agama'))=='Budha' ? 'selected': '' }}>Budha</option>
                            </select>
                            @error('agama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="row mb-3 form-group">
                            <label for="tingkat" class="col-md-4 col-lg-3 col-form-label">Pendidikan</label>
                            <div class="col-md-6 col-lg-9">
                            <select class="form-select" name="tingkat" id="tingkat">
                                <option value="" selected>-- pilihan --</option>
                                <option value="SD" {{ old('tingkat', request('tingkat'))=='SD' ? 'selected': '' }}>SD</option>
                                <option value="SMP" {{ old('tingkat', request('tingkat'))=='SMP' ? 'selected': '' }}>SMP</option>
                                <option value="SMA" {{ old('tingkat', request('tingkat'))=='SMA' ? 'selected': '' }}>SMA</option>
                                <option value="D3" {{ old('tingkat', request('tingkat'))=='D3' ? 'selected': '' }}>D3</option>
                                <option value="D4" {{ old('tingkat', request('tingkat'))=='D4' ? 'selected': '' }}>D4</option>
                                <option value="S1" {{ old('tingkat', request('tingkat'))=='S1' ? 'selected': '' }}>S1</option>
                                <option value="S2" {{ old('tingkat', request('tingkat'))=='S2' ? 'selected': '' }}>S2</option>
                                <option value="S3" {{ old('tingkat', request('tingkat'))=='S3' ? 'selected': '' }}>S3</option>
                            </select>
                            @error('tingkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="row mb-3 form-group">
                            <label for="status" class="col-md-4 col-lg-3 col-form-label">Kedudukan Pegawai</label>
                            <div class="col-md-6 col-lg-9">
                            <select class="form-select" name="status" id="status">
                                <option value="" selected>-- pilihan --</option>
                                <option value="Aktif" {{ old('status', request('status'))=='Aktif' ? 'selected': '' }}>Aktif</option>
                                <option value="CLTN" {{ old('status', request('status'))=='CLTN' ? 'selected': '' }}>CLTN</option>
                                <option value="Tugas Belajar" {{ old('status', request('status'))=='Tugas Belajar' ? 'selected': '' }}>Tugas Belajar</option>
                                <option value="Pemberhentian sementara" {{ old('status', request('status'))=='Pemberhentian sementara' ? 'selected': '' }}>Pemberhentian sementara</option>
                                <option value="Penerima Uang Tunggu" {{ old('status', request('status'))=='Penerima Uang Tunggu' ? 'selected': '' }}>Penerima Uang Tunggu</option>
                                <option value="Wajib Militer" {{ old('status', request('status'))=='Wajib Militer' ? 'selected': '' }}>Wajib Militer</option>
                                <option value="Pejabat Negara" {{ old('status', request('status'))=='Pejabat Negara' ? 'selected': '' }}>Pejabat Negara</option>
                                <option value="Kepala Desa" {{ old('status', request('status'))=='Kepala Desa' ? 'selected': '' }}>Kepala Desa</option>
                                <option value="Proses Banding BAPEK" {{ old('status', request('status'))=='Proses Banding BAPEK' ? 'selected': '' }}>Proses Banding BAPEK</option>
                                <option value="Masa Persiapan Pensiun" {{ old('status', request('status'))=='Masa Persiapan Pensiun' ? 'selected': '' }}>Masa Persiapan Pensiun</option>
                                <option value="Pensiun" {{ old('status', request('status'))=='Pensiun' ? 'selected': '' }}>Pensiun</option>
                                <option value="Calon CPNS" {{ old('status', request('status'))=='Calon CPNS' ? 'selected': '' }}>Calon CPNS</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tampilan Data Kanan -->
                <div class="col-md-6">
                    <div class="row mb-2">
                        <label class="form-label fw-bolder col-md-4 col-lg-3">Tampilan Data:</label><br>
                        <div class="col-md-6 col-lg-9">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="semua_data" onchange="toggleAllColumns()"> 
                                <label class="form-check-label">Semua Data</label>
                            </div>
                            <div class="row">
                                <div class="col-6 col-sm-4">
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="tempat_lahir" {{ in_array('tempat_lahir', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> Tempat Lahir</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="tanggal_lahir" {{ in_array('tanggal_lahir', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> Tanggal Lahir</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="agama" {{ in_array('agama', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> Agama</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="jenis_kelamin" {{ in_array('jenis_kelamin', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> Jenis Kelamin</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="alamat" {{ in_array('alamat', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> Alamat</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="telepon" {{ in_array('telepon', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> Nomor HP</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="no_npwp" {{ in_array('no_npwp', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> NPWP</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="no_ktp" {{ in_array('no_ktp', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> Nomor KTP</div>
                                </div>
                                <div class="col-6 col-sm-4">
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="jenis_kepegawaian" {{ in_array('jenis_kepegawaian', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> Status Pegawai</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="tmt_golongan_cpns" {{ in_array('tmt_golongan_cpns', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> TMT CPNS</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="tmt_pns" {{ in_array('tmt_pns', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> TMT PNS</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="golongan_ruang" {{ in_array('golongan_ruang', old('display_columns', request('display_columns', ['golongan_ruang'])) ?? ['golongan_ruang']) ? 'checked' : '' }}> Gol. Ruang</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="pangkat" {{ in_array('pangkat', old('display_columns', request('display_columns', ['pangkat'])) ?? ['pangkat']) ? 'checked' : '' }}> Pangkat</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="tingkat_pendidikan" {{ in_array('tingkat_pendidikan', old('display_columns', request('display_columns', ['tingkat_pendidikan'])) ?? ['tingkat_pendidikan']) ? 'checked' : '' }}> Tingkat Pendidikan</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="eselon" {{ in_array('eselon', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> Eselon</div>
                                </div>
                                <div class="col-6 col-sm-4">
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="jurusan" {{ in_array('jurusan', old('display_columns', request('display_columns', ['jurusan'])) ?? ['jurusan']) ? 'checked' : '' }}> Jurusan</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="nama_sekolah" {{ in_array('nama_sekolah', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> Nama Sekolah</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="tahun_lulus" {{ in_array('tahun_lulus', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> Tahun Lulus</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="unit_kerja" {{ in_array('unit_kerja', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> Unit Kerja</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="sub_unit" {{ in_array('sub_unit', old('display_columns', request('display_columns', ['sub_unit'])) ?? ['sub_unit']) ? 'checked' : '' }}> Sub Unit</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="jenis_jabatan" {{ in_array('jenis_jabatan', old('display_columns', request('display_columns', ['jenis_jabatan'])) ?? ['jenis_jabatan']) ? 'checked' : '' }}> Jenis Jabatan</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="jabatan" {{ in_array('jabatan', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> Jabatan</div>
                                    <div class="form-check"><input class="form-check-input column-checkbox" type="checkbox" name="display_columns[]" value="tmt_jabatan" {{ in_array('tmt_jabatan', old('display_columns', request('display_columns', [])) ?? []) ? 'checked' : '' }}> TMT Jabatan</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3 row">
                            <label class="form-label fw-bolder col-md-4 col-lg-6">Urut Berdasarkan:</label><br>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="urut" value="golongan_ruang" {{ old('urut', request('urut')) == 'golongan_ruang' ? 'checked' : '' }}> Gol. Ruang
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="urut" value="nip" {{ old('urut', request('urut')) == 'nip' ? 'checked' : '' }}> NIP
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="urut" value="nama" {{ old('urut', request('urut')) == 'nama' ? 'checked' : '' }}> Nama
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="urut" value="usia" {{ old('urut', request('urut')) == 'usia' ? 'checked' : '' }}> Usia
                                </div>
                            </div>
                        </div>

                        <div class="col mb-3 row">
                            <label class="form-label fw-bolder col-md-4 col-lg-6">Model Urutan:</label><br>
                            <div class="col-md-6 col-lg-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="model" value="ascending" {{ old('model', request('model')) == 'ascending' ? 'checked' : '' }}> Ascending
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="model" value="descending" {{ old('model', request('model')) == 'descending' ? 'checked' : '' }}> Descending
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success btn-sm me-2"><i class="bi bi-eye-fill"></i> Lihat Nominatif</button>
                <a href="{{ route('dashboard.nominatif.preview', request()->all()) }}" class="btn btn-success btn-sm" target="_blank">
                    <i class="bi bi-printer"></i> Cetak Nominatif
                </a>
            </div>
        </form>

        <!-- Tabel Hasil Nominatif -->
        @if(isset($pegawais))
        <h5 class="text-center mt-3">DAFTAR NOMINATIF PEGAWAI NEGERI SIPIL<br>
        PADA RSUD dr. Soeselo Slawi</h5>
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        @foreach ($displayColumns as $col)
                            <th>{{ $col }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pegawais as $index => $pegawai)
                    <tr>
                        @foreach ($displayColumns as $key => $col)
                            <td>
                                @switch($key)
                                    @case('no')
                                        {{ $index + 1 }}
                                        @break
                                    @case('nip')
                                        {{ $pegawai->nip }}
                                        @break
                                    @case('nama')
                                        {{ $pegawai->nama }}
                                        @break
                                    @case('tempat_lahir')
                                        {{ $pegawai->tempat_lahir }}
                                        @break
                                    @case('tanggal_lahir')
                                        {{ $pegawai->tanggal_lahir }}
                                        @break
                                    @case('agama')
                                        {{ $pegawai->agama }}
                                        @break
                                    @case('jenis_kelamin')
                                        {{ $pegawai->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        @break
                                    @case('alamat')
                                        {{ collect([
                                            $pegawai->alamat,
                                            $pegawai->rt ? 'RT ' . $pegawai->rt : null,
                                            $pegawai->rw ? 'RW ' . $pegawai->rw : null,
                                            $pegawai->desa ? 'Desa ' . $pegawai->desa : null,
                                            $pegawai->kecamatan ? 'Kec. ' . $pegawai->kecamatan : null,
                                            $pegawai->kabupaten ? 'Kab. ' . $pegawai->kabupaten : null,
                                            $pegawai->provinsi ? 'Prov. ' . $pegawai->provinsi : null,
                                            $pegawai->pos ? 'Kode Pos ' . $pegawai->pos : null
                                        ])->filter()->implode(', ') ?: '-' }}
                                        @break
                                    @case('telepon')
                                        {{ $pegawai->telepon }}
                                        @break
                                    @case('no_npwp')
                                        {{ $pegawai->no_npwp }}
                                        @break
                                    @case('no_ktp')
                                        {{ $pegawai->no_ktp }}
                                        @break
                                    @case('jenis_kepegawaian')
                                        {{ optional($pegawai->jabatan)->jenis_kepegawaian }}
                                        @break
                                    @case('tmt_golongan_cpns')
                                        {{ $pegawai->tmt_golongan_cpns }}
                                        @break
                                    @case('tmt_pns')
                                        {{ $pegawai->tmt_pns }}
                                        @break
                                    @case('golongan_ruang')
                                        {{ $pegawai->golongan_ruang }}
                                        @break
                                    @case('pangkat')
                                        {{ optional($pegawai->jabatan)->nama }}
                                        @break
                                    @case('tingkat_pendidikan')
                                        {{ optional($pegawai->pendidikans->sortByDesc('tahun_lulus')->first())->tingkat ?? '-' }}
                                        @break
                                    @case('jurusan')
                                        {{ optional($pegawai->pendidikans->sortByDesc('tahun_lulus')->first())->jurusan ?? '-' }}
                                        @break
                                    @case('nama_sekolah')
                                        {{ optional($pegawai->pendidikans->sortByDesc('tahun_lulus')->first())->nama_sekolah ?? '-' }}
                                        @break
                                    @case('tahun_lulus')
                                        {{ optional($pegawai->pendidikans->sortByDesc('tahun_lulus')->first())->tahun_lulus ?? '-' }}
                                        @break
                                    @case('unit_kerja')
                                        {{ optional($pegawai->jabatan)->skpd }}
                                        @break
                                    @case('sub_unit')
                                        {{ optional($pegawai->jabatan)->unit_kerja }}
                                        @break
                                    @case('jenis_jabatan')
                                        {{ optional($pegawai->jabatan)->jenis_jabatan }}
                                        @break
                                    @case('jabatan')
                                        {{ optional($pegawai->jabatan)->unit_kerja }}
                                        @break
                                    @case('tmt_jabatan')
                                        {{ optional($pegawai->jabatan)->tmt_jabatan }}
                                        @break
                                    @default
                                        {{ $pegawai[$key] ?? '-' }}
                                @endswitch
                            </td>
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($displayColumns) }}" class="text-center">Tidak ada data pegawai ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endif
    </div>
<script>
function toggleAllColumns() {
    let status = document.getElementById('semua_data').checked;
    document.querySelectorAll('.column-checkbox').forEach(cb => cb.checked = status);
}
</script>
@endsection