
<div class="d-flex align-items-center justify-content-between">
<a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
    <img src="{{ asset('assets/img/logo.png') }}" alt="">
    <span class="d-none d-lg-block"><h5>Sistem Informasi Kepegawaian</h5></span>
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
<ul class="d-flex align-items-center">

    <li class="nav-item d-block d-lg-none">
    <a class="nav-link nav-icon search-bar-toggle " href="#">
        <i class="bi bi-search"></i>
    </a>
    </li><!-- End Search Icon-->

    <li class="nav-item dropdown pe-3">

    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Profile">
        <span class="d-none d-md-block dropdown-toggle ps-2"><span class="text-warning">Welcome </span>{{ auth()->user()->username }}</span>
    </a><!-- End Profile Icon -->

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
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-items-center">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </button>
            </form>
        </li>

    </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

</ul>
</nav><!-- End Icons Navigation -->
