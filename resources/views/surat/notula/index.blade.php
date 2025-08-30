@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Notula</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Notula</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="row mt-4">
    <form method="GET" action="{{ route('notula.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('notula.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Notula
            </a>
        </div>
        <div class="col-12 col-md-4">
            <div class="input-group">
                <input type="search" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Cari sidang/rapat, acara, kegiatan, undangan, nama ketua/sekretaris/pencatat...">
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
                    <th>Sidang/Rapat</th>
                    <th>Ketua</th>
                    <th>Sekretaris</th>
                    <th>Pencatat</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Undangan</th>
                    <th style="width: 120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($notulas as $index => $notula)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $notulas->firstItem() - 1 }}</td>
                        <td class="text-start">{{ $notula->sidang_rapat ?? '-' }}</td>
                        <td class="text-start">{{ optional($notula->ketua)->nama ?? 'N/A' }}</td>
                        <td class="text-start">{{ optional($notula->sekretaris)->nama ?? 'N/A' }}</td>
                        <td class="text-start">{{ optional($notula->pencatat)->nama ?? 'N/A' }}</td>
                        <td class="text-center">{{ optional($notula->tanggal)->format('d-m-Y') ?? '-' }}</td>
                        <td class="text-center">{{ optional($notula->waktu)->format('H:i') ?? '-' }}</td>
                        <td class="text-start">{{ $notula->surat_undangan ?? '-' }}</td>
                        <td>
                            <a href="{{ route('notula.export', $notula->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-word"></i> Export
                            </a>
                            <form action="{{ route('notula.destroy', $notula->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus notula ini?')">
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
                        <td colspan="9" class="text-center">Tidak ada data notula.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{ $notulas->appends(request()->query())->links() }}
</section>

@endsection
