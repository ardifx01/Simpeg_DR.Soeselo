{{-- resources/views/dashboard/nominatif/print.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nominatif Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 10px;
            line-height: 1.2;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .header h2 {
            margin: 5px 0;
            font-size: 14px;
            font-weight: bold;
        }
        
        .header hr {
            border: 1px solid #000;
            margin: 10px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table th,
        table td {
            border: 1px solid #000;
            padding: 3px 4px;
            text-align: left;
            vertical-align: top;
            font-size: 9px;
        }
        
        table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }
        
        .signature {
            margin-top: 30px;
            width: 100%;
        }
        
        .signature table {
            border: none;
            width: 100%;
        }
        
        .signature td {
            border: none;
            padding: 5px;
            vertical-align: top;
        }
        
        .signature-box {
            text-align: center;
            width: 250px;
        }
        
        .signature-box p {
            margin: 5px 0;
            line-height: 1.4;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 8px;
            color: #666;
        }
        
        @page {
            size: A4 landscape;
            margin: 1cm;
        }
        
        .many-columns {
            font-size: 8px;
        }
        
        .many-columns th,
        .many-columns td {
            padding: 2px 3px;
            font-size: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>DAFTAR NOMINATIF PEGAWAI NEGERI SIPIL</h2>
        <h2>PADA RSUD dr. Soeselo Slawi</h2>
        <hr>
    </div>
    
    @if(isset($pegawais) && count($pegawais) > 0)
        <table class="{{ count($displayColumns) > 10 ? 'many-columns' : '' }}">
            <thead>
                <tr style="text-align: center;">
                    @foreach ($displayColumns as $col)
                        <th>{{ $col }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawais as $index => $pegawai)
                <tr>
                    @foreach ($displayColumns as $key => $col)
                        <td>
                            @switch($key)
                                @case('no')
                                    {{ $index + 1 }}
                                    @break
                                @case('nip')
                                    {{ $pegawai->nip }}
                                    @break
                                @case('nama')
                                    {{ $pegawai->nama }}
                                    @break
                                @case('tempat_lahir')
                                    {{ $pegawai->tempat_lahir }}
                                    @break
                                @case('tanggal_lahir')
                                    {{ $pegawai->tanggal_lahir ? date('d/m/Y', strtotime($pegawai->tanggal_lahir)) : '-' }}
                                    @break
                                @case('agama')
                                    {{ $pegawai->agama }}
                                    @break
                                @case('jenis_kelamin')
                                    {{ $pegawai->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                    @break
                                @case('alamat')
                                    {{ Str::limit($pegawai->alamat, 30) }}
                                    @break
                                @case('telepon')
                                    {{ $pegawai->telepon }}
                                    @break
                                @case('no_npwp')
                                    {{ $pegawai->no_npwp }}
                                    @break
                                @case('no_ktp')
                                    {{ $pegawai->no_ktp }}
                                    @break
                                @case('jenis_kepegawaian')
                                    {{ optional($pegawai->jabatan)->jenis_kepegawaian }}
                                    @break
                                @case('tmt_golongan_cpns')
                                    {{ $pegawai->tmt_golongan_cpns ? date('d/m/Y', strtotime($pegawai->tmt_golongan_cpns)) : '-' }}
                                    @break
                                @case('tmt_pns')
                                    {{ $pegawai->tmt_pns ? date('d/m/Y', strtotime($pegawai->tmt_pns)) : '-' }}
                                    @break
                                @case('golongan_ruang')
                                    {{ $pegawai->golongan_ruang }}
                                    @break
                                @case('pangkat')
                                    {{ optional($pegawai->jabatan)->nama }}
                                    @break
                                @case('tingkat_pendidikan')
                                    {{ optional($pegawai->pendidikans->sortByDesc('tahun_lulus')->first())->tingkat ?? '-' }}
                                    @break
                                @case('jurusan')
                                    {{ Str::limit(optional($pegawai->pendidikans->sortByDesc('tahun_lulus')->first())->jurusan ?? '-', 20) }}
                                    @break
                                @case('nama_sekolah')
                                    {{ Str::limit(optional($pegawai->pendidikans->sortByDesc('tahun_lulus')->first())->nama_sekolah ?? '-', 25) }}
                                    @break
                                @case('tahun_lulus')
                                    {{ optional($pegawai->pendidikans->sortByDesc('tahun_lulus')->first())->tahun_lulus ?? '-' }}
                                    @break
                                @case('unit_kerja')
                                    {{ Str::limit(optional($pegawai->jabatan)->skpd, 25) }}
                                    @break
                                @case('sub_unit')
                                    {{ Str::limit(optional($pegawai->jabatan)->unit_kerja, 25) }}
                                    @break
                                @case('jenis_jabatan')
                                    {{ optional($pegawai->jabatan)->jenis_jabatan }}
                                    @break
                                @case('jabatan')
                                    {{ Str::limit(optional($pegawai->jabatan)->unit_kerja, 25) }}
                                    @break
                                @case('tmt_jabatan')
                                    {{ optional($pegawai->jabatan)->tmt ? date('d/m/Y', strtotime(optional($pegawai->jabatan)->tmt)) : '-' }}
                                    @break
                                @default
                                    {{ $pegawai[$key] ?? '-' }}
                            @endswitch
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="signature">
            <table>
                <tr>
                    <td style="width: 60%;"></td>
                    <td>
                        <div class="signature-box">
                            <p>Slawi, {{ date('d F Y') }}</p>
                            <p><strong>Kepala RSUD dr. Soeselo Slawi</strong></p>
                            <br><br><br>
                            <p><strong><u>dr. Nama Kepala</u></strong></p>
                            <p>NIP. 19xx xxxx xxxx xxxx xxx</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="footer">
            Total: {{ count($pegawais) }} pegawai | Dicetak pada: {{ date('d/m/Y H:i:s') }}
        </div>
    @else
        <p style="text-align: center; margin-top: 50px;">Tidak ada data pegawai untuk dicetak.</p>
    @endif
    
    <script>
        // Auto print saat halaman dimuat
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>