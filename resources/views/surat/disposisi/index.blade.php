@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat Disposisi</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item">Daftar Surat Disposisi</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Daftar Disposisi Title -->

<section class="row mt-4">
    <form method="GET" action="{{ route('disposisi.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('disposisi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Surat Disposisi
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
                    <th>Hal</th>
                    <th>Sifat</th>
                    <th>Penandatangan</th>
                    <th>Tanggal Surat</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($disposisis as $index => $item)
                    <tr>
                        <td>{{ $disposisis->firstItem() + $index }}</td>
                        <td>{{ $item->hal }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $item->sifat)) }}</td>
                        <td>{{ $item->penandatangan->nama_lengkap ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_surat)->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('disposisi.export', $item->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-word"></i> Export
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data disposisi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{ $disposisis->appends(request()->query())->links() }}
</section>
@endsection
