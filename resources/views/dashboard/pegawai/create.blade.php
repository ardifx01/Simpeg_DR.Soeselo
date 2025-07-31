@extends('dashboard.layouts.main')

@section('main')

    <div class="pagetitle">
        <div class="row justify-content-between">
            <div class="col">
                <h1>Pegawai | <small>Tambah Pegawai</small></h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Data Pegawai</a></li>
                        <li class="breadcrumb-item active">Tambah Data Pegawai</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Pegawai create Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Pegawai create -->
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview"><i class="bi bi-person-fill"></i> Profile</button>
                                </li>
                                
                                <li class="nav-item">
                                <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#jabatan"><i class="bi bi-person-lines-fill"></i> Jabatan</button>
                                </li>
                                
                                <li class="nav-item">
                                <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#suami/i"><i class="bi bi-people-fill"></i> Suami/Istri</button>
                                </li>

                                <li class="nav-item">
                                <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#anak"><i class="bi bi-people-fill"></i> Anak</button>
                                </li>
                                
                                <li class="nav-item">
                                <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#pendidikan"><i class="bi bi-mortarboard-fill"></i> Pendidikan</button>
                                </li>
                                
                                <li class="nav-item">
                                <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#penghargaan"><i class="bi bi-stack"></i> Penghargaan</button>
                                </li>
                                
                                <li class="nav-item">
                                <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#organisasi"><i class="bi bi-stack"></i> Organisasi</button>
                                </li>
                                
                                <li class="nav-item">
                                <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#diklat"><i class="bi bi-book-fill"></i> Diklat</button>
                                </li>
                                
                                <li class="nav-item">
                                <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#arsip"><i class="bi bi-folder-fill"></i></i> Arsip</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-overview ms-3" id="profile-overview">
                                    @include('dashboard.partialsAdd.profile')
                                </div>

                                <div class="tab-pane fade jabatan pt-3" id="jabatan">
                                    @include('dashboard.partialsAdd.jabatan')
                                </div>

                                <div class="tab-pane fade suami/i pt-3" id="suami/i">
                                    @include('dashboard.partialsAdd.istri')
                                </div>

                                <div class="tab-pane fade pt-3" id="anak">
                                    @include('dashboard.partialsAdd.anak')
                                </div>

                                <div class="tab-pane fade pt-3" id="pendidikan">
                                    @include('dashboard.partialsAdd.pendidikan')
                                </div>

                                <div class="tab-pane fade pt-3" id="penghargaan">
                                    @include('dashboard.partialsAdd.penghargaan')
                                </div>

                                <div class="tab-pane fade pt-3" id="organisasi">
                                    @include('dashboard.partialsAdd.organisasi')
                                </div>

                                <div class="tab-pane fade pt-3" id="diklat">
                                    @include('dashboard.partialsAdd.diklat')
                                </div>

                                <div class="tab-pane fade pt-3" id="arsip">
                                    @include('dashboard.partialsAdd.arsip')
                                </div>
                            </div><!-- End Bordered Tabs -->
                        </div>
                    </div>
            </div><!-- End Pegawai Create -->
        </div>
    </section><!-- End Pegawai create Section -->

@endsection