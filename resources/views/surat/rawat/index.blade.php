@extends('surat.layouts.main')

@section('main')

<div class="pagetitle">
    <div class="pagetitle">
    <div class="row justify-content-between">
        <div class="col">
            <h1>Daftar Surat keterangan Rawat</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat keterangan</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Pengajuan Surat keterangan Rawat Title -->

<section class="row mt-4">
    <form method="GET" action="{{ route('rawat.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('rawat.create') }}" class="btn btn-primary">
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
                <th>Jenis keterangan</th>
                <th style="width: 150px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($keteranganRawats as $index => $keteranganRawat)
            <tr>
                <td>{{ $keteranganRawats->firstItem() + $index }}</td>
                <td>{{ $keteranganRawat->pegawai->nama }}</td>
                <td>{{ $keteranganRawat->pegawai->nip }}</td>
                <td>{{ $keteranganRawat->pegawai->jabatan->nama_jabatan ?? '-' }}</td>
                <td>{{ ucfirst($keteranganRawat->jenis_keterangan) }}</td>
                <td>
                    <a href="{{ route('rawat.export', $keteranganRawat->id) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-word"></i> Export
                    </a>
                    <form action="{{ route('rawat.destroy', $keteranganRawat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus keterangan ini?')">
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
                    <td colspan="7" class="text-center">Tidak ada data keterangan yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Pagination -->
    {{ $keteranganRawats->appends(request()->query())->links() }}
</div>

@endsection