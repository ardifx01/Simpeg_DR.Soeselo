@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Nota Dinas</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Nota Dinas</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="row mt-4">
    <form method="GET" action="{{ route('nota_dinas.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('nota_dinas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Nota Dinas
            </a>
        </div>
        <div class="col-12 col-md-4">
            <div class="input-group">
                <input type="search" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Cari nomor, hal, sifat, isi, pemberi/penerima...">
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
                    <th>Nomor</th>
                    <th>Pemberi</th>
                    <th>Penerima</th>
                    <th>Sifat</th>
                    <th>Tanggal</th>
                    <th style="width: 110px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($notas as $index => $nota)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $notas->firstItem() - 1 }}</td>
                        <td class="text-center">{{ $nota->nomor ?? '-' }}</td>
                        <td>{{ optional($nota->pemberi)->nama ?? 'N/A' }}</td>
                        <td>{{ optional($nota->penerima)->nama ?? 'N/A' }}</td>
                        <td>{{ $nota->sifat ?? '-' }}</td>
                        <td class="text-center">
                            {{ optional($nota->tanggal)->format('d-m-Y') ?? '-' }}
                        </td>
                        <td>
                            <a href="{{ route('nota_dinas.export', $nota->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-word"></i> Export
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data nota dinas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{ $notas->appends(request()->query())->links() }}
</section>

@endsection
