@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat Pernyataan</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat Pernyataan</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="row mt-4">
    {{-- Toolbar + Search --}}
    <form method="GET" action="{{ route('pernyataan.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('pernyataan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Surat Pernyataan
            </a>
        </div>

        <div class="col-12 col-md-5">
            <div class="input-group">
                <input type="search" name="search" id="search" class="form-control" value="{{ $search ?? request('search') }}" placeholder="Cari nomor, tempat, pegawai/pejabat/penandatangan (nama/NIP)...">
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
                    <th>Nomor Surat</th>
                    <th>Tanggal & Tempat</th>
                    <th>Pegawai</th>
                    <th>Pejabat</th>
                    <th>Ringkasan Peraturan</th>
                    <th>Penandatangan</th>
                    <th>Tembusan</th>
                    <th style="width:140px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pernyataan as $item)
                    @php
                        $tgl = $item->tanggal_surat
                            ? \Carbon\Carbon::parse($item->tanggal_surat)->locale('id')->translatedFormat('d F Y')
                            : '-';

                        $ringkasPeraturan = \Illuminate\Support\Str::limit(
                            trim(
                                ($item->peraturan_tugas ? ($item->peraturan_tugas . ' ') : '') .
                                ($item->nomor_peraturan ? ('No. ' . $item->nomor_peraturan . ' ') : '') .
                                ($item->tahun_peraturan ? ('Tahun ' . $item->tahun_peraturan . ' ') : '') .
                                ($item->tentang_peraturan ? ('tentang ' . $item->tentang_peraturan) : '')
                            ) ?: '-',
                            100
                        );

                        $tembusanCount = is_array($item->tembusan) ? count($item->tembusan) : 0;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $pernyataan->firstItem() - 1 }}</td>
                        <td class="text-start">{{ $item->nomor_surat ?? '-' }}</td>
                        <td class="text-start">{{ $tgl }}<br><small class="text-muted">{{ $item->tempat_surat ?? '-' }}</small></td>
                        <td class="text-start">{{ optional($item->pegawai)->nama_lengkap ?? optional($item->pegawai)->nama ?? 'N/A' }}<br>
                            <small class="text-muted">NIP: {{ optional($item->pegawai)->nip ?? '-' }}</small><br>
                            <small class="text-muted">Jabatan: {{ optional(optional($item->pegawai)->jabatan)->nama_jabatan ?? '-' }}</small>
                        </td>
                        <td class="text-start">{{ optional($item->pejabat)->nama_lengkap ?? optional($item->pejabat)->nama ?? 'N/A' }}<br>
                            <small class="text-muted">NIP: {{ optional($item->pejabat)->nip ?? '-' }}</small><br>
                            <small class="text-muted">Jabatan: {{ optional(optional($item->pejabat)->jabatan)->nama_jabatan ?? '-' }}</small>
                        </td>
                        <td class="text-start">{{ $ringkasPeraturan }}</td>
                        <td class="text-start">{{ $item->nama_penandatangan ?? (optional($item->penandatangan)->nama_lengkap ?? optional($item->penandatangan)->nama ?? 'N/A') }}<br>
                            <small class="text-muted">NIP: {{ $item->nip_penandatangan ?? (optional($item->penandatangan)->nip ?? '-') }}</small><br>
                            <small class="text-muted">Jabatan: {{ $item->jabatan_penandatangan ?? (optional(optional($item->penandatangan)->jabatan)->nama_jabatan ?? '-') }}</small>
                        </td>
                        <td class="text-center"><span class="badge bg-secondary">{{ $tembusanCount }}</span></td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                <a href="{{ route('pernyataan.export', $item->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-file-word"></i> Export
                                </a>
                                {{-- Optional future:
                                <a href="{{ route('pernyataan.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('pernyataan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                                --}}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data surat pernyataan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    {{ $pernyataan->appends(request()->query())->links() }}
</section>

@endsection