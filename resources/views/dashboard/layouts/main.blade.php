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

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        @include('dashboard.layouts.header')

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        @include('dashboard.layouts.sidebar')

    </aside><!-- End Sidebar-->

    <main id="main" class="main">
        {{-- Notifikasi berhasil --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Notifikasi error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('main')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        @include('dashboard.layouts.footer')

    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- jQuery dan Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        $(document).ready(function () {
            let dateFields = [
                {id: '#tanggal_lahir', button: '[for="tanggal_lahir"]'},
                {id: '#tanggal_nikah', button: '[for="tanggal_nikah"]'},
                {id: '#tahun_lulus', button: '[for="tahun_lulus"]'},
                {id: '#tanggal_ijazah', button: '[for="tanggal_ijazah"]'},
                {id: '#tahun', button: '[for="tahun"]'},
                {id: '#tanggal_selesai', button: '[for="tanggal_selesai"]'},
                {id: '#tmt_golongan_ruang', button: '[for="tmt_golongan_ruang"]'},
                {id: '#tmt_golongan_ruang_cpns', button: '[for="tmt_golongan_ruang_cpns"]'},
                {id: '#tmt_pns', button: '[for="tmt_pns"]'},
                {id: '#tmt_jabatan', button: '[for="tmt_jabatan"]'},
                {id: '#tahun_diklat_pimpinan', button: '[for="tahun_diklat_pimpinan"]'},
                {id: '#tmt', button: '[for="tmt"]'}
            ];
            
            // Inisialisasi datepicker untuk semua field
            dateFields.forEach(function(field) {
                $(field.id).datepicker({
                    autoclose: true,
                    clearBtn: true,
                    format: "yyyy-mm-dd",
                    todayHighlight: true,
                    orientation: "bottom auto"
                });
                
                // Tambahkan event handler untuk button calendar
                $(field.button).click(function() {
                    $(field.id).datepicker('show');
                });
            });
        });

        $(document).ready(function() {
            // Object configuration untuk kemudahan maintenance
            const select2Configs = {
                '#pegawai_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#jenis_kepegawaian': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#unit_kerja': {
                    placeholder: "RSUD dr. Soeselo Slawi",
                    allowClear: true
                },
                '#kategori': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#jenis_jabatan': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#eselon': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#jenis_kelamin': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#agama': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#tingkat': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#status': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#golongan_dari': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#golongan_sampai': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
            };
            
            // Initialize semua Select2 elements
            Object.entries(select2Configs).forEach(([selector, config]) => {
                $(selector).select2({
                    ...config,
                    width: '100%' // Default option tambahan
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            let spanTanggal = document.getElementById("tanggalSekarang");

            // Ambil tanggal sekarang
            let today = new Date();
            let options = { day: "numeric", month: "long", year: "numeric" };
            let formattedDate = today.toLocaleDateString("id-ID", options); // Format: dd mm yyyy

            // Set value pada span
            spanTanggal.textContent = formattedDate;
        });

        document.getElementById('per_page').addEventListener('change', function() {
            this.form.submit();
        });
        document.getElementById('jenis_kepegawaian').addEventListener('change', function() {
            this.form.submit();
        });
    </script>
</body>

</html>