<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-icon {
            font-size: 4rem;
            color: #dc3545;
            animation: bounce 1.3s infinite alternate;
        }
        @keyframes bounce {
            0%   { transform: translateY(0);}
            100% { transform: translateY(-12px);}
        }
        @media (max-width: 576px) {
            .error-code { font-size: 2.5rem !important; }
            .error-icon { font-size: 2.5rem !important; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-md-7 col-lg-5">
            <div class="bg-white rounded-4 shadow-lg p-4 p-md-5 text-center animate__animated animate__fadeIn">
                <div class="error-icon mb-2"><i class="bi bi-emoji-frown"></i></div>
                <div class="error-code fw-bold display-4 text-danger">404</div>
                <div class="h5 fw-semibold text-secondary mb-2">Halaman Tidak Ditemukan</div>
                <p class="mb-4 text-muted">Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan.<br>Pastikan alamat URL sudah benar.</p>
                <a href="{{ route('dashboard') }}" class="btn btn-primary px-4">
                    <i class="bi bi-house-door"></i> Kembali ke Beranda
                </a>
            </div>
            </div>
        </div>
    </div>
</body>
</html>