@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Sasaran Kerja</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item">Daftar Sasaran Kerja</li>
                </ol>
            </nav>
        </div>
        <div class="col-auto">
            <a href="{{ route('skp.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah SKP</a>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        {{-- Form Pencarian  --}}
        <div class="row justify-content-end mb-4">
            <div class="col-12 col-md-6 col-lg-4">
                <form action="{{ route('skp.index') }}" method="GET">
                    <div class="input-group">
                        <input type="search" name="search" id="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bi bi-search"></i> search
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle text-center">
                <thead>
                    <tr class="text-center align-middle">
                        <th style="width: 50px;">No</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Pegawai yang Dinilai</th>
                        <th scope="col">Pegawai Penilai</th>
                        <th scope="col">Nilai Akhir</th>
                        <th scope="col">Kategori</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($skpHeaders as $index => $skp)
                        <tr>
                            <td>{{ $skpHeaders->firstItem() + $index }}</td>
                            <td>{{ $skp->tahun }}</td>
                            <td>{{ $skp->pegawaiDinilai->nama ?? 'N/A' }}</td>
                            <td>{{ $skp->pegawaiPenilai->nama ?? 'N/A' }}</td>
                            <td>{{ number_format($skp->nilai_akhir, 2) ?? 'N/A' }}</td>
                            <td>
                                @php
                                    $kategoriClass = 'danger';
                                    if ($skp->kategori == 'Sangat Baik') {
                                        $kategoriClass = 'success';
                                    } elseif ($skp->kategori == 'Baik') {
                                        $kategoriClass = 'info';
                                    } elseif ($skp->kategori == 'Cukup') {
                                        $kategoriClass = 'warning';
                                    }
                                @endphp
                                <span class="badge bg-{{ $kategoriClass }}">
                                    {{ $skp->kategori ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('skp.show', $skp->id) }}" class="btn btn-info btn-sm text-white" title="Lihat"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('skp.edit', $skp->id) }}" class="btn btn-warning btn-sm text-white" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('skp.destroy', $skp->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data SKP yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- Pagination -->
            {{ $skpHeaders->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@endsection
