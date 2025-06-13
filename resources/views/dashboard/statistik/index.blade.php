@extends('dashboard.layouts.main')

@section('main')

<div class="pagetitle">
    <div class="row justify-content-between">
        <div class="col">
            <h1>Statistik Pegawai</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Statistik Pegawai</li>
                </ol>
            </nav>
        </div>
        <div class="col">
            <div class="text-end">
                <a href="{{ route('pegawai.create') }}"><button type="button" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah Pegawai</button></a>
            </div>
        </div>
    </div>
</div><!-- End Statistik Pegawai Title -->

<section class="section dashboard">
    <div class="container-fluid">
        <div class="card">
            <div class="row card-body mt-4">
                <form action="{{ route('statistik.index') }}" method="GET" id="statistikForm">
                    <div class="form-group">
                        <div class="row mb-3 align-items-center">
                            <label for="unitKerja" class="col-sm-2 col-form-label fw-bold">Unit Kerja:</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-control" name="unit_kerja" id="unit_kerja">
                                    <option value="">Unit Kerja</option>    
                                    @foreach($unitKerja as $key => $value)
                                        <option value="{{ $value }}" 
                                            {{ request('unit_kerja', '-- RSUD dr. Soeselo Slawi --') == $value ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="kategori" class="col-sm-2 col-form-label fw-bold">Kategori:</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-control" name="kategori" id="kategori">
                                    <option value="">-- Pilihan --</option>
                                    @foreach($kategoriOptions as $key => $value)
                                        <option value="{{ $key }}" {{ request('kategori') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success btn-sm" id="lihatStatistik">
                            <i class="bi bi-bar-chart"></i> Lihat Statistik
                        </button>
                        @if(request('kategori'))
                            <div class="btn-group" role="group">
                                <a href="{{ route('statistik.preview', request()->query()) }}" 
                                class="btn btn-success btn-sm" target="_blank">
                                    <i class="bi bi-printer"></i> Cetak Statistik
                                </a>
                            </div>
                        @else
                            <button type="button" class="btn btn-danger btn-sm" disabled>
                                <i class="bi bi-printer"></i> Cetak Statistik
                            </button>
                            <small class="text-danger d-block mt-1">Silahkan pilih kategori terlebih dahulu!</small>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        @if(request('kategori') === 'unitkerja_pendidikan' && !empty($dataStatistik))
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title text-center">STATISTIK PEGAWAI BERDASARKAN {{ $judulKolomPertama }} DAN JENJANG PENDIDIKAN PADA RSUD DR. SOESELO SLAWI</h5>
                <div class="table-responsive">
                    <table class="table table-bordered mt-4">
                        <thead class="table-primary text-center align-middle">
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
                                <td class="text-center">{{ $item['total'] }}</td>
                                <td class="text-center">{{ $item['kosong'] }}</td>
                                <td class="text-center">{{ $item['SD'] }}</td>
                                <td class="text-center">{{ $item['SMP'] }}</td>
                                <td class="text-center">{{ $item['SMA'] }}</td>
                                <td class="text-center">{{ $item['D3'] }}</td>
                                <td class="text-center">{{ $item['D4'] }}</td>
                                <td class="text-center">{{ $item['S1'] }}</td>
                                <td class="text-center">{{ $item['S2'] }}</td>
                                <td class="text-center">{{ $item['S3'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @elseif(request('kategori') === 'diklat' && !empty($dataStatistik))
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title text-center">STATISTIK PEGAWAI BERDASARKAN {{ $judulKolomPertama }} PADA RSUD DR. SOESELO SLAWI</h5>
                <div class="table-responsive">
                    <table class="table table-bordered mt-4">
                        <thead class="table-primary text-center align-middle">
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
                                    <td>{{ $label }}</td>
                                    <!-- Kolom Eselon -->
                                    <td class="text-center">{{ $kategoriData['I.a'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['I.b'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['II.a'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['II.b'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['III.a'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['III.b'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['IV.a'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['IV.b'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['V.a'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['V.b'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['-'] ?? 0 }}</td>
                                    <!-- Total dan Kosong -->
                                    <td class="text-center">{{ $kategoriData['total'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['kosong'] ?? 0 }}</td>
                                    <!-- Kolom Golongan -->
                                    <td class="text-center">{{ $kategoriData['Ia'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['Ib'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['Ic'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['Id'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['IIa'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['IIb'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['IIc'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['IId'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['IIIa'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['IIIb'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['IIIc'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['IIId'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['IVa'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['IVb'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['IVc'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['IVd'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['IVe'] ?? 0 }}</td>
                                    <td class="text-center">{{ $kategoriData['X'] ?? 0 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @elseif(request('kategori') === 'jk_eselon' && !empty($dataStatistik))
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title text-center">STATISTIK PEGAWAI BERDASARKAN {{ $judulKolomPertama }} DAN GOLONGAN PADA RSUD DR. SOESELO SLAWI</h5>
                <div class="table-responsive">
                    <table class="table table-bordered mt-4">
                        <thead class="table-primary text-center align-middle">
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
                                    <td class="text-center">{{ $item['total'] }}</td>
                                    <td class="text-center">{{ $item['kosong'] }}</td>
                                    <td class="text-center">{{ $item['I.a'] }}</td>
                                    <td class="text-center">{{ $item['I.b'] }}</td>
                                    <td class="text-center">{{ $item['II.a'] }}</td>
                                    <td class="text-center">{{ $item['II.b'] }}</td>
                                    <td class="text-center">{{ $item['III.a'] }}</td>
                                    <td class="text-center">{{ $item['III.b'] }}</td>
                                    <td class="text-center">{{ $item['IV.a'] }}</td>
                                    <td class="text-center">{{ $item['IV.b'] }}</td>
                                    <td class="text-center">{{ $item['V.a'] }}</td>
                                    <td class="text-center">{{ $item['V.b'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @elseif(request('kategori') && !empty($dataStatistik))
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title text-center">STATISTIK PEGAWAI BERDASARKAN {{ $judulKolomPertama }} DAN GOLONGAN PADA RSUD DR. SOESELO SLAWI</h5>
                <div class="table-responsive">
                    <table class="table table-bordered mt-4">
                        <thead class="table-primary text-center align-middle">
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
                                    <td class="text-center">{{ $item['total'] }}</td>
                                    <td class="text-center">{{ $item['kosong'] }}</td>
                                    <td class="text-center">{{ $item['Ia'] }}</td>
                                    <td class="text-center">{{ $item['Ib'] }}</td>
                                    <td class="text-center">{{ $item['Ic'] }}</td>
                                    <td class="text-center">{{ $item['Id'] }}</td>
                                    <td class="text-center">{{ $item['IIa'] }}</td>
                                    <td class="text-center">{{ $item['IIb'] }}</td>
                                    <td class="text-center">{{ $item['IIc'] }}</td>
                                    <td class="text-center">{{ $item['IId'] }}</td>
                                    <td class="text-center">{{ $item['IIIa'] }}</td>
                                    <td class="text-center">{{ $item['IIIb'] }}</td>
                                    <td class="text-center">{{ $item['IIIc'] }}</td>
                                    <td class="text-center">{{ $item['IIId'] }}</td>
                                    <td class="text-center">{{ $item['IVa'] }}</td>
                                    <td class="text-center">{{ $item['IVb'] }}</td>
                                    <td class="text-center">{{ $item['IVc'] }}</td>
                                    <td class="text-center">{{ $item['IVd'] }}</td>
                                    <td class="text-center">{{ $item['IVe'] }}</td>
                                    <td class="text-center">{{ $item['X'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @elseif(request('kategori') && empty($dataStatistik))
        <div class="alert alert-warning mt-4">
            <i class="bi bi-exclamation-triangle-fill"></i> Tolong pilih kategori terlebih dahulu!
        </div>
        @endif
    </div>
</section>

@endsection