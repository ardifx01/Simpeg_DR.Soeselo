@extends('surat.layouts.main')

@section('main')

<div class="pagetitle">
    <div class="pagetitle">
    <div class="row justify-content-between">
        <div class="col">
            <h1>Daftar Surat Pembinaan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat Pembinaan</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Pengajuan Surat pembinaan Title -->

<section class="row mt-4">
    <form method="GET" action="{{ route('pembinaan.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('pembinaan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pengajuan
            </a>
        </div>
        <div class="col-12 col-md-4">
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
                <th>Nama Suami/Istri</th>
                <th>Hubungan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pembinaans as $pembinaan)
            <tr>
                <td>{{ $pembinaan->pegawai->nama }}</td>
                <td>{{ $pembinaan->pegawai->nip }}</td>
                <td>{{ $pembinaan->pegawai->jabatan->nama ?? '-' }}</td>
                <td>{{ $pembinaan->nama }}</td>
                <td>{{ $pembinaan->hubungan }}</td>
                <td>
                    <a href="{{ route('pembinaan.export', $pembinaan->id) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-word"></i> Export
                    </a>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data pembinaan yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Pagination -->
    {{ $pembinaans->appends(request()->query())->links() }}
</div>

@endsection