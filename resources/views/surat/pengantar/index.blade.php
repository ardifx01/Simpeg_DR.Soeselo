@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat Pengantar</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat Pengantar</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="row mt-4">
    {{-- Toolbar + Search --}}
    <form method="GET" action="{{ route('pengantar.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('pengantar.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Surat Pengantar
            </a>
        </div>

        <div class="col-12 col-md-5">
            <div class="input-group">
                <input
                    type="search"
                    name="search"
                    id="search"
                    class="form-control"
                    value="{{ $search ?? request('search') }}"
                    placeholder="Cari nomor, tujuan, penerima/pengirim (nama/NIP)...">
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
                    <th>Nomor / Tanggal Surat</th>
                    <th>Tujuan</th>
                    <th>Penerima</th>
                    <th>Pengirim</th>
                    <th>Jumlah Item</th>
                    <th style="width: 140px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengantars as $item)
                    <tr>
                        <td class="text-center"> {{ $loop->iteration + $pengantars->firstItem() - 1 }} </td>
                        <td class="text-start">
                            <div>{{ $item->nomor_surat ?? '-' }}</div>
                            <small class="text-muted">
                                @php
                                    $tgl = $item->tanggal_surat
                                        ? \Carbon\Carbon::parse($item->tanggal_surat)->locale('id')->translatedFormat('d F Y')
                                        : '-';
                                @endphp
                                {{ $tgl }}
                            </small>
                        </td>
                        <td class="text-start">
                            <div>{{ \Illuminate\Support\Str::limit($item->tujuan ?? '-', 60) }}</div>
                            <small class="text-muted d-block">
                                {{ \Illuminate\Support\Str::limit($item->alamat_tujuan ?? '-', 80) }}
                            </small>
                        </td>
                        <td class="text-start"> {{ optional($item->penerima)->nama_lengkap ?? optional($item->penerima)->nama ?? 'N/A' }}<br> <small class="text-muted">NIP: {{ optional($item->penerima)->nip ?? '-' }}</small> </td>
                        <td class="text-start"> {{ optional($item->pengirim)->nama_lengkap ?? optional($item->pengirim)->nama ?? 'N/A' }}<br> <small class="text-muted">NIP: {{ optional($item->pengirim)->nip ?? '-' }}</small> </td>
                        <td> {{ is_array($item->daftar_item) ? count($item->daftar_item) : 0 }} </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                <a href="{{ route('pengantar.export', $item->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-file-word"></i> Export
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data surat pengantar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    {{ $pengantars->appends(request()->query())->links() }}
</section>

@endsection