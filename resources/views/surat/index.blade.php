@extends('surat.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="d-flex justify-content-between">
                <div>
                    <h1>E-surat <small>Keperluan Surat Kepegawaian</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item active">E-surat</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <button id="btnTanggal" class="btn btn-primary btn-sm">
                        <i class="bi bi-calendar3"></i> <span id="tanggalSekarang"></span>
                    </button> 
                </div>
            </div>
        </div><!-- End E-surat Title -->

        @php
        $cards = [
            ['route' => 'cuti.index',             'title' => 'Surat Cuti',              'icon' => 'bi-file-text',             'subtitle' => 'Ajukan Surat',  'class' => 'cuti-card'],
            ['route' => 'tugas_belajar.index',    'title' => 'Surat Tugas Belajar',     'icon' => 'bi-mortarboard',           'subtitle' => 'Ajukan Surat',  'class' => 'tugas-belajar-card'],
            ['route' => 'rawat.index',            'title' => 'Surat Keterangan Rawat',  'icon' => 'bi-heart-pulse',           'subtitle' => 'Ajukan Surat',  'class' => 'rawat-card'],
            ['route' => 'hukuman.index',          'title' => 'Surat Hukuman Disiplin',  'icon' => 'bi-exclamation-octagon',   'subtitle' => 'Ajukan Surat',  'class' => 'hukuman-card'],
            ['route' => 'pembinaan.index',        'title' => 'Surat Pembinaan',         'icon' => 'bi-chat-square-quote',     'subtitle' => 'Ajukan Surat',  'class' => 'pembinaan-card'],
            ['route' => 'berita_acara.index',     'title' => 'Berita Acara',            'icon' => 'bi-journal-text',          'subtitle' => 'Ajukan Surat',  'class' => 'berita-acara-card'],
            ['route' => 'dinas.index',            'title' => 'Surat Dinas',             'icon' => 'bi-briefcase',             'subtitle' => 'Ajukan Surat',  'class' => 'dinas-card'],
            ['route' => 'disposisi.index',        'title' => 'Surat Disposisi',         'icon' => 'bi-inbox',                 'subtitle' => 'Ajukan Surat',  'class' => 'disposisi-card'],
            ['route' => 'edaran.index',           'title' => 'Surat Edaran',            'icon' => 'bi-megaphone',             'subtitle' => 'Ajukan Surat',  'class' => 'edaran-card'],
            ['route' => 'keterangan.index',       'title' => 'Surat Keterangan',        'icon' => 'bi-card-checklist',        'subtitle' => 'Ajukan Surat',  'class' => 'keterangan-card'],
            ['route' => 'kuasa.index',            'title' => 'Surat Kuasa',             'icon' => 'bi-shield-check',          'subtitle' => 'Ajukan Surat',  'class' => 'kuasa-card'],
            ['route' => 'nota_dinas.index',       'title' => 'Nota Dinas',              'icon' => 'bi-stickies',              'subtitle' => 'Ajukan Surat',  'class' => 'nota-dinas-card'],
            ['route' => 'notula.index',           'title' => 'Notula',                  'icon' => 'bi-pen',                   'subtitle' => 'Ajukan Surat',  'class' => 'notula-card'],
            ['route' => 'panggilan.index',        'title' => 'Surat Panggilan',         'icon' => 'bi-telephone',             'subtitle' => 'Ajukan Surat',  'class' => 'panggilan-card'],
            ['route' => 'pemberian_izin.index',   'title' => 'Surat Pemberian Izin',    'icon' => 'bi-person-check',          'subtitle' => 'Ajukan Surat',  'class' => 'izin-card'],
            ['route' => 'penetapan.index',        'title' => 'Surat Penetapan',         'icon' => 'bi-check2-square',         'subtitle' => 'Ajukan Surat',  'class' => 'penetapan-card'],
            ['route' => 'pengantar.index',        'title' => 'Surat Pengantar',         'icon' => 'bi-send',                  'subtitle' => 'Ajukan Surat',  'class' => 'pengantar-card'],
            ['route' => 'pengumuman.index',       'title' => 'Surat Pengumuman',        'icon' => 'bi-broadcast',             'subtitle' => 'Ajukan Surat',  'class' => 'pengumuman-card'],
            ['route' => 'perintah.index',         'title' => 'Surat Perintah',          'icon' => 'bi-flag',                  'subtitle' => 'Ajukan Surat',  'class' => 'perintah-card'],
            ['route' => 'perjalanan_dinas.index', 'title' => 'Surat Perjalanan Dinas',  'icon' => 'bi-geo-alt',               'subtitle' => 'Ajukan Surat',  'class' => 'perjalanan-dinas-card'],
            ['route' => 'pernyataan.index',       'title' => 'Surat Pernyataan Pegawai','icon' => 'bi-pencil-square',         'subtitle' => 'Ajukan Surat',  'class' => 'pernyataan-card'],
            ['route' => 'sertifikat.index',       'title' => 'Sertifikat Pegawai',      'icon' => 'bi-award',                 'subtitle' => 'Ajukan Surat',  'class' => 'sertifikat-card'],
            ['route' => 'telaahan.index',         'title' => 'telaahan Pegawai',        'icon' => 'bi-search',                'subtitle' => 'Ajukan Surat',  'class' => 'telaahan-card'],
            ['route' => 'tugas.index',            'title' => 'tugas Pegawai',           'icon' => 'bi-clipboard-check',       'subtitle' => 'Ajukan Surat',  'class' => 'tugas-card'],
            ['route' => 'undangan.index',         'title' => 'undangan Pegawai',        'icon' => 'bi-envelope-open',         'subtitle' => 'Ajukan Surat',  'class' => 'undangan-card'],
            ['route' => 'skp.index',              'title' => 'Penilaian Capaian SKP',   'icon' => 'bi-file-earmark-bar-graph','subtitle'=> 'Kelola Penilaian','class' => 'skp-card'],
        ];
        @endphp

        <section class="section dashboard">
            <div class="row g-3">
                @foreach ($cards as $c)
                <div class="col-xxl-3 col-md-6">
                    <a href="{{ route($c['route']) }}" aria-label="{{ $c['title'] }}" class="text-decoration-none">
                    <div class="card info-card shadow-sm border-0 h-100 {{ $c['class'] }}" data-aos="zoom-in">
                        <div class="card-body d-flex align-items-center gap-3">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi {{ $c['icon'] }}"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $c['title'] }}</h6>
                            <small class="text-muted">{{ $c['subtitle'] }}</small>
                        </div>
                        </div>
                    </div>
                    </a>
                </div>
                @endforeach
            </div>
        </section>

@endsection