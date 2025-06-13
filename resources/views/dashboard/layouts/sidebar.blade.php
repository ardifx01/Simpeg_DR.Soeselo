
<ul class="sidebar-nav" id="sidebar-nav">

<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('dashboard') }}">
    <i class="bi bi-grid"></i>
    <span>Dashboard</span>
    </a>
</li><!-- End Dashboard Nav -->

{{-- <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#manajemen-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-menu-button-wide"></i><span>Manajemen Setup</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="manajemen-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav\">
    <li>
        <a href="/dashboard/opd">
        <i class="bi bi-circle"></i><span>OPD / SKPD / Unit Kerja</span>
        </a>
    </li>
    <li>
        <a href="/dashboard/useradmin">
        <i class="bi bi-circle"></i><span>User Admin</span>
        </a>
    </li>
    <li>
        <a href="/dashboard/userpegawai">
        <i class="bi bi-circle"></i><span>User Pegawai</span>
        </a>
    </li>
    </ul>
</li><!-- End Manajemen Setup Nav --> --}}

<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('pegawai.index') }}">
    <i class="bi bi-person"></i>
    <span>Data Pegawai</span>
    </a>
</li><!-- End Data Pegawai Nav -->

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#keluarga-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-people"></i><span>Riwayat Keluarga</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="keluarga-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="{{ route('istri.index') }}">
            <i class="bi bi-circle"></i><span>Suami / Istri</span>
            </a>
        </li>
        <li>
            <a href="{{ route('anak.index') }}">
            <i class="bi bi-circle"></i><span>Anak</span>
            </a>
        </li>
    </ul>
</li><!-- End Riwayat Keluarga Nav -->

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#pendidikan-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-journal-text"></i><span>Riwayat Pendidikan</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="pendidikan-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="{{ route('pendidikan.index') }}">
            <i class="bi bi-circle"></i><span>Pendidikan Umum</span>
            </a>
        </li>
        <li>
            <a href="{{ route('ijinbelajar.index') }}">
            <i class="bi bi-circle"></i><span>Tugas Belajar / Ijin Belajar</span>
            </a>
        </li>
    </ul>
</li><!-- End Riwayat Pendidikan Nav -->

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#kepegawaian-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-layout-text-window-reverse"></i><span>Kepegawaian</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="kepegawaian-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        {{-- <li>
            <a href="/dashboard/opd">
            <i class="bi bi-circle"></i><span>OPD / SKPD / Unit Kerja</span>
            </a>
        </li> --}}
        <li>
            <a href="{{ route('jabatan.index') }}">
            <i class="bi bi-circle"></i><span>Jabatan</span>
            </a>
        </li>
        <li>
            <a href="{{ route('penghargaan.index') }}">
            <i class="bi bi-circle"></i><span>Tanda Jasa / Penghargaan / Kehormatan</span>
            </a>
        </li>
        <li>
            <a href="{{ route('organisasi.index') }}">
            <i class="bi bi-circle"></i><span>Organisasi</span>
            </a>
        </li>
    </ul>
</li><!-- End Kepegawaian Nav -->

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#diklat-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-book"></i><span>Diklat</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="diklat-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    <li>
        <a href="{{ route('diklatfungsional.index') }}">
        <i class="bi bi-circle"></i><span>Diklat Fungsional</span>
        </a>
    </li>
    <li>
        <a href="{{ route('diklatjabatan.index') }}">
        <i class="bi bi-circle"></i><span>Diklat Jabatan</span>
        </a>
    </li>
    <li>
        <a href="{{ route('diklatteknik.index') }}">
        <i class="bi bi-circle"></i><span>Diklat Teknis</span>
        </a>
    </li>
    </ul>
</li><!-- End Diklat Nav -->

{{-- <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#TPP-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-bar-chart"></i><span>TPP</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="TPP-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    <li>
        <a href="/dashboard/input">
        <i class="bi bi-circle"></i><span>Input</span>
        </a>
    </li>
    <li>
        <a href="/dashboard/laporan_bulanan">
        <i class="bi bi-circle"></i><span>Laporan Bulanan</span>
        </a>
    </li>
    </ul>
</li><!-- End Tpp Nav --> --}}

{{-- <li class="nav-item">
    <a class="nav-link collapsed" href="/dashboard/notifkgb">
    <i class="bi bi-person"></i>
    <span>Notifikasi KGB</span>
    </a>
</li><!-- End Notifikasi GKB Nav --> --}}

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#rekapitulasi-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-folder2-open"></i><span>Rekapitulasi</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="rekapitulasi-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    {{-- <li>
        <a href="/dashboard/rekap-opd-skpd-unit-kerja">
        <i class="bi bi-circle"></i><span>OPD / SKPD / Unit Kerja Title</span>
        </a>
    </li> --}}
    <li>
        <a href="{{ route('rekap.golongan') }}">
        <i class="bi bi-circle"></i><span>Golongan</span>
        </a>
    </li>
    <li>
        <a href="{{ route('rekap.jabatan') }}">
        <i class="bi bi-circle"></i><span>Jabatan</span>
        </a>
    </li>
    <li>
        <a href="{{ route('rekap.eselon') }}">
        <i class="bi bi-circle"></i><span>Eselon</span>
        </a>
    </li>
    <li>
        <a href="{{ route('rekap.kepegawaian') }}">
        <i class="bi bi-circle"></i><span>Status Kepegawaian</span>
        </a>
    </li>
    <li>
        <a href="{{ route('rekap.agama') }}">
        <i class="bi bi-circle"></i><span>Agama</span>
        </a>
    </li>
    <li>
        <a href="{{ route('rekap.jeniskelamin') }}">
        <i class="bi bi-circle"></i><span>Jenis Kelamin</span>
        </a>
    </li>
    <li>
        <a href="{{ route('rekap.statusnikah') }}">
        <i class="bi bi-circle"></i><span>Status Nikah</span>
        </a>
    </li>
    <li>
        <a href="{{ route('rekap.pendidikanakhir') }}">
        <i class="bi bi-circle"></i><span>Pendidikan Akhir</span>
        </a>
    </li>
    </ul>
</li><!-- End Rekapitulasi Nav -->

{{-- <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#report-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-printer"></i><span>Report</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="report-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    <li>
        <a href="/dashboard/nominatif">
        <i class="bi bi-circle"></i><span>Nominatif</span>
        </a>
    </li>
    <li>
        <a href="/dashboard/duk">
        <i class="bi bi-circle"></i><span>DUK</span>
        </a>
    </li>
    <li>
        <a href="/dashboard/bezetting">
        <i class="bi bi-circle"></i><span>Bezetting</span>
        </a>
    </li>
    <li>
        <a href="/dashboard/keadaanpegawai">
        <i class="bi bi-circle"></i><span>Keadaan Pegawai</span>
        </a>
    </li>
    <li>
        <a href="/dashboard/pensiun">
        <i class="bi bi-circle"></i><span>Pensiun</span>
        </a>
    </li>
    </ul>
</li><!-- End Report Nav --> --}}

{{-- <li class="/dashboard/backup_data">
    <a class="nav-link collapsed" href="users-profile.html">
    <i class="bi bi-person"></i>
    <span>Backup data</span>
    </a>
</li><!-- End Backup data Nav --> --}}

</ul>
