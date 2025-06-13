@extends('surat.layouts.main')

@section('main')

<div class="pagetitle">
    <div class="row justify-content-between">
        <div class="col">
            <h1>Daftar Surat Cuti</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat Cuti</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Pengajuan Surat Cuti Title -->

<section class="row mt-4">
    <form method="GET" action="{{ route('cuti.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('cuti.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pengajuan
            </a>
        </div>
        <div style="min-width: 250px;">
            <div class="input-group">
                <input type="search" name="search" id="search" class="form-control" value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i> search
                </button>
            </div>
        </div>
    </form>
    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>Jenis Cuti</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cutis as $cuti)
                <tr>
                    <td>{{ $cuti->pegawai->nama }}</td>
                    <td>{{ $cuti->pegawai->nip }}</td>
                    <td>{{ $cuti->pegawai->jabatan->nama ?? '-' }}</td>
                    <td>{{ ucfirst($cuti->jenis_cuti) }}</td>
                    <td>{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('cuti.export', $cuti->id) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-file-word"></i> Export
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data cuti yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Pagination -->
    {{ $cutis->appends(request()->query())->links() }}
</section>

@endsection