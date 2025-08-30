@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat Panggilan</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat Panggilan</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="row mt-4">
    <form method="GET" action="{{ route('panggilan.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('panggilan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Surat Panggilan
            </a>
        </div>
        <div class="col-12 col-md-5">
            <div class="input-group">
                <input type="search" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Cari nomor, perihal, sifat, pegawai/penandatangan, jadwal...">
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
                    <th>Pegawai Dipanggil</th>
                    <th>Penandatangan</th>
                    <th>Sifat</th>
                    <th>Tanggal Surat</th>
                    <th>Jadwal</th>
                    <th style="width: 120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($panggilans as $index => $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $panggilans->firstItem() - 1 }}</td>
                        <td class="text-start">{{ $item->nomor_surat ?? '-' }}</td>
                        <td class="text-start">
                            {{ optional($item->pegawai)->nama_lengkap ?? 'N/A' }}<br>
                            <small class="text-muted">NIP: {{ optional($item->pegawai)->nip ?? '-' }}</small>
                        </td>
                        <td class="text-start">
                            {{ optional($item->penandatangan)->nama_lengkap ?? 'N/A' }}<br>
                            <small class="text-muted">NIP: {{ optional($item->penandatangan)->nip ?? '-' }}</small>
                        </td>
                        <td>{{ $item->sifat ?? '-' }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-m-Y') }}</td>
                        <td class="text-start">
                            <div><strong>{{ $item->jadwal_hari ?? '-' }}</strong></div>
                            <div>{{ \Carbon\Carbon::parse($item->jadwal_tanggal)->format('d-m-Y') }} • {{ $item->jadwal_pukul ?? '-' }}</div>
                            <div class="text-muted">{{ $item->jadwal_tempat ?? '-' }}</div>
                        </td>
                        <td>
                            <a href="{{ route('panggilan.export', $item->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-word"></i> Export
                            </a>
                            <form action="{{ route('panggilan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus surat panggilan ini?')">
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
                        <td colspan="8" class="text-center">Tidak ada data surat panggilan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{ $panggilans->appends(request()->query())->links() }}
</section>

@endsection