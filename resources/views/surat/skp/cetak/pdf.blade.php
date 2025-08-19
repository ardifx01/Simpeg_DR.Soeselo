<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SKP {{ $skp->pegawaiDinilai->nama }} - {{ $skp->tahun }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 5px 0;
        }
        .header h2 {
            font-size: 14px;
            margin: 0;
            color: #666;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 3px 5px;
            vertical-align: top;
        }
        .info-table .label {
            width: 30%;
            font-weight: bold;
        }
        .info-table .colon {
            width: 2%;
        }
        .section-title {
            background: #f0f0f0;
            padding: 8px 10px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            border: 1px solid #ddd;
        }
        .kegiatan-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
        }
        .kegiatan-table th,
        .kegiatan-table td {
            border: 1px solid #333;
            padding: 4px;
            text-align: center;
        }
        .kegiatan-table th {
            background: #f5f5f5;
            font-weight: bold;
        }
        .kegiatan-table td.left {
            text-align: left;
        }
        .kegiatan-table td.right {
            text-align: right;
        }
        .nilai-section {
            display: flex;
            margin: 20px 0;
        }
        .nilai-left, .nilai-right {
            width: 50%;
            padding: 0 10px;
        }
        .nilai-table {
            width: 100%;
        }
        .nilai-table td {
            padding: 5px;
            border-bottom: 1px solid #eee;
        }
        .nilai-table .label {
            font-weight: bold;
            width: 60%;
        }
        .catatan-item {
            border-left: 4px solid #007bff;
            padding-left: 10px;
            margin-bottom: 15px;
        }
        .catatan-content {
            margin-bottom: 5px;
        }
        .catatan-meta {
            font-size: 10px;
            color: #666;
            text-align: right;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SASARAN KERJA PEGAWAI (SKP)</h1>
        <h2>TAHUN {{ $skp->tahun }}</h2>
    </div>

    <table style="width: 100%">
        <tr>
            <td width="50%" style="vertical-align: top;">
                <table class="info-table">
                    <tr>
                        <td class="label">Pegawai yang Dinilai</td>
                        <td class="colon">:</td>
                        <td>{{ $skp->pegawaiDinilai->nama }}</td>
                    </tr>
                    <tr>
                        <td class="label">NIP</td>
                        <td class="colon">:</td>
                        <td>{{ $skp->pegawaiDinilai->nip }}</td>
                    </tr>
                    <tr>
                        <td class="label">Pangkat / Gol. Ruang</td>
                        <td class="colon">:</td>
                        <td>{{ $skp->pegawaiDinilai->jabatan->pangkat ?? '-' }} ({{ $skp->pegawaiDinilai->jabatan->golongan_ruang ?? '-' }})</td>
                    </tr>
                    <tr>
                        <td class="label">Jabatan</td>
                        <td class="colon">:</td>
                        <td>{{ $skp->pegawaiDinilai->jabatan->nama_jabatan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Unit Kerja</td>
                        <td class="colon">:</td>
                        <td>RSUD dr. Soeselo Kab. Tegal</td>
                    </tr>
                </table>
            </td>
            <td width="50%" style="vertical-align: top;">
                <table class="info-table">
                    <tr>
                        <td class="label">Pegawai Penilai</td>
                        <td class="colon">:</td>
                        <td>{{ $skp->pegawaiPenilai->nama }}</td>
                    </tr>
                    <tr>
                        <td class="label">NIP</td>
                        <td class="colon">:</td>
                        <td>{{ $skp->pegawaiPenilai->nip }}</td>
                    </tr>
                    <tr>
                        <td class="label">Pangkat / Gol. Ruang</td>
                        <td class="colon">:</td>
                        <td>{{ $skp->pegawaiPenilai->jabatan->pangkat ?? '-' }} ({{ $skp->pegawaiPenilai->jabatan->golongan_ruang ?? '-' }})</td>
                    </tr>
                    <tr>
                        <td class="label">Jabatan</td>
                        <td class="colon">:</td>
                        <td>{{ $skp->pegawaiPenilai->jabatan->nama_jabatan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Unit Kerja</td>
                        <td class="colon">:</td>
                        <td>RSUD dr. Soeselo Kab. Tegal</td>
                    </tr>
                </table>

                <table class="info-table" style="margin-top: 15px;">
                    <tr>
                        <td class="label">Atasan Pejabat Penilai</td>
                        <td class="colon">:</td>
                        <td>{{ $skp->atasanPegawaiPenilai->nama }}</td>
                    </tr>
                    <tr>
                        <td class="label">NIP</td>
                        <td class="colon">:</td>
                        <td>{{ $skp->atasanPegawaiPenilai->nip }}</td>
                    </tr>
                    <tr>
                        <td class="label">Pangkat / Gol. Ruang</td>
                        <td class="colon">:</td>
                        <td>{{ $skp->atasanPegawaiPenilai->jabatan->pangkat ?? '-' }} ({{ $skp->atasanPegawaiPenilai->jabatan->golongan_ruang ?? '-' }})</td>
                    </tr>
                    <tr>
                        <td class="label">Jabatan</td>
                        <td class="colon">:</td>
                        <td>{{ $skp->atasanPegawaiPenilai->jabatan->nama_jabatan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Unit Kerja</td>
                        <td class="colon">:</td>
                        <td>RSUD dr. Soeselo Kab. Tegal</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Tampilkan kegiatan berdasarkan jenis Dokumen --}}
    @if($kegiatanDokumen->count() > 0)
    <div class="section-title">DOKUMEN</div>
    <table class="kegiatan-table">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Kegiatan</th>
                <th rowspan="2">AK</th>
                <th colspan="4">Target</th>
                <th colspan="4">Realisasi</th>
                <th rowspan="2">Nilai</th>
            </tr>
            <tr>
                <th>Output</th>
                <th>Mutu</th>
                <th>Waktu</th>
                <th>Biaya</th>
                <th>Output</th>
                <th>Mutu</th>
                <th>Waktu</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kegiatanDokumen as $index => $kegiatan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="left">{{ $kegiatan->nama_kegiatan }}</td>
                <td>{{ $kegiatan->ak ?? '-' }}</td>
                <td>{{ $kegiatan->target_kuantitatif_output }}</td>
                <td>{{ $kegiatan->target_kualitatif_mutu }}</td>
                <td>{{ $kegiatan->target_waktu_bulan }}</td>
                <td class="right">{{ number_format($kegiatan->target_biaya ?? 0, 0, ',', '.') }}</td>
                <td>{{ $kegiatan->realisasi_kuantitatif_output ?? '-' }}</td>
                <td>{{ $kegiatan->realisasi_kualitatif_mutu ?? '-' }}</td>
                <td>{{ $kegiatan->realisasi_waktu_bulan ?? '-' }}</td>
                <td class="right">{{ number_format($kegiatan->realisasi_biaya ?? 0, 0, ',', '.') }}</td>
                <td><strong>{{ number_format($kegiatan->nilai_kegiatan / 4, 2) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- Tampilkan kegiatan berdasarkan jenis Kegiatan --}}
    @if($kegiatanKegiatan->count() > 0)
    <div class="section-title">OPERASIONAL</div>
    <table class="kegiatan-table">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Kegiatan</th>
                <th rowspan="2">AK</th>
                <th colspan="4">Target</th>
                <th colspan="4">Realisasi</th>
                <th rowspan="2">Nilai</th>
            </tr>
            <tr>
                <th>Output</th>
                <th>Mutu</th>
                <th>Waktu</th>
                <th>Biaya</th>
                <th>Output</th>
                <th>Mutu</th>
                <th>Waktu</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kegiatanKegiatan as $index => $kegiatan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="left">{{ $kegiatan->nama_kegiatan }}</td>
                <td>{{ $kegiatan->ak ?? '-' }}</td>
                <td>{{ $kegiatan->target_kuantitatif_output }}</td>
                <td>{{ $kegiatan->target_kualitatif_mutu }}</td>
                <td>{{ $kegiatan->target_waktu_bulan }}</td>
                <td class="right">{{ number_format($kegiatan->target_biaya ?? 0, 0, ',', '.') }}</td>
                <td>{{ $kegiatan->realisasi_kuantitatif_output ?? '-' }}</td>
                <td>{{ $kegiatan->realisasi_kualitatif_mutu ?? '-' }}</td>
                <td>{{ $kegiatan->realisasi_waktu_bulan ?? '-' }}</td>
                <td class="right">{{ number_format($kegiatan->realisasi_biaya ?? 0, 0, ',', '.') }}</td>
                <td><strong>{{ number_format($kegiatan->nilai_kegiatan / 4, 2) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- Tampilkan kegiatan berdasarkan jenis Lapangan --}}
    @if($kegiatanLapangan->count() > 0)
    <div class="section-title">LAPANGAN</div>
    <table class="kegiatan-table">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Kegiatan</th>
                <th rowspan="2">AK</th>
                <th colspan="4">Target</th>
                <th colspan="4">Realisasi</th>
                <th rowspan="2">Nilai</th>
            </tr>
            <tr>
                <th>Output</th>
                <th>Mutu</th>
                <th>Waktu</th>
                <th>Biaya</th>
                <th>Output</th>
                <th>Mutu</th>
                <th>Waktu</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kegiatanLapangan as $index => $kegiatan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="left">{{ $kegiatan->nama_kegiatan }}</td>
                <td>{{ $kegiatan->ak ?? '-' }}</td>
                <td>{{ $kegiatan->target_kuantitatif_output }}</td>
                <td>{{ $kegiatan->target_kualitatif_mutu }}</td>
                <td>{{ $kegiatan->target_waktu_bulan }}</td>
                <td class="right">{{ number_format($kegiatan->target_biaya ?? 0, 0, ',', '.') }}</td>
                <td>{{ $kegiatan->realisasi_kuantitatif_output ?? '-' }}</td>
                <td>{{ $kegiatan->realisasi_kualitatif_mutu ?? '-' }}</td>
                <td>{{ $kegiatan->realisasi_waktu_bulan ?? '-' }}</td>
                <td class="right">{{ number_format($kegiatan->realisasi_biaya ?? 0, 0, ',', '.') }}</td>
                <td><strong>{{ number_format($kegiatan->nilai_kegiatan / 4, 2) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if($allKegiatan->count() > 0)
    <div class="section-title">SEMUA KEGIATAN TUGAS JABATAN</div>
    <table class="kegiatan-table">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Jenis</th>
                <th rowspan="2">Kegiatan</th>
                <th rowspan="2">AK</th>
                <th colspan="4">Target</th>
                <th colspan="4">Realisasi</th>
                <th rowspan="2">Nilai</th>
            </tr>
            <tr>
                <th>Output</th>
                <th>Mutu</th>
                <th>Waktu</th>
                <th>Biaya</th>
                <th>Output</th>
                <th>Mutu</th>
                <th>Waktu</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allKegiatan as $index => $kegiatan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $kegiatan->jenis_kegiatan }}</td>
                <td class="left">{{ $kegiatan->nama_kegiatan }}</td>
                <td>{{ $kegiatan->ak ?? '-' }}</td>
                <td>{{ $kegiatan->target_kuantitatif_output }}</td>
                <td>{{ $kegiatan->target_kualitatif_mutu }}</td>
                <td>{{ $kegiatan->target_waktu_bulan }}</td>
                <td class="right">{{ number_format($kegiatan->target_biaya ?? 0, 0, ',', '.') }}</td>
                <td>{{ $kegiatan->realisasi_kuantitatif_output ?? '-' }}</td>
                <td>{{ $kegiatan->realisasi_kualitatif_mutu ?? '-' }}</td>
                <td>{{ $kegiatan->realisasi_waktu_bulan ?? '-' }}</td>
                <td class="right">{{ number_format($kegiatan->realisasi_biaya ?? 0, 0, ',', '.') }}</td>
                <td><strong>{{ number_format($kegiatan->nilai_kegiatan / 4, 2) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="section-title">TUGAS TAMBAHAN</div>
    <table class="kegiatan-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kegiatan</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse($skp->tugasTambahan as $index => $tugas)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="left">{{ $tugas->nama_tambahan }}</td>
                <td class="right">{{ number_format($tugas->nilai_tambahan, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Tidak ada tugas tambahan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">REKAPITULASI PENILAIAN</div>
    <table style="width: 100%">
        <tr>
            <td width="50%" style="vertical-align: top;">
                <table class="nilai-table">
                    <tr>
                        <td class="label">Nilai Capaian SKP</td>
                        <td>:</td>
                        <td><strong>{{ number_format($skp->nilai_capaian_skp, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td class="label">Nilai Perilaku</td>
                        <td>:</td>
                        <td><strong>{{ number_format($skp->nilai_perilaku, 2) }}</strong></td>
                    </tr>
                </table>
            </td>
            <td width="50%" style="vertical-align: top;">
                <table class="nilai-table">
                    <tr>
                        <td class="label">Nilai Akhir</td>
                        <td>:</td>
                        <td><strong style="font-size: 14px;">{{ number_format($skp->nilai_akhir, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td class="label">Kategori</td>
                        <td>:</td>
                        <td><strong>{{ $skp->kategori }}</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    @if($skp->catatanPenilaian)
        <div class="section-title">CATATAN PENILAIAN</div>
        <div class="catatan-item">
            <div class="catatan-content">{!! nl2br(e($formattedUraian)) !!}</div>
            <div class="catatan-meta">
                <strong>{{ $skp->catatanPenilaian->nama_pegawai_penilai }}</strong><br>
                NIP: {{ $skp->catatanPenilaian->nip_pegawai_penilai }}<br>
                {{ \Carbon\Carbon::parse($skp->catatanPenilaian->tanggal)->format('d F Y') }}
            </div>
        </div>
    @endif

    <div style="margin-top: 40px;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 33%; text-align: center; vertical-align: top;">
                    <div>Pegawai yang Dinilai</div>
                    <div style="height: 60px;"></div>
                    <div style="border-bottom: 1px solid #000; margin: 0 10px;"></div>
                    <div>{{ $skp->pegawaiDinilai->nama }}</div>
                    <div>NIP. {{ $skp->pegawaiDinilai->nip }}</div>
                </td>
                <td style="width: 33%; text-align: center; vertical-align: top;">
                    <div>Pejabat Penilai</div>
                    <div style="height: 60px;"></div>
                    <div style="border-bottom: 1px solid #000; margin: 0 10px;"></div>
                    <div>{{ $skp->pegawaiPenilai->nama }}</div>
                    <div>NIP. {{ $skp->pegawaiPenilai->nip }}</div>
                </td>
                <td style="width: 33%; text-align: center; vertical-align: top;">
                    <div>Atasan Pejabat Penilai</div>
                    <div style="height: 60px;"></div>
                    <div style="border-bottom: 1px solid #000; margin: 0 10px;"></div>
                    <div>{{ $skp->atasanPegawaiPenilai->nama }}</div>
                    <div>NIP. {{ $skp->atasanPegawaiPenilai->nip }}</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>