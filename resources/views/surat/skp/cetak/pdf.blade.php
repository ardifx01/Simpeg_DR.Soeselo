<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
    <title>SKP {{ $skp->pegawaiDinilai->nama }} Tahun {{ $skp->tahun }}</title>

    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .table-borderless td { border: none; padding: 8px; }
        table.bordered, table.bordered th, table.bordered td {
            border: 1px solid black;
        }
        table th, table td {
            padding: 8px;
        }
        .header-title {
            font-size: 14px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

    <div class="text-center">
        <h2 class="fw-bold">SASARAN KERJA PEGAWAI (SKP)</h2>
        <h3>TAHUN {{ $skp->tahun }}</h3>
    </div>
    
    <div class="header-skp">
        <table class="table-borderless" style="width: 50%; float: left;">
            <tr>
                <td width="40%" class="fw-bold">Pegawai yang Dinilai</td>
                <td width="5%">:</td>
                <td>{{ $skp->pegawaiDinilai->nama }}</td>
            </tr>
            <tr>
                <td class="fw-bold">NIP</td>
                <td>:</td>
                <td>{{ $skp->pegawaiDinilai->nip }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Pangkat / Gol. Ruang</td>
                <td>:</td>
                <td>{{ $skp->pegawaiDinilai->jabatan->pangkat ?? '-' }} / {{ $skp->pegawaiDinilai->jabatan->golongan_ruang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Jabatan</td>
                <td>:</td>
                <td>{{ $skp->pegawaiDinilai->jabatan->nama_jabatan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Unit Kerja</td>
                <td>:</td>
                <td>RSUD dr. Soeselo Kab. Tegal</td>
            </tr>
        </table>

        <table class="table-borderless" style="width: 50%; float: left;">
            <tr>
                <td width="40%" class="fw-bold">Pegawai Penilai</td>
                <td width="5%">:</td>
                <td>{{ $skp->pegawaiPenilai->nama }}</td>
            </tr>
            <tr>
                <td class="fw-bold">NIP</td>
                <td>:</td>
                <td>{{ $skp->pegawaiPenilai->nip }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Pangkat / Gol. Ruang</td>
                <td>:</td>
                <td>{{ $skp->pegawaiPenilai->jabatan->pangkat ?? '-' }} / {{ $skp->pegawaiPenilai->jabatan->golongan_ruang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Jabatan</td>
                <td>:</td>
                <td>{{ $skp->pegawaiPenilai->jabatan->nama_jabatan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Unit Kerja</td>
                <td>:</td>
                <td>RSUD dr. Soeselo Kab. Tegal</td>
            </tr>
        </table>
        
        <div style="clear: both;"></div>

        <table class="table-borderless" style="width: 50%; margin-top: 15px;">
            <tr>
                <td width="40%" class="fw-bold">Atasan Pejabat Penilai</td>
                <td width="5%">:</td>
                <td>{{ $skp->atasanPegawaiPenilai->nama }}</td>
            </tr>
            <tr>
                <td class="fw-bold">NIP</td>
                <td>:</td>
                <td>{{ $skp->atasanPegawaiPenilai->nip }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Pangkat / Gol. Ruang</td>
                <td>:</td>
                <td>{{ $skp->atasanPegawaiPenilai->jabatan->pangkat ?? '-' }} / {{ $skp->atasanPegawaiPenilai->jabatan->golongan_ruang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Jabatan</td>
                <td>:</td>
                <td>{{ $skp->atasanPegawaiPenilai->jabatan->nama_jabatan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Unit Kerja</td>
                <td>:</td>
                <td>RSUD dr. Soeselo Kab. Tegal</td>
            </tr>
        </table>
    </div>

    {{-- Tabel Tugas Jabatan --}}
    @if($kegiatanTugasJabatan->count())
        <h4>Kegiatan Tugas Jabatan</h4>
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kegiatan</th>
                    <th>AK</th>
                    <th>Target Output</th>
                    <th>Realisasi Output</th>
                    <th>Target Mutu</th>
                    <th>Realisasi Mutu</th>
                    <th>Target Waktu</th>
                    <th>Realisasi Waktu</th>
                    <th>Target Biaya</th>
                    <th>Realisasi Biaya</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kegiatanTugasJabatan as $index => $kegiatan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kegiatan->nama_kegiatan }}</td>
                        <td>{{ $kegiatan->ak ?? '-' }}</td>
                        <td>{{ $kegiatan->target_kuantitatif_output }}</td>
                        <td>{{ $kegiatan->realisasi_kuantitatif_output ?? '-' }}</td>
                        <td>{{ $kegiatan->target_kualitatif_mutu }}</td>
                        <td>{{ $kegiatan->realisasi_kualitatif_mutu ?? '-' }}</td>
                        <td>{{ $kegiatan->target_waktu_bulan }}</td>
                        <td>{{ $kegiatan->realisasi_waktu_bulan ?? '-' }}</td>
                        <td>{{ $kegiatan->target_biaya ?? '-' }}</td>
                        <td>{{ $kegiatan->realisasi_biaya ?? '-' }}</td>
                        <td>{{ $kegiatan->nilai_kegiatan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Tabel Tugas Tambahan --}}
    @if($kegiatanTugasTambahan->count())
        <h4>Kegiatan Tugas Tambahan</h4>
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kegiatan</th>
                    <th>AK</th>
                    <th>Target Output</th>
                    <th>Realisasi Output</th>
                    <th>Target Mutu</th>
                    <th>Realisasi Mutu</th>
                    <th>Target Waktu</th>
                    <th>Realisasi Waktu</th>
                    <th>Target Biaya</th>
                    <th>Realisasi Biaya</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kegiatanTugasTambahan as $index => $kegiatan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kegiatan->nama_kegiatan }}</td>
                        <td>{{ $kegiatan->ak ?? '-' }}</td>
                        <td>{{ $kegiatan->target_kuantitatif_output }}</td>
                        <td>{{ $kegiatan->realisasi_kuantitatif_output ?? '-' }}</td>
                        <td>{{ $kegiatan->target_kualitatif_mutu }}</td>
                        <td>{{ $kegiatan->realisasi_kualitatif_mutu ?? '-' }}</td>
                        <td>{{ $kegiatan->target_waktu_bulan }}</td>
                        <td>{{ $kegiatan->realisasi_waktu_bulan ?? '-' }}</td>
                        <td>{{ $kegiatan->target_biaya ?? '-' }}</td>
                        <td>{{ $kegiatan->realisasi_biaya ?? '-' }}</td>
                        <td>{{ $kegiatan->nilai_kegiatan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    
    <div style="clear: both;"></div>
    <h4>Rekapitulasi Penilaian</h4>
    <table class="bordered">
        <tbody>
            <tr>
                <td width="30%" class="fw-bold">Nilai Capaian SKP</td>
                <td class="text-end fw-bold">{{ number_format($skp->nilai_capaian_skp, 2) }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Nilai Perilaku</td>
                <td class="text-end fw-bold">{{ number_format($skp->nilai_perilaku, 2) }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Nilai Akhir</td>
                <td class="text-end fw-bold">{{ number_format($skp->nilai_akhir, 2) }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Kategori</td>
                <td class="text-end fw-bold">{{ $skp->kategori }}</td>
            </tr>
        </tbody>
    </table>
    
    @if($skp->catatanPenilaian->count() > 0)
    <h4>Catatan Penilaian</h4>
    <table class="bordered">
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th>Uraian</th>
                <th width="30%">Penilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($skp->catatanPenilaian as $catatan)
            <tr>
                <td class="text-center">{{ \Carbon\Carbon::parse($catatan->tanggal)->format('d F Y') }}</td>
                <td>{{ $catatan->uraian }}</td>
                <td>{{ $catatan->nama_pegawai_penilai }}<br>NIP: {{ $catatan->nip_pegawai_penilai }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

</body>
</html>