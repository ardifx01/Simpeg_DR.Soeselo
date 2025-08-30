@extends('surat.layouts.main')

@section('main')

<div class="pagetitle">
    <div class="pagetitle">
    <div class="row justify-content-between">
        <div class="col">
            <h1>Daftar Surat Hukuman</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat Hukuman</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Pengajuan Surat Hukuman Title -->

<section class="row mt-4">
    <form method="GET" action="{{ route('hukuman.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('hukuman.create') }}" class="btn btn-primary">
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

    <table class="table table-bordered table-striped table-hover align-middle text-center">
        <thead>
            <tr class="text-center align-middle">
                <th style="width: 50px;">No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>Jenis hukuman</th>
                <th>Waktu</th>
                <th>Tanggal Pengajuan</th>
                <th style="width: 100px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hukumans as $index => $hukuman)
            <tr>
                <td>{{ $hukumans->firstItem() + $index }}</td>
                <td>{{ $hukuman->pegawai->nama }}</td>
                <td>{{ $hukuman->pegawai->nip }}</td>
                <td>{{ $hukuman->pegawai->jabatan->nama_jabatan ?? '-' }}</td>
                <td>{{ ucfirst($hukuman->jenis_hukuman) }}</td>
                <td>{{ ($hukuman->waktu) }}</td>
                <td>{{ \Carbon\Carbon::parse($hukuman->tanggal)->format('d-m-Y') }}</td>
                <td>
                    <a href="{{ route('hukuman.export', $hukuman->id) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-word"></i> Export
                    </a>
                    <form action="{{ route('hukuman.destroy', $hukuman->id) }}" method="POST" class="d-inline"  onsubmit="return confirm('Yakin hapus data hukuman ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data hukuman yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Pagination -->
    {{ $hukumans->appends(request()->query())->links() }}
</div>

@endsection