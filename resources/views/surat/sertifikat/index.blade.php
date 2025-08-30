{{-- resources/views/surat/sertifikat/index.blade.php --}}
@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Sertifikat</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Sertifikat</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="row mt-4">
    <form method="GET" action="{{ route('sertifikat.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('sertifikat.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Sertifikat
            </a>
        </div>

        <div class="col-12 col-md-5">
            <div class="input-group">
                <input type="search" name="search" id="search" class="form-control" value="{{ $search ?? request('search') }}" placeholder="Cari nomor, penerima, kegiatan, penyelenggara...">
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
                    <th style="width:60px;">No</th>
                    <th>Nomor</th>
                    <th>Penerima</th>
                    <th>Kegiatan</th>
                    <th>Penyelenggara</th>
                    <th>Periode</th>
                    <th>Penandatangan</th>
                    <th style="width:140px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sertifikat as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $sertifikat->firstItem() - 1 }}</td>
                        <td class="text-start">{{ $item->nomor ?? '-' }}</td>
                        <td class="text-start">{{ optional($item->penerima)->nama_lengkap ?? optional($item->penerima)->nama ?? 'N/A' }}<br><small class="text-muted">NIP: {{ optional($item->penerima)->nip ?? '-' }}</small></td>
                        <td class="text-start">{{ \Illuminate\Support\Str::limit($item->nama_kegiatan ?? '-', 50) }}</td>
                        <td class="text-start">{{ $item->penyelenggara ?? '-' }}</td>
                        <td class="text-start">{{ $item->tanggal_mulai?->translatedFormat('d F Y') ?? '-' }} s.d. {{ $item->tanggal_selesai?->translatedFormat('d F Y') ?? '-' }}<br> <small class="text-muted">{{ $item->lokasi ?? '-' }}</small></td>   
                        <td class="text-start">{{ optional($item->penandatangan)->nama_lengkap ?? optional($item->penandatangan)->nama ?? 'N/A' }}<br><small class="text-muted">NIP: {{ optional($item->penandatangan)->nip ?? '-' }}</small></td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                <a href="{{ route('sertifikat.export', $item->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-file-word"></i> Export
                                </a>
                                <form action="{{ route('sertifikat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data sertifikat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    {{ $sertifikat->appends(request()->query())->links() }}
</section>

@endsection