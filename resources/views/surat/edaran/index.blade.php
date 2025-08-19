@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat Edaran</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat Edaran</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<section class="row mt-4">
    <form method="GET" action="{{ route('edaran.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('edaran.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Surat Edaran
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
                    <th>Tentang</th>
                    <th>Nomor Surat</th>
                    <th>Penandatangan</th>
                    <th>Tanggal Ditetapkan</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($edarans as $index => $edaran)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $edarans->firstItem() - 1 }}</td>
                        <td>{{ $edaran->tentang }}</td>
                        <td class="text-center">
                            <span class="d-block">{{ $edaran->nomor ?? 'Belum ada nomor' }}</span>
                            <small class="text-muted">Tahun {{ $edaran->tahun }}</small>
                        </td>
                        <td>{{ $edaran->penandatangan->nama ?? '-' }}</td>
                        <td class="text-center">{{ $edaran->tanggal_ditetapkan->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('edaran.export', $edaran->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-word"></i> Export
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data surat edaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{ $edarans->appends(request()->query())->links() }}
</section>

@endsection