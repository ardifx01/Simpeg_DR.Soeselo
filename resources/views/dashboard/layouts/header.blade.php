<div class="d-flex align-items-center justify-content-between">
    <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
        <img src="{{ asset('assets/img/logo.png') }}" alt="">
        <h5 class="d-none d-lg-block ms-2">Sistem Informasi Kepegawaian</h5>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->

<div class="search-bar">
    <form action="{{ route('search') }}" method="GET" class="search-form d-flex">
        <input class="rounded-pill" type="text" name="search" placeholder="Cari Nama Pegawai ..." title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form>
</div><!-- End Search Bar -->

<nav class="header-nav ms-auto">  
    <ul class="d-flex align-items-center mb-0">
        <li class="nav-item d-block d-lg-none">
            <a class="nav-link nav-icon search-bar-toggle" href="#">
                <i class="bi bi-search"></i>
            </a>
        </li><!-- End Search Icon-->

        <!-- Notification Dropdown Start -->
        <li class="nav-item dropdown">
            <a class="nav-link nav-icon position-relative" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell fs-4"></i>
                @if(count($headerNotifications) > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ count($headerNotifications) }}
                        <span class="visually-hidden">unread notifications</span>
                    </span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-end p-0 shadow border-0" style="min-width: 370px; max-width: 400px;">
                <div class="bg-primary text-white px-4 py-3 rounded-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-bell-fill me-2 animate__animated animate__tada"></i>Notifikasi</span>
                        <span class="badge bg-light text-primary">{{ count($headerNotifications) }}</span>
                    </div>
                    <div class="small text-light">Terkait KGB / Kenaikan Pangkat</div>
                </div>
                <div style="max-height: 400px; overflow-y: auto;">
                    <ul class="list-group list-group-flush">
                        @forelse ($headerNotifications as $notif)
                            <li class="list-group-item notification-item d-flex align-items-start border-0 border-bottom">
                                <span class="me-3 mt-2">
                                    <span class="badge
                                        @if($notif['type'] === 'KGB') bg-info
                                        @elseif($notif['type'] === 'PANGKAT') bg-success
                                        @else bg-secondary
                                        @endif
                                        p-3 fs-5 shadow-sm">
                                        <i class="fa
                                            @if($notif['type'] === 'KGB') fa-arrow-up
                                            @elseif($notif['type'] === 'PANGKAT') fa-user
                                            @else fa-info
                                            @endif"></i>
                                    </span>
                                </span>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold mb-1">{{ $notif['nama'] }}</div>
                                    <div class="text-muted small">{{ $notif['message'] }}</div>
                                </div>
                                <span class="text-muted small ms-2 mt-1">{{ now()->format('H:i') }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted py-4 border-0">
                                <i class="fa fa-check-circle mb-2 d-block" style="font-size: 2rem;"></i>
                                <div class="mb-1">Tidak ada notifikasi</div>
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="py-2 text-center border-top bg-light rounded-bottom">
                    <a href="{{ route('rekap.kgbpangkat') }}" class="fw-bold text-primary text-decoration-none">
                        Lihat Rekap KGB & Pangkat <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </li>
        <!-- Notification Dropdown End -->

        <!-- Profile Dropdown Start -->
        <li class="nav-item dropdown pe-3">
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Profile" class="rounded-circle" width="32" height="32">
                <span class="d-none d-md-block dropdown-toggle ps-2">
                    <span class="text-warning">Welcome </span>{{ auth()->user()->username }}
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('password.change') }}">
                        <i class="bi bi-gear"></i>
                        <span>Change Password</span>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="/logout" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
        <!-- Profile Dropdown End -->

    </ul>
</nav><!-- End Icons Navigation -->