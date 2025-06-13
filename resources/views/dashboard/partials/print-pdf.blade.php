<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Pegawai - {{ $pegawai->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            padding: 0;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 5px 0;
        }
        .header p {
            margin: 5px 0;
        }
        .header img {
            height: 60px;
            width: auto;
        }
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .section h3 {
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table.biodata {
            margin-bottom: 15px;
        }
        table.biodata td {
            padding: 5px;
            vertical-align: top;
        }
        table.biodata td:first-child {
            width: 30%;
        }
        table.biodata td:nth-child(2) {
            width: 5%;
            text-align: center;
        }
        .photo {
            float: right;
            margin-left: 15px;
            border: 1px solid #ddd;
            padding: 3px;
            width: 120px;
            height: 160px;
            text-align: center;
        }
        .photo img {
            max-width: 100%;
            max-height: 100%;
        }
        .photo p {
            margin: 5px 0 0 0;
            font-size: 10px;
            font-style: italic;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.data-table th, 
        table.data-table td {
            border: 1px solid #ddd;
            padding: 6px;
            font-size: 11px;
        }
        table.data-table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
        .page-break {
            page-break-before: always;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>PEMERINTAH KABUPATEN TEGAL</h2>
        <h2>BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA</h2>
        <p><small>Jl. dr. Soetomo No. 1 Slawi, Tegal, Jawa Tengah 52461 Telp. (0283) 491116, Fax. (0283) 491289
            WEBSITE : bkd.tegalkab.go.id E-MAIL : bkdkabtegal@gmail.com</small></p>
    </div>

    @if(in_array('biodata', $sections))
    <div class="section clearfix">
        <h3>BIODATA PEGAWAI</h3>
        
        <div class="photo">
            @if($pegawai->foto)
                <img src="{{ public_path('storage/' . $pegawai->foto) }}" alt="Foto Pegawai">
            @else
                <p>Foto tidak tersedia</p>
            @endif
        </div>
        
        <table class="biodata">
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td>{{ $pegawai->nama }}</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td>{{ $pegawai->nip ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>:</td>
                <td>{{ $pegawai->tempat_lahir ?? '-' }}, {{ $pegawai->tanggal_lahir ? date('d F Y', strtotime($pegawai->tanggal_lahir)) : '-' }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $pegawai->jenis_kelamin ?? '-' }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $pegawai->agama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Status Pernikahan</td>
                <td>:</td>
                <td>{{ $pegawai->status_pernikahan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Golongan Darah</td>
                <td>:</td>
                <td>{{ $pegawai->golongan_darah ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $pegawai->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td>{{ $pegawai->email ?? '-' }}</td>
            </tr>
            <tr>
                <td>No. Telepon</td>
                <td>:</td>
                <td>{{ $pegawai->no_telepon ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jabatan Terakhir</td>
                <td>:</td>
                <td>{{ $pegawai->jabatan_terakhir ?? '-' }}</td>
            </tr>
            <tr>
                <td>Unit Kerja</td>
                <td>:</td>
                <td>{{ $pegawai->unit_kerja ?? '-' }}</td>
            </tr>
            <tr>
                <td>Status Kepegawaian</td>
                <td>:</td>
                <td>{{ $pegawai->status_kepegawaian ?? '-' }}</td>
            </tr>
        </table>
    </div>
    @endif

    @if(in_array('jabatan', $sections) && isset($jabatan) && $jabatan->count() > 0)
    <div class="section {{ !in_array('biodata', $sections) ? '' : 'page-break' }}">
        <h3>RIWAYAT JABATAN</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="25%">Jabatan</th>
                    <th width="25%">Unit Kerja</th>
                    <th width="15%">TMT</th>
                    <th width="15%">Sampai</th>
                    <th width="15%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jabatan as $index => $item)
                <tr>
                    <td align="center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_jabatan }}</td>
                    <td>{{ $item->unit_kerja }}</td>
                    <td align="center">{{ $item->tmt ? date('d-m-Y', strtotime($item->tmt)) : '-' }}</td>
                    <td align="center">{{ $item->tanggal_berakhir ? date('d-m-Y', strtotime($item->tanggal_berakhir)) : 'Sekarang' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(in_array('pendidikan', $sections) && isset($pendidikan) && $pendidikan->count() > 0)
    <div class="section {{ (!in_array('biodata', $sections) && !in_array('jabatan', $sections)) ? '' : 'page-break' }}">
        <h3>RIWAYAT PENDIDIKAN</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Tingkat</th>
                    <th width="25%">Nama Sekolah/Universitas</th>
                    <th width="20%">Jurusan/Program Studi</th>
                    <th width="10%">Tahun Masuk</th>
                    <th width="10%">Tahun Lulus</th>
                    <th width="15%">No. Ijazah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendidikan as $index => $item)
                <tr>
                    <td align="center">{{ $index + 1 }}</td>
                    <td>{{ $item->tingkat_pendidikan }}</td>
                    <td>{{ $item->nama_instansi }}</td>
                    <td>{{ $item->jurusan ?? '-' }}</td>
                    <td align="center">{{ $item->tahun_masuk ?? '-' }}</td>
                    <td align="center">{{ $item->tahun_lulus ?? '-' }}</td>
                    <td>{{ $item->no_ijazah ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(in_array('penghargaan', $sections) && isset($penghargaan) && $penghargaan->count() > 0)
    <div class="section">
        <h3>RIWAYAT PENGHARGAAN</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Nama Penghargaan</th>
                    <th width="20%">Pemberi</th>
                    <th width="15%">Tanggal</th>
                    <th width="30%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penghargaan as $index => $item)
                <tr>
                    <td align="center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_penghargaan }}</td>
                    <td>{{ $item->pemberi ?? '-' }}</td>
                    <td align="center">{{ $item->tanggal ? date('d-m-Y', strtotime($item->tanggal)) : '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(in_array('organisasi', $sections) && isset($organisasi) && $organisasi->count() > 0)
    <div class="section">
        <h3>RIWAYAT ORGANISASI</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Nama Organisasi</th>
                    <th width="20%">Jabatan</th>
                    <th width="15%">Tahun Mulai</th>
                    <th width="15%">Tahun Selesai</th>
                    <th width="15%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($organisasi as $index => $item)
                <tr>
                    <td align="center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_organisasi }}</td>
                    <td>{{ $item->jabatan ?? '-' }}</td>
                    <td align="center">{{ $item->tahun_mulai ?? '-' }}</td>
                    <td align="center">{{ $item->tahun_selesai ?? 'Sekarang' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(in_array('diklat_fungsional', $sections) && isset($diklat_fungsional) && $diklat_fungsional->count() > 0)
    <div class="section page-break">
        <h3>RIWAYAT DIKLAT FUNGSIONAL</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Nama Diklat</th>
                    <th width="25%">Penyelenggara</th>
                    <th width="10%">Tahun</th>
                    <th width="15%">No. Sertifikat</th>
                    <th width="15%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($diklat_fungsional as $index => $item)
                <tr>
                    <td align="center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_diklat }}</td>
                    <td>{{ $item->penyelenggara ?? '-' }}</td>
                    <td align="center">{{ $item->tahun ?? '-' }}</td>
                    <td>{{ $item->no_sertifikat ?? '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(in_array('diklat_jabatan', $sections) && isset($diklat_jabatan) && $diklat_jabatan->count() > 0)
    <div class="section">
        <h3>RIWAYAT DIKLAT JABATAN</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Nama Diklat</th>
                    <th width="25%">Penyelenggara</th>
                    <th width="10%">Tahun</th>
                    <th width="15%">No. Sertifikat</th>
                    <th width="15%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($diklat_jabatan as $index => $item)
                <tr>
                    <td align="center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_diklat }}</td>
                    <td>{{ $item->penyelenggara ?? '-' }}</td>
                    <td align="center">{{ $item->tahun ?? '-' }}</td>
                    <td>{{ $item->no_sertifikat ?? '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(in_array('diklat_teknis', $sections) && isset($diklat_teknis) && $diklat_teknis->count() > 0)
    <div class="section">
        <h3>RIWAYAT DIKLAT TEKNIS</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Nama Diklat</th>
                    <th width="25%">Penyelenggara</th>
                    <th width="10%">Tahun</th>
                    <th width="15%">No. Sertifikat</th>
                    <th width="15%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($diklat_teknis as $index => $item)
                <tr>
                    <td align="center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_diklat }}</td>
                    <td>{{ $item->penyelenggara ?? '-' }}</td>
                    <td align="center">{{ $item->tahun ?? '-' }}</td>
                    <td>{{ $item->no_sertifikat ?? '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(in_array('istri', $sections) && isset($istri) && $istri->count() > 0)
    <div class="section page-break">
        <h3>DATA SUAMI/ISTRI</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="25%">Nama</th>
                    <th width="20%">Tempat, Tgl Lahir</th>
                    <th width="15%">Tgl Nikah</th>
                    <th width="20%">Pendidikan</th>
                    <th width="15%">Pekerjaan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($istri as $index => $item)
                <tr>
                    <td align="center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->tempat_lahir ?? '-' }}, {{ $item->tanggal_lahir ? date('d-m-Y', strtotime($item->tanggal_lahir)) : '-' }}</td>
                    <td align="center">{{ $item->tanggal_nikah ? date('d-m-Y', strtotime($item->tanggal_nikah)) : '-' }}</td>
                    <td>{{ $item->pendidikan ?? '-' }}</td>
                    <td>{{ $item->pekerjaan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(in_array('anak', $sections) && isset($anak) && $anak->count() > 0)
    <div class="section">
        <h3>DATA ANAK</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="25%">Nama</th>
                    <th width="20%">Tempat, Tgl Lahir</th>
                    <th width="10%">Jenis Kelamin</th>
                    <th width="20%">Pendidikan</th>
                    <th width="20%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($anak as $index => $item)
                <tr>
                    <td align="center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->tempat_lahir ?? '-' }}, {{ $item->tanggal_lahir ? date('d-m-Y', strtotime($item->tanggal_lahir)) : '-' }}</td>
                    <td align="center">{{ $item->jenis_kelamin ?? '-' }}</td>
                    <td>{{ $item->pendidikan ?? '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        Dicetak pada: {{ date('d-m-Y H:i:s') }} | SIMPEG - Sistem Informasi Manajemen Kepegawaian
    </div>
</body>
</html>