@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat Kuasa</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat Kuasa</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="row mt-4">
    <form method="GET" action="{{ route('kuasa.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('kuasa.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Surat Kuasa
            </a>
        </div>
        <div class="col-12 col-md-4">
            <div class="input-group">
                <input type="search" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Cari nomor, pemberi, penerima, keperluan...">
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
                    <th>Pemberi Kuasa</th>
                    <th>Penerima Kuasa</th>
                    <th>Tempat</th>
                    <th>Tanggal</th>
                    <th style="width: 110px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kuasas as $index => $kuasa)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $kuasas->firstItem() - 1 }}</td>
                        <td class="text-center">{{ $kuasa->nomor ?? '-' }}</td>
                        <td>{{ optional($kuasa->pemberi)->nama ?? 'N/A' }}</td>
                        <td>{{ optional($kuasa->penerima)->nama ?? 'N/A' }}</td>
                        <td>{{ $kuasa->tempat ?? '-' }}</td>
                        <td class="text-center">
                            {{ optional($kuasa->tanggal)->format('d-m-Y') ?? '-' }}
                        </td>
                        <td>
                            <a href="{{ route('kuasa.export', $kuasa->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-word"></i> Export
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data surat kuasa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{ $kuasas->appends(request()->query())->links() }}
</section>

@endsection
