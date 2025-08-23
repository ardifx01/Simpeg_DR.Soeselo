{{-- resources/views/surat/penetapan/index.blade.php --}}
@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat Penetapan</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat Penetapan</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="row mt-4">
    {{-- Toolbar + Search --}}
    <form method="GET" action="{{ route('penetapan.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('penetapan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Surat Penetapan
            </a>
        </div>

        <div class="col-12 col-md-5">
            <div class="input-group">
                <input type="search" name="search" id="search" class="form-control" value="{{ $search ?? request('search') }}" placeholder="Cari nomor, tentang, pejabat penetap (nama/NIP)...">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i> Search
                </button>
            </div>
        </div>
    </form>

    {{-- Tabel --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle text-center">
            <thead>
                <tr class="text-center align-middle">
                    <th style="width: 60px;">No</th>
                    <th>Nomor Surat</th>
                    <th>Pejabat Penetap</th>
                    <th>Tanggal Penetapan</th>
                    <th>Tentang</th>
                    <th style="width: 140px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penetapan as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $penetapan->firstItem() - 1 }}</td>
                        <td class="text-start">
                            {{ $item->nomor_surat ?? '-' }}<br>
                            <small class="text-muted">Tahun: {{ $item->tahun_surat ?? '-' }}</small>
                        </td>
                        <td class="text-start">
                            {{ optional($item->pegawai)->nama_lengkap ?? optional($item->pegawai)->nama ?? 'N/A' }}<br>
                            <small class="text-muted">NIP: {{ optional($item->pegawai)->nip ?? '-' }}</small>
                        </td>
                        <td class="text-center">
                            @php
                                $tgl = $item->tanggal_penetapan
                                    ? \Carbon\Carbon::parse($item->tanggal_penetapan)->locale('id')->translatedFormat('d F Y')
                                    : '-';
                            @endphp
                            {{ $tgl }}
                        </td>
                        <td class="text-start">{{ \Illuminate\Support\Str::limit($item->tentang ?? '-', 90) }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                <a href="{{ route('penetapan.export', $item->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-file-word"></i> Export
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data surat penetapan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    {{ $penetapan->appends(request()->query())->links() }}
</section>

@endsection