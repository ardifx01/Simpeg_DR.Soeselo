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
            <!-- E-personal Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('dashboard.epersonal') }}">
                    <div class="card info-card pegawai-card" data-aos="zoom-in">
                    <div class="card-body">
                        <h5 class="card-title">E-personal</h5>
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
            </div><!-- End Epersonal Card -->

            <!-- E-surat Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('surat') }}">
                    <div class="card info-card opd-card" data-aos="zoom-in">
                    <div class="card-body">
                        <h5 class="card-title">E-surat</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-send-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6></h6>
                                <span class="text-muted small pt-2 ps-1">Surat Pegawai</span>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div><!-- End E-surat Card -->

            <!-- Diklat Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="">
                    <div class="card info-card diklat-card" data-aos="zoom-in">
                    <div class="card-body">
                        <h5 class="card-title">Diklat</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $jumlahdiklat }}</h6>
                                <span class="text-muted small pt-2 ps-1">Total data Diklat</span>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div><!-- End Diklat Card -->

            <!-- Penghargaan Card -->
            <div class="col-xxl-3 col-md-6">
                <a href="{{ route('penghargaan.index') }}">
                    <div class="card info-card penghargaan-card" data-aos="zoom-in">
                    <div class="card-body">
                        <h5 class="card-title">Penghargaan</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $jumlahPenghargaan }}</h6>
                                <span class="text-muted small pt-2 ps-1">Total data Penghargaan</span>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div><!-- End Penghargaan Card -->

            <!-- Charts Diagram -->
            <div class="row m-0">
                @if (!empty($rekapGolongan) && count($rekapGolongan) > 0)
                <div class="col-xxl-12">
                    <div class="card" data-aos="fade-up">
                        <div class="card-body">
                            <h5 class="card-title">Statistik Jumlah Pegawai Berdasarkan Golongan</h5>
                            <div id="chartGolongan"></div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-xxl-12 col-md-6">
                    <div class="card" data-aos="fade-up">
                        <div class="card-body" data-aos="fade-up">
                            <h5 class="card-title">Statistik Jumlah Pegawai Berdasarkan Jabatan</h5>
                            <div id="chartJabatan"></div>
                        </div>
                    </div>
                </div>
            
                <div class="col-xxl-6 col-md-6">
                    <div class="card" data-aos="fade-up">
                        <div class="card-body">
                            <h5 class="card-title">Statistik Jumlah Pegawai Berdasarkan Status Kepegawaian</h5>
                            <div id="chartKepegawaian"></div>
                        </div>
                    </div>
                </div>
            
                <div class="col-xxl-6 col-md-6">
                    <div class="card" data-aos="fade-up">
                        <div class="card-body">
                            <h5 class="card-title">Statistik Jumlah Pegawai Berdasarkan Eselon</h5>
                            <div id="chartEselon"></div>
                        </div>
                    </div>
                </div>
            
                <div class="col-xxl-6 col-md-6">
                    <div class="card" data-aos="fade-up">
                        <div class="card-body">
                            <h5 class="card-title">Statistik Jumlah Pegawai Berdasarkan Agama</h5>
                            <div id="chartAgama"></div>
                        </div>
                    </div>
                </div>
            
                <div class="col-xxl-6 col-md-6">
                    <div class="card" data-aos="fade-up">
                        <div class="card-body">
                            <h5 class="card-title">Statistik Jumlah Pegawai Berdasarkan Jenis Kelamin</h5>
                            <div id="chartJenisKelamin"></div>
                        </div>
                    </div>
                </div>
            
                <div class="col-xxl-6 col-md-6">
                    <div class="card" data-aos="fade-up">
                        <div class="card-body">
                            <h5 class="card-title">Statistik Jumlah Pegawai Berdasarkan Status Nikah</h5>
                            <div id="chartStatusNikah"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xxl-6 col-md-6">
                    <div class="card" data-aos="fade-up">
                        <div class="card-body">
                            <h5 class="card-title">Statistik Jumlah Pegawai Berdasarkan Pendidikan Akhir</h5>
                            <div id="chartPendidikan"></div>
                        </div>
                    </div>
                </div>
            </div><!-- End Charts -->
        </section>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                function createChart(chartId, title, categories, data) {
                    const colors = [
                        "#FF5733", "#33FF57", "#3357FF", "#F39C12", "#8E44AD", "#16A085", "#E74C3C",
                        "#2ECC71", "#3498DB", "#D35400", "#C0392B", "#7D3C98", "#27AE60", "#2980B9"
                    ];

                    const seriesData = categories.map((category, index) => ({
                        name: category, 
                        data: [data[index]],
                    })).reverse();

                    new ApexCharts(document.querySelector(`#${chartId}`), {
                        chart: { type: 'bar', height: 500, stacked: false },
                        series: seriesData, 
                        xaxis: { categories: [title] },
                        yaxis: { title: { text: 'Jumlah' } },
                        plotOptions: { bar: { horizontal: false, endingShape: 'rounded' } },
                        dataLabels: { enabled: false },
                        colors: colors.slice(0, categories.length),
                        title: { text: `Statistik ${title}`, align: 'center' },
                        legend: { position: 'bottom' } 
                    }).render();
                }

                // Cek apakah variabel data dari Laravel ada sebelum membuat chart
                const rekapData = {
                    golongan: {!! json_encode($rekapGolongan ?? []) !!},
                    jabatan: {!! json_encode($rekapJabatan ?? []) !!},
                    eselon: {!! json_encode($rekapEselon ?? []) !!},
                    kepegawaian: {!! json_encode($rekapKepegawaian ?? []) !!},
                    agama: {!! json_encode($rekapAgama ?? []) !!},
                    jenisKelamin: {!! json_encode($rekapJenisKelamin ?? []) !!},
                    statusNikah: {!! json_encode($rekapStatusNikah ?? []) !!},
                    pendidikan: {!! json_encode($rekapPendidikan ?? []) !!},
                };

                // Looping untuk membuat chart secara otomatis jika datanya tersedia
                Object.entries(rekapData).forEach(([key, data]) => {
                    if (data.length > 0) {
                        const categories = data
                            .map(item => item.nama_jabatan || item.tingkat || item.golongan_ruang || item.eselon || item.jenis_kepegawaian || item.agama || item.jenis_kelamin || item.status_nikah)
                            .filter(Boolean);

                        const values = data.map(item => item.jumlah).filter(val => val !== undefined && val !== null);

                        if (categories.length > 0 && values.length > 0) {
                            createChart(
                                `chart${key.charAt(0).toUpperCase() + key.slice(1)}`,
                                key.replace(/([A-Z])/g, ' $1'),
                                categories,
                                values
                            );
                        }
                    }
                });
            });
        </script>
@endsection