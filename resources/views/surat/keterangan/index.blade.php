@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat keterangan</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat keterangan</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<section class="row mt-4">
    <form method="GET" action="{{ route('keterangan.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('keterangan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Surat Keterangan
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

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle text-center">
            <thead>
                <tr class="text-center align-middle">
                    <th style="width: 50px;">No</th>
                    <th>Nomor Surat</th>
                    <th>Pegawai yang Diterangkan</th>
                    <th>Penandatangan</th>
                    <th>Tanggal Ditetapkan</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($keterangans as $index => $keterangan)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $keterangans->firstItem() - 1 }}</td>
                        <td class="text-center">{{ $keterangan->nomor ?? '-' }}</td>
                        <td>{{ optional($keterangan->pegawai)->nama ?? 'N/A' }}</td>
                        <td>{{ optional($keterangan->penandatangan)->nama ?? 'N/A' }}</td>
                        <td class="text-center">{{ $keterangan->tanggal_ditetapkan->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('keterangan.export', $keterangan->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-word"></i> Export
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data surat keterangan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{ $keterangans->appends(request()->query())->links() }}
</section>

@endsection