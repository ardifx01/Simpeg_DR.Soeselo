<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi SIMPEG RSUD Soeselo</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body class="bg-light" style="height: 100vh; margin: 0;">
    <section class="container-fluid h-100">
        <div class="row h-100">
            <!-- Kolom Gambar -->
            <div class="col-xl-9 col-md-8 d-none d-md-block p-0 h-100 ms-auto">
                <img src="{{ asset('assets/img/soeselo.png') }}" alt="Background" class="w-100 h-100 object-fit-cover" style="object-position: right;">
            </div>
            
            <div class="col-xl-3 col-md-4 col-sm-12 p-4 p-md-4">
                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if (session('loginError'))
                    <div class="alert alert-danger">
                        {{ session('loginError') }}
                        <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="text-center mb-5">
                    <img class="img-fluid mb-2" src="{{ asset('assets/img/logo.png') }}" alt="Logo Soeselo" width="100%">
                    <h3>Sistem Informasi Kepegawaian</h3>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input type="text" name="username" class="form-control form-control-lg @error('username') is-invalid @enderror"
                            id="username" placeholder="Username" autofocus required value="{{ old('username') }}">
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                            id="password" placeholder="Password" required>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3" style="display: flex; align-items: center; gap: 10px;">
                        <label class="h3" for="captcha" style="margin: 0; white-space: nowrap;">{{ session('captcha_question') }} = </label>
                        <input type="text" class="form-control form-control-lg @error('captcha') is-invalid @enderror" name="captcha" id="captcha" style="flex: 1;" required>
                    </div>                
                    @error('captcha')
                        <div class="text-danger mb-3">{{ $message }}</div>
                    @enderror
                    
                    <div class="d-grid mb-3">
                        <button class="btn btn-primary btn-lg" type="submit"><i class="bi bi-key"></i> Log in</button>
                    </div>

                    <div class="text-center">
                        <h5>Belum punya akun? Silakan <a href="#" class="link-primary text-decoration-none" target="_blank" rel="noopener noreferrer">hubungi admin</a></h5>
                    </div>

                    <hr class="mt-5 mb-4 border-secondary-subtle">
                    <div class="text-center text-secondary mb-0">
                        <h3>&copy; 2025 RSUD Dr. Soeselo</h3>
                        <h5>Sub Bagian Kepegawaian</h5>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
