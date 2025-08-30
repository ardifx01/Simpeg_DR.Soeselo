@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat Dinas</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item">Daftar Surat Dinas</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Pengajuan Surat Dinas Title -->

<section class="row mt-4">
    <form method="GET" action="{{ route('dinas.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('dinas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pengajuan Dinas
            </a>
        </div>
        <div class="col-12 col-md-4">
            <div class="input-group">
                <input type="search" name="search" id="search" class="form-control" value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i> Search
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
                <th>Kepada Yth</th>
                <th>Tanggal Surat</th>
                <th style="width: 100px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dinas as $index => $item)
                <tr>
                    <td>{{ $dinas->firstItem() + $index }}</td>
                    <td>{{ $item->penandatangan->nama }}</td>
                    <td>{{ $item->penandatangan->nip }}</td>
                    <td>{{ $item->penandatangan->jabatan->nama_jabatan ?? '-' }}</td>
                    <td>{{ $item->kepada_yth }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('dinas.export', $item->id) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-file-word"></i> Export
                        </a>
                        <form action="{{ route('dinas.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus surat dinas ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data surat dinas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Pagination -->
    {{ $dinas->appends(request()->query())->links() }}
</section>
@endsection