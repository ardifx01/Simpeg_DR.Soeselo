@extends('surat.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="d-flex justify-content-between">
                <div>
                    <h1>E-surat <small>Keperluan Surat Kepegawaian</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item active">E-surat</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <button id="btnTanggal" class="btn btn-primary btn-sm">
                        <i class="bi bi-calendar3"></i> <span id="tanggalSekarang"></span>
                    </button> 
                </div>
            </div>
        </div><!-- End E-surat Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Surat Cuti Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('cuti.index') }}">
                    <div class="card info-card penghargaan-card" data-aos="zoom-in">
                    <div class="card-body">
                        <h5 class="card-title">Surat Cuti</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-muted small pt-2 ps-1">Ajukan Surat</span>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div><!-- End Surat Cuti Card -->

            <!-- Surat Tugas Belajar Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('tugas_belajar.index') }}">
                    <div class="card info-card pegawai-card" data-aos="zoom-in">
                    <div class="card-body">
                        <h5 class="card-title">Surat Tugas Belajar</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <div class="ps-3">
                                <hr class="dropdown-divider">
                                <span class="text-muted small pt-2 ps-1">Ajukan Surat</span>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div><!-- End Surat Tugas Belajar Card -->

            <!-- Surat Keterangan Pegawai Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('keterangan.index') }}">
                    <div class="card info-card opd-card" data-aos="zoom-in">
                    <div class="card-body">
                        <h5 class="card-title">Surat Keterangan Pegawai</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-muted small pt-2 ps-1">Ajukan Surat</span>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div><!-- End Surat Keterangan Pegawai Card -->

            <!-- Surat Hukuman Disiplin Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('hukuman.index') }}">
                    <div class="card info-card diklat-card" data-aos="zoom-in">
                    <div class="card-body">
                        <h5 class="card-title">Surat Hukuman Disiplin</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-muted small pt-2 ps-1">Ajukan Surat</span>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div><!-- End Surat Hukuman Disiplin Card -->
            
            <!-- Surat Pembinaan Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('pembinaan.index') }}">
                    <div class="card info-card pembinaan-card" data-aos="zoom-in">
                    <div class="card-body">
                        <h5 class="card-title">Surat Pembinaan</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-text text-danger"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-muted small pt-2 ps-1">Ajukan Surat</span>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div><!-- End Surat Pembinaan Card -->
            
            <!-- Penilaian Capaian SKP Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('skp.index') }}">
                    <div class="card info-card info-card" data-aos="zoom-in">
                        <div class="card-body">
                            <h5 class="card-title">Penilaian Capaian SKP</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-file-earmark-bar-graph"></i>
                                </div>
                                <div class="ps-3">
                                    <span class="text-muted small pt-2 ps-1">Kelola Penilaian</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div><!-- End Penilaian Capaian SKP Card -->
        </section>
@endsection