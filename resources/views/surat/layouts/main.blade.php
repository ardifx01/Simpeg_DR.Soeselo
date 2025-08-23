<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - Aplikasi Sistem Informasi Manajemen Kepegawaian RSUD SOESILO</title>
    <meta content="Aplikasi Sistem Informasi Manajemen Kepegawaian RSUD SOESILO" name="description">
    <meta content="Aplikasi Sistem Informasi Manajemen Kepegawaian RSUD SOESILO" name="keywords">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
    
    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- CSS Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/dashboard/style.css') }}" rel="stylesheet">

    <!-- Trix Editor -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        @include('dashboard.layouts.header')

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        @include('surat.layouts.sidebar')

    </aside><!-- End Sidebar-->

    <main id="main" class="main">
        {{-- Notifikasi berhasil --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-success">
                {{ session('success') }}
                <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Notifikasi error --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-error">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('main')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        @include('dashboard.layouts.footer')

    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- jQuery dan Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Apexcharts-->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- reCAPTCHA API -->
    <script src="https://www.google.com/recaptcha/api.js"></script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        AOS.init();

        // Tutup alert otomatis setelah 2 detik
        setTimeout(function() {
            let alertSuccess = document.getElementById('alert-success');
            let alertError = document.getElementById('alert-error');
            if (alertSuccess) {
                let bsAlert = bootstrap.Alert.getOrCreateInstance(alertSuccess);
                bsAlert.close();
            }
            if (alertError) {
                let bsAlert = bootstrap.Alert.getOrCreateInstance(alertError);
                bsAlert.close();
            }
        }, 2000);

        document.addEventListener("DOMContentLoaded", function () {
            let spanTanggal = document.getElementById("tanggalSekarang");

            if (spanTanggal) {
                // Ambil tanggal sekarang
                let today = new Date();
                let options = { day: "numeric", month: "long", year: "numeric" };
                let formattedDate = today.toLocaleDateString("id-ID", options);

                // Set value pada span
                spanTanggal.textContent = formattedDate;
            }
        });

        $(document).ready(function () {
            let dateFields = [
                {inputSelector: '[id^="catatan_tanggal"]', buttonSelector: '[for="catatan_tanggal"]'},
                {inputSelector: '[id^="tanggal_mulai"]', buttonSelector: '[id^="btn_tanggal_mulai"]'},
                {inputSelector: '[id^="tanggal_selesai"]', buttonSelector: '[id^="btn_tanggal_selesai"]'},
                {inputSelector: '[id^="tanggal_lahir_keluarga"]', buttonSelector: '[id^="btn_tanggal_lahir_keluarga"]'},
                {inputSelector: '[id^="tanggal_hukuman"]', buttonSelector: '[id^="btn_tanggal_hukuman"]'},
                {inputSelector: '[id^="tanggal_acara"]', buttonSelector: '[id^="btn_tanggal_acara"]'},
                {inputSelector: '[id^="tanggal_disposisi"]', buttonSelector: '[id^="btn_tanggal_disposisi"]'},
                {inputSelector: '[id^="tanggal_diterima"]', buttonSelector: '[id^="btn_tanggal_diterima"]'},
                {inputSelector: '[id^="tanggal_ditetapkan"]', buttonSelector: '[id^="btn_tanggal_ditetapkan"]'},
                {inputSelector: '[id^="tanggal_kuasa"]', buttonSelector: '[id^="btn_tanggal_kuasa"]'},
                {inputSelector: '[id^="tanggal_nota"]', buttonSelector: '[id^="btn_tanggal_nota"]'},
                {inputSelector: '[id^="tanggal_notula"]', buttonSelector: '[id^="btn_tanggal_notula"]'},
                {inputSelector: '[id^="tanggal_surat"]', buttonSelector: '[id^="btn_tanggal_surat"]'},
                {inputSelector: '[id^="jadwal_tanggal"]', buttonSelector: '[id^="btn_jadwal_tanggal"]'},
                {inputSelector: '[id^="tanggal_penetapan"]', buttonSelector: '[id^="btn_tanggal_penetapan"]'},
                {inputSelector: '[id^="tanggal_terbit"]', buttonSelector: '[id^="btn_tanggal_terbit"]'},
                {inputSelector: '[id^="tanggal_dikeluarkan"]', buttonSelector: '[id^="btn_tanggal_dikeluarkan"]'}
            ];

            // Fungsi untuk inisialisasi datepicker
            function initializeDatepickers() {
                dateFields.forEach(function(field) {
                    $(field.inputSelector).each(function () {
                        if (!$(this).data('datepicker')) {
                            $(this).datepicker({
                                autoclose: true,
                                clearBtn: true,
                                format: "dd-mm-yyyy",
                                todayHighlight: true,
                                orientation: "bottom auto"
                            });
                        }
                    });

                    // Event listener untuk tombol datepicker
                    $(document).off('click', field.buttonSelector).on('click', field.buttonSelector, function () {
                        let targetId = $(this).attr('for');
                        if (!targetId) {
                            // Jika tidak ada atribut 'for', coba ambil dari ID button
                            let buttonId = $(this).attr('id');
                            if (buttonId && buttonId.startsWith('btn_')) {
                                targetId = buttonId.replace('btn_', '');
                            }
                        }
                        if (targetId) {
                            $('#' + targetId).datepicker('show');
                        }
                    });
                });
            }

            // Inisialisasi datepicker saat dokumen ready
            initializeDatepickers();

            // Re-inisialisasi datepicker setelah konten dinamis ditambahkan
            $(document).on('DOMNodeInserted', function() {
                // Tunggu sebentar agar elemen benar-benar ada di DOM
                setTimeout(initializeDatepickers, 100);
            });
        });

        $(document).ready(function() {
            // Object configuration untuk kemudahan maintenance
            const select2Configs = {
                '#pegawai_dinilai_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#pegawai_penilai_id': {
                    placeholder: "-- Pilih Pegawai Penilai --",
                    allowClear: true
                },
                '#atasan_pegawai_penilai_id': {
                    placeholder: "-- Pilih Atasan --",
                    allowClear: true
                },
                '#pihak_pertama_id': {
                    placeholder: "-- Pilih Pihak Pertama --",
                    allowClear: true
                },
                '#pihak_kedua_id': {
                    placeholder: "-- Pilih Pihak Kedua --",
                    allowClear: true
                },
                '#atasan_id': {
                    placeholder: "-- Pilih Atasan --",
                    allowClear: true
                },
                '#penandatangan_id': {
                    placeholder: "-- Pilih Penandatangan --",
                    allowClear: true
                },
                '#diteruskan_kepada': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#tujuan': {
                    placeholder: "-- Pilih Penerima Surat --",
                    allowClear: true
                },
                '#pegawai': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#pegawai_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#ketua_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#sekretaris_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#pencatat_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#peserta': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#pemberi_izin_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#pemberi_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#penerima_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#pengirim_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#pengirim': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#penerima': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#kuasa_pengguna_anggaran_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#kepala_berangkat_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#kepala_tiba_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#pejabat_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#yth_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#dari_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                }
            };
            
            // Initialize semua Select2 elements
            Object.entries(select2Configs).forEach(([selector, config]) => {
                const $element = $(selector);
                
                // Hanya inisialisasi jika elemen ada DAN merupakan select
                if ($element.length && $element.is('select')) {
                    $element.select2({
                        ...config,
                        width: '100%'
                    });
                }
            });

            const select2ConfigDinamis = {
                placeholder: "-- Pilih Pegawai Penilai --",
                allowClear: true,
                width: '100%',
            };

            // Fungsi untuk menambahkan baris baru
            function tambahBaris() {
                const newSelectId = `pegawai_penilai_id_catatan_${currentIndex}`;
                
                // Dapatkan elemen select yang baru ditambahkan
                const newSelectElement = $(`#${newSelectId}`);
                
                // Inisialisasi Select2 pada elemen baru menggunakan konfigurasi dinamis
                newSelectElement.select2(select2ConfigDinamis);

                currentIndex++;
            }
            
            $('#tombol-tambah-baris').on('click', tambahBaris);
        });
    </script>
</body>

</html>