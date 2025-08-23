@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat Perintah</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat Perintah</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="row mt-4">
    {{-- Toolbar + Search --}}
    <form method="GET" action="{{ route('perintah.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('perintah.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Surat Perintah
            </a>
        </div>

        <div class="col-12 col-md-5">
            <div class="input-group">
                <input type="search" name="search" id="search" class="form-control" value="{{ $search ?? request('search') }}" placeholder="Cari nomor, tempat, atau pejabat (nama/NIP)...">
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
                    <th>Pejabat Penandatangan</th>
                    <th>Tanggal Perintah</th>
                    <th>Tempat</th>
                    <th>Ringkasan "Untuk"</th>
                    <th>Penerima</th>
                    <th style="width:140px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($perintah as $item)
                    @php
                        $tgl = $item->tanggal_perintah
                            ? \Carbon\Carbon::parse($item->tanggal_perintah)->locale('id')->translatedFormat('d F Y')
                            : '-';

                        // ambil 1–2 baris pertama dari "untuk" sebagai ringkasan
                        $untukLines = is_string($item->untuk) ? preg_split('/\r\n|\n|\r/', $item->untuk) : [];
                        $untukLines = array_values(array_filter(array_map('trim', $untukLines)));
                        $untukRingkas = \Illuminate\Support\Str::limit(implode(' | ', array_slice($untukLines, 0, 2)) ?: '-', 90);

                        $countPenerima = is_array($item->penerima) ? count($item->penerima) : (is_countable($item->penerima ?? []) ? count($item->penerima) : 0);
                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $perintah->firstItem() - 1 }}</td>
                        <td class="text-start">{{ $item->nomor_surat ?? '-' }}</td>
                        <td class="text-start">{{ optional($item->pegawai)->nama_lengkap ?? optional($item->pegawai)->nama ?? 'N/A' }}<br><small class="text-muted">NIP: {{ optional($item->pegawai)->nip ?? '-' }}</small></td>
                        <td class="text-center">{{ $tgl }}</td>
                        <td class="text-start">{{ $item->tempat_dikeluarkan ?? '-' }}</td>
                        <td class="text-start">{{ $untukRingkas }}</td>
                        <td class="text-center"><span class="badge bg-secondary">{{ $countPenerima }}</span></td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                <a href="{{ route('perintah.export', $item->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-file-word"></i> Export
                                </a>
                                {{-- Optional: Edit / Hapus
                                <a href="{{ route('perintah.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('perintah.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                                --}}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data surat perintah.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    {{ $perintah->appends(request()->query())->links() }}
</section>

@endsection