@extends('surat.layouts.main')

@section('main')

<div class="pagetitle">
    <div class="row justify-content-between">
        <div class="col">
            <h1>Daftar Berita Acara</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Berita Acara</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Pengajuan Surat Berita Acara Title -->

<section class="row mt-4">
    <form method="GET" action="{{ route('berita_acara.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('berita_acara.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Berita Acara
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
                <th>Tanggal</th>
                <th>Pihak Pertama</th>
                <th>Pihak Kedua</th>
                <th>Atasan</th>
                <th style="width: 100px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($beritaAcaras as $index => $beritaAcara)
                <tr>
                    <td>{{ $beritaAcara->firstItem() + $index }}</td>
                    <td>{{ \Carbon\Carbon::parse($beritaAcara->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $beritaAcara->pihakPertama->getNamaLengkapAttribute() }}</td>
                    <td>{{ $beritaAcara->pihakKedua ? $beritaAcara->pihakKedua->getNamaLengkapAttribute() : '-' }}</td>
                    <td>{{ $beritaAcara->atasan->getNamaLengkapAttribute() }}</td>
                    <td>
                        <a href="{{ route('berita_acara.export', $beritaAcara->id) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-file-word"></i> Export
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data berita acara</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Pagination -->
    {{ $beritaAcaras->appends(request()->query())->links() }}
</section>
@endsection