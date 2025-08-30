@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat Perjalanan Dinas (SPD)</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar SPD</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="row mt-4">
    <form method="GET" action="{{ route('perjalanan_dinas.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('perjalanan_dinas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah SPD
            </a>
        </div>

        <div class="col-12 col-md-5">
            <div class="input-group">
                <input type="search" name="search" id="search" class="form-control" value="{{ $search ?? request('search') }}" placeholder="Cari nomor, pegawai/KPA (nama/NIP), tujuan, alat angkut...">
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
                    <th>Pegawai</th>
                    <th>KPA</th>
                    <th>Tanggal</th>
                    <th>Tujuan</th>
                    <th>Alat / Biaya</th>
                    <th>Lama</th>
                    <th>Pengikut</th>
                    <th style="width:170px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($perjalanan as $item)
                    @php
                        $tglBerangkat = $item->tanggal_berangkat
                            ? \Carbon\Carbon::parse($item->tanggal_berangkat)->locale('id')->translatedFormat('d F Y') : '-';
                        $tglKembali = $item->tanggal_kembali
                            ? \Carbon\Carbon::parse($item->tanggal_kembali)->locale('id')->translatedFormat('d F Y') : '-';
                        $pengikutCount = is_array($item->pengikut) ? count($item->pengikut) : (is_countable($item->pengikut ?? []) ? count($item->pengikut) : 0);
                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $perjalanan->firstItem() - 1 }}</td>
                        <td class="text-start">
                            {{ $item->nomor ?? '-' }}<br>
                            <small class="text-muted">
                                Lembar: {{ $item->lembar_ke ?? '-' }} · Kode/No: {{ $item->kode_no ?? '-' }}
                            </small>
                        </td>
                        <td class="text-start">
                            {{ optional($item->pegawai)->nama_lengkap ?? optional($item->pegawai)->nama ?? 'N/A' }}<br>
                            <small class="text-muted">NIP: {{ optional($item->pegawai)->nip ?? '-' }}</small>
                        </td>
                        <td class="text-start">
                            {{ optional($item->kuasaPenggunaAnggaran)->nama_lengkap ?? optional($item->kuasaPenggunaAnggaran)->nama ?? 'N/A' }}<br>
                            <small class="text-muted">NIP: {{ optional($item->kuasaPenggunaAnggaran)->nip ?? '-' }}</small>
                        </td>
                        <td class="text-start">
                            <div>{{ $tglBerangkat }} → {{ $tglKembali }}</div>
                            <small class="text-muted">Dikeluarkan: {{ $item->tanggal_dikeluarkan ? \Carbon\Carbon::parse($item->tanggal_dikeluarkan)->locale('id')->translatedFormat('d F Y') : '-' }}</small>
                        </td>
                        <td class="text-start">{{ $item->tempat_tujuan ?? '-' }}</td>
                        <td class="text-start">
                            {{ $item->alat_angkut ?? '-' }}<br>
                            <small class="text-muted">Biaya: {{ $item->tingkat_biaya ?? '-' }}</small>
                        </td>
                        <td class="text-center">{{ $item->lama_perjalanan ?? 0 }} hari</td>
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $pengikutCount }}</span>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                <a href="{{ route('perjalanan_dinas.export', $item->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-file-word"></i> Export
                                </a>
                                <form action="{{ route('perjalanan_dinas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data SPD.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    {{ $perjalanan->appends(request()->query())->links() }}
</section>

@endsection