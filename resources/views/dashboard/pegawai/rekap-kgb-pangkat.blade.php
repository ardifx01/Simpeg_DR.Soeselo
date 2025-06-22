@extends('dashboard.layouts.main')

@section('main')

<div class="pagetitle">
    <div class="row justify-content-between">
        <div class="col">
            <h1>Pegawai | <small>Riwayat KGB dan Kenaikan Pangkat</small></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">KGB dan Kenaikan Pangkat</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Pegawai Title -->

<div class="container-fluid">
    <h4 class="mb-3">Rekap Kenaikan Gaji Berkala (KGB)</h4>
    <table class="table table-bordered table-sm">
        <thead class="table-primary">
            <tr class="text-center">
                <th>No</th>
                <th>Nama</th>
                <th>Golongan</th>
                <th>TMT Golongan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataKGB as $i => $pegawai)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $pegawai->nama }}</td>
                    <td>{{ $pegawai->golongan_ruang ?? $pegawai->golongan_ruang_cpns }}</td>
                    <td>{{ $pegawai->tmt_golongan_ruang ?? $pegawai->tmt_golongan_ruang_cpns }}</td>
                    <td><a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn btn-sm btn-info">Detail</a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada pegawai yang waktunya KGB.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-2">
        {{ $dataKGB->appends(['pangkat_page' => request('pangkat_page')])->links() }}
    </div> 

    <h4 class="mb-3 mt-5">Rekap Kenaikan Pangkat</h4>
    <table class="table table-bordered table-sm">
        <thead class="table-success">
            <tr class="text-center">
                <th>No</th>
                <th>Nama</th>
                <th>Golongan</th>
                <th>TMT Golongan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataPangkat as $i => $pegawai)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $pegawai->nama }}</td>
                    <td>{{ $pegawai->golongan_ruang ?? $pegawai->golongan_ruang_cpns }}</td>
                    <td>{{ $pegawai->tmt_golongan_ruang ?? $pegawai->tmt_golongan_ruang_cpns }}</td>
                    <td><a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn btn-sm btn-success">Detail</a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada pegawai yang waktunya naik pangkat.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-2">
        {{ $dataPangkat->appends(['kgb_page' => request('kgb_page')])->links() }}
    </div>
</div>

@endsection