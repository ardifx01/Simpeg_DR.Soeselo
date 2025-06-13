<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profil Pegawai {{ $pegawai->nama }}</title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }
        body {
            font-family: Arial, sans-serif;
            color: #333;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            overflow-wrap: break-word;
            word-wrap: break-word;
        }
        .header-table,
        .biodata-table,
        .bordered {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table {
            margin-bottom: 10px;
        }
        .logo-cell {
            width: 80px;
            vertical-align: top;
            padding-right: 15px;
        }
        .logo {
            width: 80px;
            height: auto;
        }
        .content-cell {
            vertical-align: top;
            text-align: center;
        }
        .content-cell h3 {
            margin: 5px 0;
            font-size: 16px;
            color: #333;
        }
        .address {
            margin: 2px 0;
            line-height: 1.4;
            font-size: 11px;
            color: #555;
        }
        .section-title {
            text-align: center;
            font-weight: bold;
            margin: 20px 0 15px 0;
            font-size: 14px;
        }
        .biodata-details-cell {
            width: 70%;
            vertical-align: top;
            padding-right: 15px;
        }
        .photo-cell {
            width: 20%;
            vertical-align: top;
        }
        .photo-placeholder {
            width: 3cm;
            height: 4cm;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            margin: 0 auto;
            overflow: hidden;
        }
        .photo-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
        }
        .biodata-list, .table-list {
            font-weight: bold;
            margin: 15px 0 8px 0;
            font-size: 13px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
        }
        .data-row {
            margin-bottom: 6px;
            line-height: 1.3;
        }
        .data-label {
            width: 180px;
            display: inline-block;
            vertical-align: top;
        }
        .data-value {
            display: inline-block;
            width: calc(100% - 185px);
            vertical-align: top;
        }
        table.bordered {
            margin-bottom: 20px;
            font-size: 11px;
        }
        table.bordered th,
        table.bordered td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        table.bordered th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
        }
        table.bordered tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table {
            page-break-inside: auto;
        }
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        .divider-double-gap {
            margin: 15px 0;
            overflow: visible;
        }
        .divider-double-gap:before,
        .divider-double-gap:after {
            content: "";
            display: block;
            height: 1px;
            background-color: #000;
        }
        .divider-double-gap:before {
            margin-bottom: 3px;
        }
        @media print {
            body {
                padding: 0;
                margin: 0;
                width: 100%;
            }
            .header-table {
                margin-top: 0;
            }
            .photo-placeholder {
                border: none;
            }
        }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/kabTegal.png'))) }}" alt="Logo Kabupaten Tegal" class="logo">
            </td>
            <td class="content-cell">
                <h3 class="header">PEMERINTAH KABUPATEN TEGAL</h3>
                <h3 class="header">BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA</h3>
                <p class="address">WEBSITE : bkd.tegalkab.go.id E-MAIL : bkdkabtegal@gmail.com</p>
                <p class="address">Jl. dr. Soetomo No. 1 Slawi, Tegal, Jawa Tengah 52461 Telp. (0283) 491116, Fax. (0283) 491289</p>
            </td>
        </tr>
    </table>

    <hr class="divider-double-gap"></hr>
    
    <div class="content-column">
        <h6 class="section-title">BIODATA PEGAWAI</h6>
    </div>

    <table class="biodata-table">
        <tr>
            <td class="biodata-details-cell">
                <h5 class="biodata-list">LOKASI KERJA</h5>
                <div class="data-row">
                    <div class="data-label">UNIT KERJA</div>
                    <div class="data-value">: {{ ($pegawai->jabatan)->skpd ?? ' '  }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">SUB UNIT KERJA</div>
                    <div class="data-value">: {{ $pegawai->jabatan->unit_kerja ?? ' '  }}</div>
                </div>
                
                <h5 class="biodata-list">IDENTITAS PEGAWAI</h5>
                <div class="data-row">
                    <div class="data-label">NIP</div>
                    <div class="data-value">: {{ $pegawai->nip ?? ' '  }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">NAMA</div>
                    <div class="data-value">: {{ $pegawai->gelar_depan ?? ' '  }}{{ $pegawai->nama ?? ' '  }}{{ $pegawai->gelar_belakang ?? ' '  }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">TEMPAT LAHIR</div>
                    <div class="data-value">: {{ $pegawai->tempat_lahir ?? ' '  }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">TANGGAL LAHIR</div>
                    <div class="data-value">: {{ \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d-m-Y') }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">JENIS KELAMIN</div>
                    <div class="data-value">: {{ $pegawai->jenis_kelamin ?? ' '  }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">AGAMA</div>
                    <div class="data-value">: {{ $pegawai->agama ?? ' '  }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">STATUS PEGAWAI</div>
                    <div class="data-value">: {{ $pegawai->jabatan->jenis_kepegawaian ?? ' ' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">STATUS PERKAWINAN</div>
                    <div class="data-value">: {{ $pegawai->status_nikah ?? ' ' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">KEDUDUKAN PEGAWAI</div>
                    <div class="data-value">: {{ $pegawai->jabatan->status ?? ' ' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">JABATAN PEGAWAI</div>
                    <div class="data-value">: {{ $pegawai->jabatan->nama ?? ' ' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">UNIT KERJA</div>
                    <div class="data-value">: {{ $pegawai->jabatan->unit_kerja ?? ' ' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">ALAMAT</div>
                    <div class="data-value">: 
                        {{ collect([
                            $pegawai->alamat,
                            $pegawai->rt ? 'RT ' . $pegawai->rt : null,
                            $pegawai->rw ? 'RW ' . $pegawai->rw : null,
                            $pegawai->desa ? 'Desa ' . $pegawai->desa : null,
                            $pegawai->kecamatan ? 'Kec. ' . $pegawai->kecamatan : null,
                            $pegawai->kabupaten ? 'Kab. ' . $pegawai->kabupaten : null,
                            $pegawai->provinsi ? 'Prov. ' . $pegawai->provinsi : null,
                            $pegawai->pos ? 'Kode Pos ' . $pegawai->pos : null
                        ])->filter()->implode(', ') ?: '-' }}
                    </div>
                </div>
                <div class="data-row">
                    <div class="data-label">TELEPON</div>
                    <div class="data-value">: {{ $pegawai->telepon ?? ' '  }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">NO. KARPEG</div>
                    <div class="data-value">: {{ $pegawai->no_karpeg ?? ' '  }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">NO. NPWP</div>
                    <div class="data-value">: {{ $pegawai->no_npwp ?? ' '  }}</div>
                </div>
                <h5 class="biodata-list">PENGANGKATAN SEBAGAI CPNS</h5>
                <div class="data-row">
                    <div class="data-label">NO SK CPNS</div>
                    <div class="data-value">: {{ $pegawai->arsip->jenis ?? ' ' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">PANGKAT CPNS</div>
                    <div class="data-value">: {{ $pegawai->golongan_ruang_cpns ?? ' ' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">TMT CPNS</div>
                    <div class="data-value">: {{ \Carbon\Carbon::parse($pegawai->tmt_golongan_ruang_cpns ?? ' ')->format('d-m-Y') }}</div>
                </div>
                <h5 class="biodata-list">PENGANGKATAN SEBAGAI PNS</h5>
                <div class="data-row">
                    <div class="data-label">NO SK PNS</div>
                    <div class="data-value">: {{ $pegawai->arsip->jenis ?? ' ' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">PANGKAT CPNS</div>
                    <div class="data-value">: {{ $pegawai->golongan_ruang_ ?? ' ' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">TMT PNS</div>
                    <div class="data-value">: {{ \Carbon\Carbon::parse($pegawai->tmt_golongan_ruang ?? ' ')->format('d-m-Y') }}</div>
                </div>
                @foreach($pegawai->pendidikans as $pendidikan)
                <h5 class="biodata-list">PENDIDIKAN UMUM TERAKHIR</h5>
                <div class="data-row">
                    <div class="data-label">NO IJAZAH</div>
                    <div class="data-value">: {{ $pendidikan->no_ijazah ?? ' ' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">TAHUN IJAZAH</div>
                    <div class="data-value">: {{ \Carbon\Carbon::parse($pendidikan->tanggal_ijazah ?? ' ')->format('d-m-Y') }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">TINGKAT PENDIDIKAN</div>
                    <div class="data-value">: {{ $pendidikan->tingkat ?? ' ' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">JURUSAN PENDIDIKAN</div>
                    <div class="data-value">: {{ $pendidikan->jurusan ?? ' ' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">NAMA SEKOLAH</div>
                    <div class="data-value">: {{ $pendidikan->nama ?? ' ' }}</div>
                </div>
                @endforeach
            </td>
        
            <td class="photo-cell">
                <div class="photo-placeholder">
                    @if($pegawai->image && file_exists(public_path('storage/foto-profile/' . $pegawai->image)))
                        <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('storage/foto-profile/' . $pegawai->image))) }}" alt="Foto Pegawai">
                    @elseif(file_exists(public_path('assets/img/nophoto.jpg')))
                        <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('assets/img/nophoto.jpg'))) }}" alt="Foto Pegawai">
                    @else
                        <div class="no-photo-placeholder">Foto tidak tersedia</div>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <div class="content-column">
        <h6 class="section-title">DAFTAR RIWAYAT</h6>
    </div>

    @if(in_array('jabatan', $sections))
        <h5 class="table-list">RIWAYAT JABATAN</h5>
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Jabatan</th>
                    <th style="width: 15%;">Jenis Jabatan</th>
                    <th style="width: 15%;">Jenis Kepegawaian</th>
                    <th style="width: 10%;">TMT<br>JABATAN</th>
                    <th style="width: 10%;">Eselon</th>
                    <th style="width: 20%;">Unit Kerja</th>
                </tr>
            </thead>
            <tbody>
            @if ($pegawai->jabatan)
                <tr>
                    <td style="text-align:center;">1</td>
                    <td>{{ $pegawai->jabatan->nama }}</td>
                    <td>{{ $pegawai->jabatan->jenis_jabatan }}</td>
                    <td>{{ $pegawai->jabatan->jenis_kepegawaian }}</td>
                    <td>{{ $pegawai->jabatan->tmt ? \Carbon\Carbon::parse($pegawai->jabatan->tmt)->format('d-m-Y') : '-' }}</td>
                    <td>{{ $pegawai->jabatan->eselon }}</td>
                    <td>{{ $pegawai->jabatan->unit_kerja }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="7" style="text-align:center;"><em>Riwayat Jabatan belum tersedia.</em></td>
                </tr>
            @endif
            </tbody>
        </table>
    @endif

    @if(in_array('pendidikan', $sections))
        <h5 class="table-list">RIWAYAT PENDIDIKAN</h5>
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">TINGKAT<br>PENDIDIKAN</th>
                    <th style="width: 20%;">JURUSAN</th>
                    <th style="width: 25%;">NAMA SEKOLAH</th>
                    <th style="width: 10%;">TAHUN LULUS</th>
                    <th style="width: 15%;">NO. IJAZAH</th>
                    <th style="width: 10%;">TGL.<br>IJAZAH</th>
                </tr>
            </thead>
            <tbody>
            @forelse($pegawai->pendidikans as $item => $pendidikan)
                <tr>
                    <td style="text-align:center;">{{ $item + 1 }}</td>
                    <td>{{ $pendidikan->tingkat }}</td>
                    <td>{{ $pendidikan->jurusan }}</td>
                    <td>{{ $pendidikan->nama }}</td>
                    <td>{{ $pendidikan->tahun_lulus }}</td>
                    <td>{{ $pendidikan->no_ijazah }}</td>
                    <td>{{ $pendidikan->tanggal_ijazah }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;"><em>Riwayat Pendidikan belum tersedia.</em></td>
                </tr>
            @endforelse
            </tbody>
        </table>
    @endif

    @if(in_array('penghargaan', $sections))
        <h5 class="table-list">RIWAYAT PENGHARGAAN</h5>
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 40%;">NAMA PENGHARGAAN</th>
                    <th style="width: 35%;">PEMBERI PENGHARGAAN</th>
                    <th style="width: 20%;">TAHUN PENYERAHAN</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($pegawai->penghargaans as $item => $penghargaan)
                <tr>
                    <td style="text-align:center;">{{ $item+1 }}</td>
                    <td>{{ $penghargaan->nama }}</td>
                    <td>{{ $penghargaan->pemberi }}</td>
                    <td>{{ \Carbon\Carbon::parse($penghargaan->tahun)->format('d-m-Y') }}</td>
                </tr>                
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;"><em>Riwayat Penghargaan belum tersedia.</em></td>
                </tr>
            @endforelse
            </tbody>
        </table>
    @endif

    @if(in_array('organisasi', $sections))
        <h5 class="table-list">RIWAYAT ORGANISASI</h5>
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">JENIS ORGANISASI</th>
                    <th style="width: 30%;">NAMA ORGANISASI</th>
                    <th style="width: 20%;">JABATAN</th>
                    <th style="width: 25%;">TMT ORGANISASI</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($pegawai->organisasis as $item => $organisasi)
                <tr>
                    <td style="text-align:center;">{{ $item+1 }}</td>
                    <td>{{ $organisasi->jenis }}</td>
                    <td>{{ $organisasi->nama }}</td>
                    <td>{{ $organisasi->jabatan }}</td>
                    <td>{{ \Carbon\Carbon::parse($organisasi->tmt)->format('d-m-Y') }}</td>
                </tr>                
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;"><em>Riwayat Organisasi belum tersedia.</em></td>
                </tr>
            @endforelse
            </tbody>
        </table>
    @endif

    @if(in_array('diklat_fungsional', $sections))
        <h5 class="table-list">RIWAYAT DIKLAT FUNGSIONAL</h5>
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 35%;">NAMA DIKLAT</th>
                    <th style="width: 30%;">PENYELENGGARA</th>
                    <th style="width: 15%;">JUMLAH<br>JAM</th>
                    <th style="width: 15%;">TANGGAL SELESAI</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($pegawai->diklat_fungsionals as $item => $diklat_fungsional)
                <tr>
                    <td style="text-align:center;">{{ $item+1 }}</td>
                    <td>{{ $diklat_fungsional->nama }}</td>
                    <td>{{ $diklat_fungsional->penyelenggara }}</td>
                    <td style="text-align:center;">{{ $diklat_fungsional->jumlah_jam }}</td>
                    <td>{{ \Carbon\Carbon::parse($diklat_fungsional->tanggal_selesai)->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;"><em>Riwayat Diklat Fungsional belum tersedia.</em></td>
                </tr>
            @endforelse
            </tbody>
        </table>
    @endif

    @if(in_array('diklat_jabatan', $sections))
        <h5 class="table-list">RIWAYAT DIKLAT JABATAN</h5>
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 35%;">NAMA DIKLAT</th>
                    <th style="width: 30%;">PENYELENGGARA</th>
                    <th style="width: 15%;">JUMLAH<br>JAM</th>
                    <th style="width: 15%;">TANGGAL SELESAI</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($pegawai->diklat_jabatans as $item => $diklat_jabatan)
                <tr>
                    <td style="text-align:center;">{{ $item+1 }}</td>
                    <td>{{ $diklat_jabatan->nama }}</td>
                    <td>{{ $diklat_jabatan->penyelenggara }}</td>
                    <td style="text-align:center;">{{ $diklat_jabatan->jumlah_jam }}</td>
                    <td>{{ \Carbon\Carbon::parse($diklat_jabatan->tanggal_selesai)->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;"><em>Riwayat Diklat Jabatan belum tersedia.</em></td>
                </tr>
            @endforelse
            </tbody>
        </table>
    @endif

    @if(in_array('diklat_teknis', $sections))
        <h5 class="table-list">RIWAYAT DIKLAT TEKNIS</h5>
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 35%;">NAMA DIKLAT</th>
                    <th style="width: 30%;">PENYELENGGARA</th>
                    <th style="width: 15%;">JUMLAH<br>JAM</th>
                    <th style="width: 15%;">TANGGAL SELESAI</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($pegawai->diklat_tekniks as $item => $diklat_teknik)
                <tr>
                    <td style="text-align:center;">{{ $item+1 }}</td>
                    <td>{{ $diklat_teknik->nama }}</td>
                    <td>{{ $diklat_teknik->penyelenggara }}</td>
                    <td style="text-align:center;">{{ $diklat_teknik->jumlah_jam }}</td>
                    <td>{{ \Carbon\Carbon::parse($diklat_teknik->tanggal_selesai)->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;"><em>Riwayat Diklat Teknis belum tersedia.</em></td>
                </tr>
            @endforelse
            </tbody>
        </table>
    @endif

    @if(in_array('istri', $sections))
        <h5 class="table-list">RIWAYAT {{ strtoupper(optional($pegawai->istri?->first())->status_hubungan ?? 'SUAMI/ISTRI') }}</h5>
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">NAMA {{ strtoupper(optional($pegawai->istri?->first())->status_hubungan ?? 'SUAMI/ISTRI') }}</th>
                    <th style="width: 20%;">TEMPAT LAHIR<br> TANGGAL LAHIE</th>
                    <th style="width: 15%;">PROFESI</th>
                    <th style="width: 15%;">TANGGAL NIKAH</th>
                    <th style="width: 20%;">STATUS HUBUNGAN</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($pegawai->istris as $item => $istri)
                <tr>
                    <td style="text-align:center;">{{ $item+1 }}</td>
                    <td>{{ $istri->nama }}</td>
                    <td>{{ $istri->tempat_lahir }}<br>{{ \Carbon\Carbon::parse($istri->tanggal_lahir)->format('d-m-Y') }}</td>
                    <td>{{ $istri->profesi }}</td>
                    <td>{{ \Carbon\Carbon::parse($istri->tanggal_nikah)->format('d-m-Y') }}</td>
                    <td>{{ $istri->status_hubungan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;"><em>Riwayat Suami/Istri belum tersedia.</em></td>
                </tr>
            @endforelse
            </tbody>
        </table>
    @endif

    @if(in_array('anak', $sections))
        <h5 class="table-list">RIWAYAT ANAK</h5>
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">NAMA ANAK</th>
                    <th style="width: 20%;">TEMPAT LAHIR<br> TANGGAL LAHIE</th>
                    <th style="width: 20%;">STATUS KELUARGA</th>
                    <th style="width: 15%;">STATUS TUNJANGAN</th>
                    <th style="width: 15%;">JENIS<br>KELAMIN</th>
                </tr>
            </thead>
            <tbody>
            @forelse($pegawai->anaks as $item => $anak)
                <tr>
                    <td style="text-align:center;">{{ $item+1 }}</td>
                    <td>{{ $anak->nama }}</td>
                    <td>{{ $anak->tempat_lahir }}<br>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d-m-Y') }}</td>
                    <td>{{ $anak->status_hubungan }}</td>
                    <td>{{ $anak->status_tunjangan }}</td>
                    <td>{{ $anak->jenis_kelamin }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;"><em>Riwayat Anak belum tersedia.</em></td>
                </tr>
            @endforelse
            </tbody>
        </table>
    @endif
</body>
</html>