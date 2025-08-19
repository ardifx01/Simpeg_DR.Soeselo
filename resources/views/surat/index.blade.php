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
                    <div class="card penghargaan-card" data-aos="zoom-in">
                    <div class="card-body">
                        <h5 class="card-title">Surat Cuti</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-muted pt-2 ps-1">Ajukan Surat</span>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div><!-- End Surat Cuti Card -->

            <!-- Surat Tugas Belajar Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('tugas_belajar.index') }}">
                    <div class="card pegawai-card" data-aos="zoom-in">
                    <div class="card-body">
                        <h5 class="card-title">Surat Tugas Belajar</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <div class="ps-3">
                                <hr class="dropdown-divider">
                                <span class="text-muted pt-2 ps-1">Ajukan Surat</span>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div><!-- End Surat Tugas Belajar Card -->

            <!-- Surat Keterangan Rawat Pegawai Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('rawat.index') }}">
                    <div class="card opd-card" data-aos="zoom-in">
                    <div class="card-body">
                        <h5 class="card-title">Surat Keterangan Rawat Pegawai</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-muted pt-2 ps-1">Ajukan Surat</span>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div><!-- End Surat Keterangan Rawat Pegawai Card -->

            <!-- Surat Hukuman Disiplin Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('hukuman.index') }}">
                    <div class="card diklat-card" data-aos="zoom-in">
                    <div class="card-body">
                        <h5 class="card-title">Surat Hukuman Disiplin</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-muted pt-2 ps-1">Ajukan Surat</span>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div><!-- End Surat Hukuman Disiplin Card -->
            
            <!-- Surat Pembinaan Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('pembinaan.index') }}">
                    <div class="card pembinaan-card" data-aos="zoom-in">
                    <div class="card-body">
                        <h5 class="card-title">Surat Pembinaan</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-text text-danger"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-muted pt-2 ps-1">Ajukan Surat</span>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div><!-- End Surat Pembinaan Card -->

            <!-- Surat Berita Acara Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('berita_acara.index') }}">
                    <div class="card berita-acara-card" data-aos="zoom-in">
                        <div class="card-body">
                            <h5 class="card-title">Surat Berita Acara</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-file-text"></i>
                                </div>
                                <div class="ps-3">
                                    <span class="text-muted pt-2 ps-1">Ajukan Surat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div><!-- End Surat Berita Acara Card -->
            
            <!-- Surat Dinas Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('dinas.index') }}">
                    <div class="card dinas-card" data-aos="zoom-in">
                        <div class="card-body">
                            <h5 class="card-title">Surat Dinas</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-file-text"></i>
                                </div>
                                <div class="ps-3">
                                    <span class="text-muted pt-2 ps-1">Ajukan Surat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div><!-- End Surat Dinas Card -->
            
            <!-- Surat Disposisi Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('disposisi.index') }}">
                    <div class="card disposisi-card" data-aos="zoom-in">
                        <div class="card-body">
                            <h5 class="card-title">Surat Disposisi</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-file-text"></i>
                                </div>
                                <div class="ps-3">
                                    <span class="text-muted pt-2 ps-1">Ajukan Surat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div><!-- End Surat Disposisi Card -->
            
            <!-- Surat Edaran Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('edaran.index') }}">
                    <div class="card edaran-card" data-aos="zoom-in">
                        <div class="card-body">
                            <h5 class="card-title">Surat Edaran</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-file-text"></i>
                                </div>
                                <div class="ps-3">
                                    <span class="text-muted pt-2 ps-1">Ajukan Surat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div><!-- End Surat Edaran Card -->
            
            <!-- Surat Keterangan Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('keterangan.index') }}">
                    <div class="card keterangan-card" data-aos="zoom-in">
                        <div class="card-body">
                            <h5 class="card-title">Surat Keterangan</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-file-text"></i>
                                </div>
                                <div class="ps-3">
                                    <span class="text-muted pt-2 ps-1">Ajukan Surat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div><!-- End Surat Keterangan Card -->
            
            <!-- Surat Kuasa Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('kuasa.index') }}">
                    <div class="card kuasa-card" data-aos="zoom-in">
                        <div class="card-body">
                            <h5 class="card-title">Surat Kuasa</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-file-text"></i>
                                </div>
                                <div class="ps-3">
                                    <span class="text-muted pt-2 ps-1">Ajukan Surat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div><!-- End Surat Kuasa Card -->
            
            <!-- Surat Nota Dinas Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('nota_dinas.index') }}">
                    <div class="card nota-dinas-card" data-aos="zoom-in">
                        <div class="card-body">
                            <h5 class="card-title">Surat Nota Dinas</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-file-text"></i>
                                </div>
                                <div class="ps-3">
                                    <span class="text-muted pt-2 ps-1">Ajukan Surat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div><!-- End Surat Nota Dinas Card -->
            
            <!-- Surat Notula Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('notula.index') }}">
                    <div class="card notula-card" data-aos="zoom-in">
                        <div class="card-body">
                            <h5 class="card-title">Surat Notula</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-file-text"></i>
                                </div>
                                <div class="ps-3">
                                    <span class="text-muted pt-2 ps-1">Ajukan Surat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div><!-- End Surat Notula Card -->
            
            <!-- Penilaian Capaian SKP Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('skp.index') }}">
                    <div class="card info-card" data-aos="zoom-in">
                        <div class="card-body">
                            <h5 class="card-title">Penilaian Capaian SKP</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-file-earmark-bar-graph"></i>
                                </div>
                                <div class="ps-3">
                                    <span class="text-muted pt-2 ps-1">Kelola Penilaian</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div><!-- End Penilaian Capaian SKP Card -->
        </section>
@endsection