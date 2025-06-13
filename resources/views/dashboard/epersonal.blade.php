@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="d-flex justify-content-between">
                <div>
                    <h1>Dashboard <small>Overview & statistic Kepegawaian</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <button id="btnTanggal" class="btn btn-primary btn-sm">
                        <i class="bi bi-calendar3"></i> <span id="tanggalSekarang"></span>
                    </button> 
                </div>
            </div>
        </div><!-- End Dashboard Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Pegawai Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('pegawai.index') }}">
                    <div class="card info-card pegawai-card">
                    <div class="card-body">
                        <h5 class="card-title">Pegawai</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $jumlahPegawai }}</h6>
                                <hr class="dropdown-divider">
                                <span class="text-muted small pt-2 ps-1">Total Data Pegawai</span>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div><!-- End Pegawai Card -->
            
            <!-- PNS Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('pegawai.index', ['per_page' => 10, 'jenis_kepegawaian' => 'PNS', 'search' => '']) }}">
                    <div class="card info-card opd-card">
                    <div class="card-body">
                        <h5 class="card-title">PNS</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-lines-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $jumlahPNS }}</h6>
                                <hr class="dropdown-divider">
                                <span class="text-muted small pt-2 ps-1">Total Data PNS</span>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div><!-- End PNS Card -->

            <!-- PPPK Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('pegawai.index', ['per_page' => 10, 'jenis_kepegawaian' => 'PPPK', 'search' => '']) }}">
                    <div class="card info-card pegawai-card">
                        <div class="card-body">
                            <h5 class="card-title">PPPK</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-lines-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $jumlahPPPK }}</h6>
                                    <hr class="dropdown-divider">
                                    <span class="text-muted small pt-2 ps-1">Total Data PPPK</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div><!-- End PPPK Card -->

            <!-- CPNS Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('pegawai.index', ['per_page' => 10, 'jenis_kepegawaian' => 'CPNS', 'search' => '']) }}">
                    <div class="card info-card penghargaan-card">
                        <div class="card-body">
                            <h5 class="card-title">CPNS</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-lines-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $jumlahCPNS }}</h6>
                                    <hr class="dropdown-divider">
                                    <span class="text-muted small pt-2 ps-1">Total Data CPNS</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div><!-- End CPNS Card -->

            <!-- BLUD Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('pegawai.index', ['per_page' => 10, 'jenis_kepegawaian' => 'BLUD', 'search' => '']) }}">
                    <div class="card info-card diklat-card">
                        <div class="card-body">
                            <h5 class="card-title">BLUD</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-lines-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $jumlahBLUD }}</h6>
                                    <hr class="dropdown-divider">
                                    <span class="text-muted small pt-2 ps-1">Total Data BLUD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div><!-- End BLUD Card -->
@endsection