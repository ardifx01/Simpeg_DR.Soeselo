@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Detail Sasaran Kerja</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('skp.index') }}">Daftar Sasaran Kerja</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Sasaran Kerja</li>
                </ol>
            </nav>
        </div>
        <div class="col-auto">
            <div class="btn-group" role="group">
                <a href="{{ route('skp.edit', $skp->id) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <div class="btn-group" role="group">
                    <button class="btn btn-primary btn-sm dropdown-toggle shadow-sm d-flex align-items-center gap-2" 
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-printer"></i> <span>Cetak</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end animate__animated animate__fadeIn">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('skp.cetak.pdf', $skp->id) }}" target="_blank">
                                <i class="bi bi-file-earmark-pdf text-danger"></i> <span>Export PDF</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('skp.cetak.word', $skp->id) }}">
                                <i class="bi bi-file-earmark-word text-primary"></i> <span>Export Word</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('skp.cetak.excel', $skp->id) }}">
                                <i class="bi bi-file-earmark-excel text-success"></i> <span>Export Excel</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Header SKP -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2 class="fw-bold">SASARAN KERJA PEGAWAI (SKP)</h2>
                <h3 class="text-muted">TAHUN {{ $skp->tahun }}</h3>
            </div>
            
            <div class="row g-4">
                {{-- Pegawai yang Dinilai --}}
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%" class="fw-semibold">Pegawai yang Dinilai</td>
                            <td width="5%">:</td>
                            <td>{{ $skp->pegawaiDinilai->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">NIP</td>
                            <td>:</td>
                            <td>{{ $skp->pegawaiDinilai->nip }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Pangkat / Gol. Ruang</td>
                            <td>:</td>
                            <td>{{ $skp->pegawaiDinilai->jabatan->pangkat ?? '-' }} ({{ $skp->pegawaiDinilai->jabatan->golongan_ruang ?? '-' }})</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Jabatan</td>
                            <td>:</td>
                            <td>{{ $skp->pegawaiDinilai->jabatan->nama_jabatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Unit Kerja</td>
                            <td>:</td>
                            <td>RSUD dr. Soeselo Kab. Tegal</td>
                        </tr>
                    </table>
                </div>

                {{-- Pegawai Penilai + Atasannya --}}
                <div class="col-md-6">
                    <table class="table table-borderless mb-4">
                        <tr>
                            <td width="40%" class="fw-semibold">Pegawai Penilai</td>
                            <td width="5%">:</td>
                            <td>{{ $skp->pegawaiPenilai->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">NIP</td>
                            <td>:</td>
                            <td>{{ $skp->pegawaiPenilai->nip }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Pangkat / Gol. Ruang</td>
                            <td>:</td>
                            <td>{{ $skp->pegawaiPenilai->jabatan->pangkat ?? '-' }} ({{ $skp->pegawaiPenilai->jabatan->golongan_ruang ?? '-' }})</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Jabatan</td>
                            <td>:</td>
                            <td>{{ $skp->pegawaiPenilai->jabatan->nama_jabatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Unit Kerja</td>
                            <td>:</td>
                            <td>RSUD dr. Soeselo Kab. Tegal</td>
                        </tr>
                    </table>

                    <table class="table table-borderless">
                        <tr>
                            <td width="40%" class="fw-semibold">Atasan Pejabat Penilai</td>
                            <td width="5%">:</td>
                            <td>{{ $skp->atasanPegawaiPenilai->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">NIP</td>
                            <td>:</td>
                            <td>{{ $skp->atasanPegawaiPenilai->nip }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Pangkat / Gol. Ruang</td>
                            <td>:</td>
                            <td>{{ $skp->atasanPegawaiPenilai->jabatan->pangkat ?? '-' }} ({{ $skp->atasanPegawaiPenilai->jabatan->golongan_ruang ?? '-' }})</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Jabatan</td>
                            <td>:</td>
                            <td>{{ $skp->atasanPegawaiPenilai->jabatan->nama_jabatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Unit Kerja</td>
                            <td>:</td>
                            <td>RSUD dr. Soeselo Kab. Tegal</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Kegiatan Tugas Jabatan -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-briefcase"></i> Kegiatan Tugas Jabatan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th rowspan="2" class="text-center align-middle">No</th>
                            <th rowspan="2" class="text-center align-middle">Kegiatan</th>
                            <th rowspan="2" class="text-center align-middle">AK</th>
                            <th colspan="4" class="text-center">Target</th>
                            <th colspan="4" class="text-center">Realisasi</th>
                            <th rowspan="2" class="text-center align-middle">Nilai Capaian SKP</th>
                        </tr>
                        <tr>
                            <th class="text-center">Output</th>
                            <th class="text-center">Mutu (%)</th>
                            <th class="text-center">Waktu (Bulan)</th>
                            <th class="text-center">Biaya (Rp)</th>
                            <th class="text-center">Output</th>
                            <th class="text-center">Mutu (%)</th>
                            <th class="text-center">Waktu (Bulan)</th>
                            <th class="text-center">Biaya (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($skp->kegiatan as $index => $kegiatan)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $kegiatan->nama_kegiatan }}</td>
                                <td class="text-center">{{ $kegiatan->ak ?? '-' }}</td>
                                <td class="text-center">{{ $kegiatan->target_kuantitatif_output }}</td>
                                <td class="text-center">{{ $kegiatan->target_kualitatif_mutu }}</td>
                                <td class="text-center">{{ $kegiatan->target_waktu_bulan }} Bulan</td>
                                <td class="text-end">{{ number_format($kegiatan->target_biaya ?? 0, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $kegiatan->realisasi_kuantitatif_output ?? '-' }}</td>
                                <td class="text-center">{{ $kegiatan->realisasi_kualitatif_mutu ?? '-' }}</td>
                                <td class="text-center">{{ $kegiatan->realisasi_waktu_bulan ?? '-' }} Bulan</td>
                                <td class="text-end">{{ number_format($kegiatan->realisasi_biaya ?? 0, 0, ',', '.') }}</td>
                                <td class="text-center fw-bold">{{ number_format($kegiatan->nilai_kegiatan / 4, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">Tidak ada data kegiatan tugas jabatan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tugas Tambahan -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="bi bi-person-plus"></i> Tugas Tambahan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Kegiatan</th>
                            <th class="text-center">Nilai Tambahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($skp->tugasTambahan as $index => $tugas)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $tugas->nama_tambahan }}</td>
                                <td class="text-center">{{ $tugas->nilai_tambahan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada tugas tambahan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Rekapitulasi Nilai -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="bi bi-calculator"></i> Rekapitulasi Penilaian</h5>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-semibold">Nilai Capaian SKP</td>
                            <td>:</td>
                            <td class="fw-bold text-primary">{{ number_format($skp->nilai_capaian_skp, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Nilai Perilaku</td>
                            <td>:</td>
                            <td class="fw-bold text-success">{{ number_format($skp->nilai_perilaku, 2) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-semibold">Nilai Akhir</td>
                            <td>:</td>
                            <td class="fw-bold text-warning fs-5">{{ number_format($skp->nilai_akhir, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Kategori</td>
                            <td>:</td>
                            <td>
                                <span class="badge 
                                    @if($skp->kategori == 'Sangat Baik') bg-success
                                    @elseif($skp->kategori == 'Baik') bg-primary
                                    @elseif($skp->kategori == 'Cukup') bg-warning
                                    @elseif($skp->kategori == 'Kurang') bg-orange
                                    @else bg-danger
                                    @endif fs-6">
                                    {{ $skp->kategori }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Catatan Penilaian -->
    @if($skp->catatanPenilaian)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="bi bi-journal-text"></i> Catatan Penilaian</h5>
        </div>
        <div class="card-body">
            <div class="border-start border-4 border-info ps-3 mb-3">
                <div class="row">
                    <div class="col-md-8">
                    <div class="col-md-8">
                    <ul class="list-group">
                        @foreach($formattedUraian as $aspek => $data)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ ucfirst(str_replace('_', ' ', $aspek)) }}
                                <span>{{ $data['nilai'] }} ({{ $data['kategori'] }})</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                </div>
                    <div class="col-md-4 text-end">
                        <small class="text-muted">
                            <strong>{{ $skp->catatanPenilaian->nama_pegawai_penilai }}</strong><br>
                            NIP: {{ $skp->catatanPenilaian->nip_pegawai_penilai }}<br>
                            {{ \Carbon\Carbon::parse($skp->catatanPenilaian->tanggal)->format('d F Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection