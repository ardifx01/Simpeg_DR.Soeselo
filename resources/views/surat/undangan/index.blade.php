@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Surat Undangan</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat Undangan</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="row mt-4">
    {{-- Toolbar + Search --}}
    <form method="GET" action="{{ route('undangan.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('undangan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Undangan
            </a>
        </div>

        <div class="col-12 col-md-5">
            <div class="input-group">
                <input type="search" name="search" id="search" class="form-control" value="{{ $search ?? request('search') }}"placeholder="Cari nomor, hal, tujuan (Yth), alamat, tempat, acara...">
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
                    <th>Nomor / Sifat</th>
                    <th>Tanggal Surat</th>
                    <th>Tujuan (Yth)</th>
                    <th>Hal</th>
                    <th>Detail Acara</th>
                    <th>Penandatangan</th>
                    <th style="width:140px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($undangan as $item)
                    @php
                        $tglSurat = $item->tanggal_surat
                            ? \Carbon\Carbon::parse($item->tanggal_surat)->locale('id')->translatedFormat('d F Y')
                            : '-';

                        $tglAcara = $item->tanggal_acara
                            ? \Carbon\Carbon::parse($item->tanggal_acara)->locale('id')->translatedFormat('d F Y')
                            : '-';

                        $tembusanCount = is_array($item->tembusan) ? count($item->tembusan) : 0;

                        $halRingkas = \Illuminate\Support\Str::limit($item->hal ?? '-', 80);
                        $acaraRingkas = \Illuminate\Support\Str::limit($item->acara ?? '-', 80);

                        $penNama = optional($item->penandatangan)->nama_lengkap
                                    ?? optional($item->penandatangan)->nama
                                    ?? 'N/A';
                        $penNip  = optional($item->penandatangan)->nip ?? '-';
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration + $undangan->firstItem() - 1 }}</td>

                        <td class="text-start">
                            {{ $item->nomor ?? '-' }}<br>
                            <small class="text-muted">
                                Sifat: {{ $item->sifat ?: '-' }} • Lampiran: {{ $item->lampiran ?: '-' }}
                            </small>
                        </td>

                        <td class="text-start">{{ $item->tempat_surat ?? '-' }}<br><small class="text-muted">{{ $tglSurat }}</small></td>

                        <td class="text-start">
                            {{ $item->yth ?? '-' }}<br>
                            <small class="text-muted">{{ $item->alamat ?: '-' }}</small>
                            @if($tembusanCount > 0)
                                <div><span class="badge bg-secondary mt-1">Tembusan: {{ $tembusanCount }}</span></div>
                            @endif
                        </td>

                        <td class="text-start">{{ $halRingkas }}</td>

                        <td class="text-start">
                            <div><strong>Hari/Tgl:</strong> {{ ($item->hari ?: '-') }}, {{ $tglAcara }}</div>
                            <div><strong>Waktu:</strong> {{ $item->waktu ?? '-' }}</div>
                            <div><strong>Tempat:</strong> {{ $item->tempat ?? '-' }}</div>
                            <div><strong>Acara:</strong> {{ $acaraRingkas }}</div>
                        </td>

                        <td class="text-start">
                            {{ $penNama }}<br>
                            <small class="text-muted">NIP: {{ $penNip }}</small><br>
                            <small class="text-muted">
                                {{ optional(optional($item->penandatangan)->jabatan)->nama_jabatan ?? '-' }}
                            </small>
                        </td>

                        <td>
                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                <a href="{{ route('undangan.export', $item->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-file-word"></i> Export
                                </a>
                                <form action="{{ route('undangan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus surat ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data undangan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    {{ $undangan->appends(request()->query())->links() }}
</section>

@endsection