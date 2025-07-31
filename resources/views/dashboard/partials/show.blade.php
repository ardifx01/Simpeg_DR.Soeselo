@extends('dashboard.layouts.main')

@section('main')

<!-- Notifikasi menggunakan flash session data -->
    <div class="pagetitle">
        <div class="row justify-content-between">
            <div class="col">
                <h1>Profile | <small>Data Pegawai {{ $pegawai->nama }}</small></h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Data Pegawai</a></li>
                        <li class="breadcrumb-item active">Pegawai {{ $pegawai->nama }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col">
                <div class="text-end">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#printModal">
                        <i class="bi bi-printer"></i> print
                    </button>
                    <a href="{{ route('pegawai.edit',['pegawai' => $pegawai->id]) }}"><button type="button" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit Pegawai</button></a>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <span class="modal-title fs-5" id="printModalLabel">Cetak Biodata: {{ $pegawai->nama }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i> Pilih komponen yang ingin dicetak pada biodata pegawai
                                </div>
                                <div class="d-flex justify-content-center">
                                    <form action="{{ route('pegawai.print.preview', $pegawai->id) }}" method="POST" target="_blank" class="text-start" style="width: 260px;">
                                        @csrf
                                        
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" checked disabled>
                                                <input type="hidden" name="sections[]" value="biodata">
                                                <label class="form-check-label">
                                                    Biodata Pegawai
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sections[]" value="jabatan" id="check_jabatan" checked>
                                                <label class="form-check-label" for="check_jabatan">
                                                    Riwayat Jabatan
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sections[]" value="pendidikan" id="check_pendidikan" checked>
                                                <label class="form-check-label" for="check_pendidikan">
                                                    Riwayat Pendidikan
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sections[]" value="penghargaan" id="check_penghargaan" checked>
                                                <label class="form-check-label" for="check_penghargaan">
                                                    Riwayat Penghargaan
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sections[]" value="organisasi" id="check_organisasi" checked>
                                                <label class="form-check-label" for="check_organisasi">
                                                    Riwayat Organisasi
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sections[]" value="diklat_fungsional" id="check_diklat_fungsional" checked>
                                                <label class="form-check-label" for="check_diklat_fungsional">
                                                    Riwayat Diklat Fungsional
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sections[]" value="diklat_jabatan" id="check_diklat_jabatan" checked>
                                                <label class="form-check-label" for="check_diklat_jabatan">
                                                    Riwayat Diklat Jabatan
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sections[]" value="diklat_teknis" id="check_diklat_teknis" checked>
                                                <label class="form-check-label" for="check_diklat_teknis">
                                                    Riwayat Diklat Teknis
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sections[]" value="istri" id="check_istri" checked>
                                                <label class="form-check-label" for="check_istri">
                                                    Riwayat Suami/Istri
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sections[]" value="anak" id="check_anak" checked>
                                                <label class="form-check-label" for="check_anak">
                                                    Riwayat Anak
                                                </label>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-printer"></i> Cetak
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Pegawai Title -->

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview"><i class="bi bi-person-fill"></i> Profile</button>
                        </li>
                        
                        <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#jabatan"><i class="bi bi-person-lines-fill"></i> Jabatan</button>
                        </li>
                        
                        <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#suami-istri"><i class="bi bi-people-fill"></i> Suami/Istri</button>
                        </li>

                        <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#anak"><i class="bi bi-people-fill"></i> Anak</button>
                        </li>
                        
                        <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pendidikan"><i class="bi bi-mortarboard-fill"></i> Pendidikan</button>
                        </li>
                        
                        <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#penghargaan"><i class="bi bi-stack"></i> Penghargaan</button>
                        </li>
                        
                        <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#organisasi"><i class="bi bi-stack"></i> Organisasi</button>
                        </li>
                        
                        <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#diklat"><i class="bi bi-book-fill"></i> Diklat</button>
                        </li>
                        
                        <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#arsip"><i class="bi bi-folder-fill"></i></i> Arsip</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2 d-none" id="pegawai-tabs">
                        <div class="tab-pane fade show active profile-overview ms-3" id="profile-overview">
                            @include('dashboard.partials.profile')
                        </div>

                        <div class="tab-pane fade jabatan pt-3" id="jabatan">
                            @include('dashboard.partials.jabatan')
                        </div>

                        <div class="tab-pane fade pt-3" id="suami-istri">
                            @include('dashboard.partials.istri')
                        </div>

                        <div class="tab-pane fade pt-3" id="anak">
                            @include('dashboard.partials.anak')
                        </div>

                        <div class="tab-pane fade pt-3" id="pendidikan">
                            @include('dashboard.partials.pendidikan')
                        </div>

                        <div class="tab-pane fade pt-3" id="penghargaan">
                            @include('dashboard.partials.penghargaan')
                        </div>

                        <div class="tab-pane fade pt-3" id="organisasi">
                            @include('dashboard.partials.organisasi')
                        </div>

                        <div class="tab-pane fade pt-3" id="diklat">
                            @include('dashboard.partials.diklat')
                        </div>

                        <div class="tab-pane fade pt-3" id="arsip">
                            @include('dashboard.partials.arsip')
                        </div>
                    </div><!-- End Bordered Tabs -->
                </div>
            </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const triggerTabList = document.querySelectorAll('button[data-bs-toggle="tab"]');

            triggerTabList.forEach(function (triggerEl) {
                triggerEl.addEventListener('shown.bs.tab', function (event) {
                    const tabTarget = event.target.getAttribute('data-bs-target');
                    localStorage.setItem('activePegawaiTab', tabTarget);
                });
            });

            const savedTab = localStorage.getItem('activePegawaiTab');
            if (savedTab) {
                const someTabTriggerEl = document.querySelector(`button[data-bs-target="${savedTab}"]`);
                if (someTabTriggerEl) {
                    new bootstrap.Tab(someTabTriggerEl).show();
                }
            }

            // Tampilkan kembali tab setelah selesai menentukan tab aktif
            document.getElementById('pegawai-tabs').classList.remove('d-none');
        });
        </script>
@endsection