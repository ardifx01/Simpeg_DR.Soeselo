<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header { 
            text-align: center; 
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }
        th, td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .rotate-text {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            white-space: nowrap;
        }
        .error-message {
            text-align: center;
            font-size: 16px;
            color: #dc3545;
            margin-top: 50px;
            font-weight: bold;
        }
        /* Khusus untuk tabel diklat */
        .diklat-table {
            font-size: 7pt;
        }
        .diklat-table th,
        .diklat-table td {
            padding: 1px;
            font-size: 7pt;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $title }}</h2>
        <p>RSUD DR. SOESELO SLAWI - Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
        @if(isset($unitKerja) && $unitKerja !== 'RSUD dr. Soeselo Slawi')
            <p><strong>Unit Kerja: {{ $unitKerja }}</strong></p>
        @endif
    </div>

    @if($kategori === 'unitkerja_pendidikan')
        <table>
            <thead>
                <tr>
                    <th>{{ $judulKolomPertama }}</th>
                    <th>JML GOL.</th>
                    <th>JML GOL. KOSONG</th>
                    <th>SD</th>
                    <th>SMP</th>
                    <th>SMA</th>
                    <th>D3</th>
                    <th>D4</th>
                    <th>S1</th>
                    <th>S2</th>
                    <th>S3</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataStatistik as $label => $item)
                <tr>
                    <td>{{ $label }}</td>
                    <td>{{ $item['total'] ?? 0 }}</td>
                    <td>{{ $item['kosong'] ?? 0 }}</td>
                    <td>{{ $item['SD'] ?? 0 }}</td>
                    <td>{{ $item['SMP'] ?? 0 }}</td>
                    <td>{{ $item['SMA'] ?? 0 }}</td>
                    <td>{{ $item['D3'] ?? 0 }}</td>
                    <td>{{ $item['D4'] ?? 0 }}</td>
                    <td>{{ $item['S1'] ?? 0 }}</td>
                    <td>{{ $item['S2'] ?? 0 }}</td>
                    <td>{{ $item['S3'] ?? 0 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    
    @elseif($kategori === 'diklat')
        <table class="diklat-table">
            <thead>
                <tr>
                    <th rowspan="3">{{ $judulKolomPertama }}</th>
                    <th colspan="11">ESELON</th>
                    <th rowspan="3">JML GOL.</th>
                    <th rowspan="3">JML GOL. KOSONG</th>
                    <th colspan="18">JUMLAH PER GOLONGAN</th>
                </tr>
                <tr>
                    <th rowspan="2">I/a</th>
                    <th rowspan="2">I/b</th>
                    <th rowspan="2">II/a</th>
                    <th rowspan="2">II/b</th>
                    <th rowspan="2">III/a</th>
                    <th rowspan="2">III/b</th>
                    <th rowspan="2">IV/a</th>
                    <th rowspan="2">IV/b</th>
                    <th rowspan="2">V/a</th>
                    <th rowspan="2">V/b</th>
                    <th rowspan="2">-</th>
                    <th colspan="4">GOL I</th>
                    <th colspan="4">GOL II</th>
                    <th colspan="4">GOL III</th>
                    <th colspan="5">GOL IV</th>  
                    <th rowspan="2">GOL X</th> 
                </tr>
                <tr>
                    <th>I/a</th>
                    <th>I/b</th>
                    <th>I/c</th>
                    <th>I/d</th>
                    <th>II/a</th>
                    <th>II/b</th>
                    <th>II/c</th>
                    <th>II/d</th>
                    <th>III/a</th>
                    <th>III/b</th>
                    <th>III/c</th>
                    <th>III/d</th>
                    <th>IV/a</th>
                    <th>IV/b</th>
                    <th>IV/c</th>
                    <th>IV/d</th>
                    <th>IV/e</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataStatistik as $label => $kategoriData)
                    <tr>
                        <td style="text-align: left; padding-left: 5px;">{{ $label }}</td>
                        <!-- Kolom Eselon -->
                        <td>{{ $kategoriData['I.a'] ?? 0 }}</td>
                        <td>{{ $kategoriData['I.b'] ?? 0 }}</td>
                        <td>{{ $kategoriData['II.a'] ?? 0 }}</td>
                        <td>{{ $kategoriData['II.b'] ?? 0 }}</td>
                        <td>{{ $kategoriData['III.a'] ?? 0 }}</td>
                        <td>{{ $kategoriData['III.b'] ?? 0 }}</td>
                        <td>{{ $kategoriData['IV.a'] ?? 0 }}</td>
                        <td>{{ $kategoriData['IV.b'] ?? 0 }}</td>
                        <td>{{ $kategoriData['V.a'] ?? 0 }}</td>
                        <td>{{ $kategoriData['V.b'] ?? 0 }}</td>
                        <td>{{ $kategoriData['-'] ?? 0 }}</td>
                        <!-- Total dan Kosong -->
                        <td><strong>{{ $kategoriData['total'] ?? 0 }}</strong></td>
                        <td>{{ $kategoriData['kosong'] ?? 0 }}</td>
                        <!-- Kolom Golongan -->
                        <td>{{ $kategoriData['Ia'] ?? 0 }}</td>
                        <td>{{ $kategoriData['Ib'] ?? 0 }}</td>
                        <td>{{ $kategoriData['Ic'] ?? 0 }}</td>
                        <td>{{ $kategoriData['Id'] ?? 0 }}</td>
                        <td>{{ $kategoriData['IIa'] ?? 0 }}</td>
                        <td>{{ $kategoriData['IIb'] ?? 0 }}</td>
                        <td>{{ $kategoriData['IIc'] ?? 0 }}</td>
                        <td>{{ $kategoriData['IId'] ?? 0 }}</td>
                        <td>{{ $kategoriData['IIIa'] ?? 0 }}</td>
                        <td>{{ $kategoriData['IIIb'] ?? 0 }}</td>
                        <td>{{ $kategoriData['IIIc'] ?? 0 }}</td>
                        <td>{{ $kategoriData['IIId'] ?? 0 }}</td>
                        <td>{{ $kategoriData['IVa'] ?? 0 }}</td>
                        <td>{{ $kategoriData['IVb'] ?? 0 }}</td>
                        <td>{{ $kategoriData['IVc'] ?? 0 }}</td>
                        <td>{{ $kategoriData['IVd'] ?? 0 }}</td>
                        <td>{{ $kategoriData['IVe'] ?? 0 }}</td>
                        <!-- GOL X - hanya satu kali -->
                        <td>{{ $kategoriData['X'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @elseif($kategori === 'jk_eselon')
        <table>
            <thead>
                <tr>
                    <th rowspan="3">{{ $judulKolomPertama }}</th>
                    <th rowspan="3">JML ESELON</th>
                    <th rowspan="3">JML ESELON KOSONG</th>
                    <th colspan="10">JUMLAH PER ESELON</th>
                </tr>
                <tr>
                    <th colspan="2">Eselon I</th>
                    <th colspan="2">Eselon II</th>
                    <th colspan="2">Eselon III</th>
                    <th colspan="2">Eselon IV</th>  
                    <th colspan="2">Eselon V</th>  
                </tr>
                <tr>
                    <th>I/a</th>
                    <th>I/b</th>
                    <th>II/a</th>
                    <th>II/b</th>
                    <th>III/a</th>
                    <th>III/b</th>
                    <th>IV/a</th>
                    <th>IV/b</th>
                    <th>V/a</th>
                    <th>V/b</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataStatistik as $label => $item)
                    <tr>
                        <td>{{ $label }}</td>
                        <td>{{ $item['total'] ?? 0 }}</td>
                        <td>{{ $item['kosong'] ?? 0 }}</td>
                        <td>{{ $item['I.a'] ?? 0 }}</td>
                        <td>{{ $item['I.b'] ?? 0 }}</td>
                        <td>{{ $item['II.a'] ?? 0 }}</td>
                        <td>{{ $item['II.b'] ?? 0 }}</td>
                        <td>{{ $item['III.a'] ?? 0 }}</td>
                        <td>{{ $item['III.b'] ?? 0 }}</td>
                        <td>{{ $item['IV.a'] ?? 0 }}</td>
                        <td>{{ $item['IV.b'] ?? 0 }}</td>
                        <td>{{ $item['V.a'] ?? 0 }}</td>
                        <td>{{ $item['V.b'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @elseif(!empty($dataStatistik) && !in_array($kategori, ['unitkerja_pendidikan', 'diklat', 'jk_eselon']))
        <table>
            <thead>
                <tr>
                    <th rowspan="3">{{ $judulKolomPertama }}</th>
                    <th rowspan="3">JML GOL.</th>
                    <th rowspan="3">JML GOL. KOSONG</th>
                    <th colspan="18">JUMLAH PER GOLONGAN</th>
                </tr>
                <tr>
                    <th colspan="4">GOL I</th>
                    <th colspan="4">GOL II</th>
                    <th colspan="4">GOL III</th>
                    <th colspan="5">GOL IV</th>  
                    <th rowspan="2">GOL X</th> 
                </tr>
                <tr>
                    <th>I/a</th>
                    <th>I/b</th>
                    <th>I/c</th>
                    <th>I/d</th>
                    <th>II/a</th>
                    <th>II/b</th>
                    <th>II/c</th>
                    <th>II/d</th>
                    <th>III/a</th>
                    <th>III/b</th>
                    <th>III/c</th>
                    <th>III/d</th>
                    <th>IV/a</th>
                    <th>IV/b</th>
                    <th>IV/c</th>
                    <th>IV/d</th>
                    <th>IV/e</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataStatistik as $label => $item)
                    <tr>
                        <td>{{ $label }}</td>
                        <td>{{ $item['total'] ?? 0 }}</td>
                        <td>{{ $item['kosong'] ?? 0 }}</td>
                        <td>{{ $item['Ia'] ?? 0 }}</td>
                        <td>{{ $item['Ib'] ?? 0 }}</td>
                        <td>{{ $item['Ic'] ?? 0 }}</td>
                        <td>{{ $item['Id'] ?? 0 }}</td>
                        <td>{{ $item['IIa'] ?? 0 }}</td>
                        <td>{{ $item['IIb'] ?? 0 }}</td>
                        <td>{{ $item['IIc'] ?? 0 }}</td>
                        <td>{{ $item['IId'] ?? 0 }}</td>
                        <td>{{ $item['IIIa'] ?? 0 }}</td>
                        <td>{{ $item['IIIb'] ?? 0 }}</td>
                        <td>{{ $item['IIIc'] ?? 0 }}</td>
                        <td>{{ $item['IIId'] ?? 0 }}</td>
                        <td>{{ $item['IVa'] ?? 0 }}</td>
                        <td>{{ $item['IVb'] ?? 0 }}</td>
                        <td>{{ $item['IVc'] ?? 0 }}</td>
                        <td>{{ $item['IVd'] ?? 0 }}</td>
                        <td>{{ $item['IVe'] ?? 0 }}</td>
                        <td>{{ $item['X'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="error-message">
            @if(empty($dataStatistik))
                Data statistik tidak tersedia untuk kategori yang dipilih
            @else
                Format laporan untuk kategori ini belum tersedia
            @endif
        </div>
    @endif
</body>
</html>