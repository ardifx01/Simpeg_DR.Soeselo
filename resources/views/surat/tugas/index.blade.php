{{-- resources/views/surat/tugas/index.blade.php --}}
@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat Tugas</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat Tugas</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="row mt-4">
    <form method="GET" action="{{ route('tugas.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('tugas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Surat Tugas
            </a>
        </div>

        <div class="col-12 col-md-5">
            <div class="input-group">
                <input type="search" name="search" id="search" class="form-control" value="{{ $search ?? request('search') }}" placeholder="Cari nomor, tempat, atau pegawai (nama/NIP)...">
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
                    <th>Tempat / Tanggal</th>
                    <th>Pegawai Ditugaskan</th>
                    <th>Dasar</th>
                    <th>Untuk</th>
                    <th style="width:140px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tugas as $item)
                    @php
                        $tgl = $item->tanggal_dikeluarkan
                            ? \Carbon\Carbon::parse($item->tanggal_dikeluarkan)->locale('id')->translatedFormat('d F Y')
                            : '-';

                        $dasarRingkas = \Illuminate\Support\Str::limit(
                            implode(' | ', array_slice(preg_split('/\r\n|\n|\r|;/', (string) $item->dasar), 0, 2)),
                            90
                        );
                        $untukRingkas = \Illuminate\Support\Str::limit(
                            implode(' | ', array_slice(preg_split('/\r\n|\n|\r|;/', (string) $item->untuk), 0, 2)),
                            90
                        );

                        $arrPegawai = is_array($item->pegawai) ? $item->pegawai : [];
                        $totalPegawai = count($arrPegawai);
                        $namaList = collect($arrPegawai)->pluck('nama')->filter()->values();
                        $namaPreview = $namaList->take(2)->implode(', ');
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration + $tugas->firstItem() - 1 }}</td>
                        <td class="text-start">{{ $item->nomor ?? '-' }}</td>
                        <td class="text-start">
                            {{ $item->tempat_dikeluarkan ?? '-' }}<br>
                            <small class="text-muted">{{ $tgl }}</small>
                        </td>
                        <td class="text-start">
                            @if($item->total_pegawai === 0)
                                -
                            @else
                                {{ $item->nama_preview }}
                                @if($item->total_pegawai > 2)
                                    dan {{ $item->total_pegawai - 2 }} lainnya
                                @endif
                                <br><small class="text-muted">Total: {{ $item->total_pegawai }} pegawai</small>
                            @endif
                        </td>
                        <td class="text-start">{{ $dasarRingkas ?: '-' }}</td>
                        <td class="text-start">{{ $untukRingkas ?: '-' }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                <a href="{{ route('tugas.export', $item->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-file-word"></i> Export
                                </a>
                                <form action="{{ route('tugas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data surat tugas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    {{ $tugas->appends(request()->query())->links() }}
</section>

@endsection