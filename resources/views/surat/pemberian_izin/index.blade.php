{{-- resources/views/surat/pemberian_izin/index.blade.php --}}
@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat Pemberian Izin</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat Pemberian Izin</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="row mt-4">
    <form method="GET" action="{{ route('pemberian_izin.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('pemberian_izin.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Surat Izin
            </a>
        </div>

        <div class="col-12 col-md-5">
            <div class="input-group">
                <input type="search" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Cari nomor surat, tentang, pegawai, pemberi izin, lokasi...">
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
                    <th>Pegawai</th>
                    <th>Pemberi Izin</th>
                    <th>Ditapkan di</th>
                    <th>Tanggal Penetapan</th>
                    <th>Tentang</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pemberianIzins as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $pemberianIzins->firstItem() - 1 }}</td>
                        <td class="text-start">{{ $item->nomor_surat ?? '-' }}</td>
                        <td class="text-start">
                            {{ optional($item->pegawai)->nama_lengkap ?? optional($item->pegawai)->nama ?? 'N/A' }}<br>
                            <small class="text-muted">NIP: {{ optional($item->pegawai)->nip ?? '-' }}</small>
                        </td>
                        <td class="text-start">
                            {{ optional($item->pemberiIzin)->nama_lengkap ?? optional($item->pemberiIzin)->nama ?? 'N/A' }}<br>
                            <small class="text-muted">NIP: {{ optional($item->pemberiIzin)->nip ?? '-' }}</small>
                        </td>
                        <td class="text-start">{{ $item->ditetapkan_di ?? '-' }}</td>
                        <td class="text-center">
                            @php
                                $tgl = $item->tanggal_penetapan
                                    ? \Carbon\Carbon::parse($item->tanggal_penetapan)->locale('id')->translatedFormat('d F Y')
                                    : '-';
                            @endphp
                            {{ $tgl }}
                        </td>
                        <td class="text-start">
                            {{ \Illuminate\Support\Str::limit($item->tentang ?? '-', 80) }}
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                <a href="{{ route('pemberian_izin.export', $item->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-file-word"></i> Export
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data surat pemberian izin.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    {{ $pemberianIzins->appends(request()->query())->links() }}
</section>

@endsection