@extends('dashboard.layouts.main')

@section('main')
    
    <div class="pagetitle">
        <div class="row justify-content-between">
            <div class="col">
                <h1>Result</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Pegawai Title -->

    <div class="table-responsive small">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th scope="col" style="width: 17px">No</th>
                    <th scope="col" style="width: 183px">NIP</th>
                    <th scope="col" style="width: 250px">Nama</th>
                    <th scope="col" style="width: 120px">JK / TTL</th>
                    <th scope="col" style="width: 450px">Golongan / Jenis Kepegawaian</th>
                    <th scope="col" style="width: 93px">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pegawais as $pegawai)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pegawai->nip }}</td>
                    <td>{{ $pegawai->gelar_depan }}{{ $pegawai->nama }}, {{ $pegawai->gelar_belakang }}</td>
                    <td>{{ $pegawai->jenis_kelamin }}<br>{{ $pegawai->tempat_lahir }}<br>{{ $pegawai->tanggal_lahir }}</td>
                    <td>{{ $pegawai->golongan_ruang }}<br>{{ $pegawai->jenis_kepegawaian }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                        <a href="{{ route('pegawai.show',['pegawai' => $pegawai->id]) }}" class="btn btn-success btn-sm" title="Detial"><i class="bi bi-eye"></i></a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada pegawai ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-90deg-left"></i> Kembali ke Dashboard</a>

@endsection