<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nominatif Pegawai</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 24px 32px;
            font-size: 10px;
            background: #fff;
        }
        .print-btn-container {
            position: fixed;
            top: 24px;
            right: 32px;
            z-index: 100;
        }
        .print-btn {
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 24px;
            padding: 8px 18px;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(40,167,69,0.12);
            cursor: pointer;
            transition: background 0.18s, box-shadow 0.18s;
            outline: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .print-btn:hover, .print-btn:focus {
            background: #218838;
            box-shadow: 0 4px 16px rgba(40,167,69,0.18);
        }
        .print-btn:active {
            background: #1e7e34;
        }
        .print-btn svg {
            width: 18px;
            height: 18px;
            vertical-align: middle;
            fill: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 18px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0 0 4px 0;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 14px;
            margin: 0 0 4px 0;
            font-weight: normal;
        }
        .header hr {
            border: none;
            border-bottom: 2px solid #222;
            margin: 12px auto 6px auto;
            width: 90%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        th, td {
            border: 1px solid #222;
            padding: 5px 6px;
            font-size: 9px;
            vertical-align: top;
        }
        th {
            background: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }
        tr:nth-child(even) td {
            background: #fcfcfc;
        }
        .many-columns th, .many-columns td {
            padding: 3px 4px;
            font-size: 8px;
        }
        .signature {
            margin-top: 40px;
        }
        .signature-table {
            width: 100%;
            border: none;
        }
        .signature-table td {
            border: none;
            padding: 8px 0;
        }
        .signature-box {
            text-align: center;
            width: 270px;
            display: inline-block;
        }
        .signature-box p {
            margin: 6px 0;
            line-height: 1.4;
        }
        .footer {
            text-align: center;
            margin-top: 24px;
            font-size: 9px;
            color: #666;
        }
        @page {
            size: A4 landscape;
            margin: 1cm;
        }
        .meta {
            font-size: 10px;
            text-align: right;
            margin-bottom: 12px;
            color: #555;
        }
        @media print {
            .print-btn-container {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="print-btn-container no-print">
        <button class="print-btn" onclick="window.print()" title="Cetak halaman">
            <svg viewBox="0 0 24 24"><path d="M17,8V3H7V8H17M19,8V3A2,2 0 0,0 17,1H7A2,2 0 0,0 5,3V8A2,2 0 0,0 7,10H17A2,2 0 0,0 19,8M19,10H5A2,2 0 0,0 3,12V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12A2,2 0 0,0 19,10M8,17V15H16V17H8Z"/></svg>
            Print
        </button>
    </div>
    <div class="header">
        <h1>DAFTAR NOMINATIF PEGAWAI NEGERI SIPIL</h1>
        <h2>PADA RSUD dr. Soeselo Slawi</h2>
        <hr>
    </div>
    <div class="meta">
        Dicetak pada: {{ date('d/m/Y H:i:s') }}
    </div>
    @if(isset($pegawais) && count($pegawais) > 0)
        <table class="{{ count($displayColumns) > 10 ? 'many-columns' : '' }}">
            <thead>
                <tr>
                    @foreach ($displayColumns as $col)
                        <th>{{ $col }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse ($pegawais as $index => $pegawai)
                <tr>
                    @foreach ($displayColumns as $key => $col)
                        <td>
                            @switch($key)
                            @case('no')
                                {{ $index + 1 }}
                                @break
                            @case('nip')
                                {{ $pegawai ->nip ?? '-' }}
                                @break
                            @case('nama')
                                {{ $pegawai->nama ?? '-' }}
                                @break
                            @case('tempat_lahir')
                                {{ $pegawai->tempat_lahir ?? '-' }}
                                @break
                            @case('tanggal_lahir')
                                {{ $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                @break
                            @case('agama')
                                {{ $pegawai->agama ?? '-' }}
                                @break
                            @case('jenis_kelamin')
                                {{ $pegawai->jenis_kelamin ?? '-' }}
                                @break
                            @case('alamat')
                                {{
                                    collect([
                                        $pegawai->alamat,
                                        $pegawai->rt ? 'RT ' . $pegawai->rt : null,
                                        $pegawai->rw ? 'RW ' . $pegawai->rw : null,
                                        $pegawai->desa ? 'Desa ' . $pegawai->desa : null,
                                        $pegawai->kecamatan ? 'Kec. ' . $pegawai->kecamatan : null,
                                        $pegawai->kabupaten ? 'Kab. ' . $pegawai->kabupaten : null,
                                        $pegawai->provinsi ? 'Prov. ' . $pegawai->provinsi : null,
                                        $pegawai->pos ? 'Kode Pos ' . $pegawai->pos : null
                                    ])->filter()->implode(', ') ?: '-'
                                }}
                                @break
                            @case('telepon')
                                {{ $pegawai->telepon ?? '-' }}
                                @break
                            @case('no_npwp')
                                {{ $pegawai->no_npwp ?? '-' }}
                                @break
                            @case('no_ktp')
                                {{ $pegawai->no_ktp ?? '-' }}
                                @break
                            @case('status')
                                {{ optional($pegawai->jabatan)->status ?? '-' }}
                                @break
                            @case('jenis_kepegawaian')
                                {{ optional($pegawai->jabatan)->jenis_kepegawaian ?? '-' }}
                                @break
                            @case('tmt_golongan_ruang_cpns')
                                {{ $pegawai->tmt_golongan_ruang_cpns ? \Carbon\Carbon::parse($pegawai->tmt_golongan_ruang_cpns)->translatedFormat('d F Y') : '-' }}
                                @break
                            @case('tmt_pns')
                                {{ $pegawai->tmt_pns ? \Carbon\Carbon::parse($pegawai->tmt_pns)->translatedFormat('d F Y') : '-' }}
                                @break
                            @case('pangkat')
                                {{ optional($pegawai->jabatan)->pangkat ?? '-' }}
                                @break
                            @case('golongan_ruang')
                                {{ optional($pegawai->jabatan)->golongan_ruang ?? '-' }}
                                @break
                            @case('tingkat')
                                {{ optional($pegawai->pendidikans->sortByDesc('tahun_lulus')->first())->tingkat ?? '-' }}
                                @break
                            @case('jurusan')
                                {{ optional($pegawai->pendidikans->sortByDesc('tahun_lulus')->first())->jurusan ?? '-' }}
                                @break
                            @case('nama_sekolah')
                                {{ optional($pegawai->pendidikans->sortByDesc('tahun_lulus')->first())->nama_sekolah ?? '-' }}
                                @break
                            @case('tahun_lulus')
                                {{ optional($pegawai->pendidikans->sortByDesc('tahun_lulus')->first())->tahun_lulus ?? '-' }}
                                @break
                            @case('unit_kerja')
                                {{ optional($pegawai->jabatan)->skpd ?? '-' }}
                                @break
                            @case('nama_jabatan')
                                {{ optional($pegawai->jabatan)->nama_jabatan ?? '-' }}
                                @break
                            @case('jenis_jabatan')
                                {{ optional($pegawai->jabatan)->jenis_jabatan ?? '-' }}
                                @break
                            @case('tmt_golongan_ruang')
                                {{ optional($pegawai->jabatan)->tmt_golongan_ruang ? \Carbon\Carbon::parse(optional($pegawai->jabatan)->tmt_golongan_ruang)->translatedFormat('d F Y') : '-' }}
                                @break
                            @case('eselon')
                                {{ optional($pegawai->jabatan)->eselon ?? '-' }}
                                @break
                            @default
                                {{ $pegawai[$key] ?? '-' }}
                        @endswitch
                        </td>
                    @endforeach
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($displayColumns) }}" class="text-center">Tidak ada data pegawai ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="signature">
            <table class="signature-table">
                <tr>
                    <td></td>
                    <td style="width:300px;">
                        <div class="signature-box">
                            <p>Slawi, {{ date('d F Y') }}</p>
                            <p><strong>Kepala RSUD dr. Soeselo Slawi</strong></p>
                            <br><br><br>
                            <p><strong><u>(Nama Kepala)</u></strong></p>
                            <p>NIP. </p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="footer">
            Total: <strong>{{ count($pegawais) }}</strong> pegawai
        </div>
    @else
        <p style="text-align: center; margin-top: 50px;">Tidak ada data pegawai untuk dicetak.</p>
    @endif
</body>
</html>