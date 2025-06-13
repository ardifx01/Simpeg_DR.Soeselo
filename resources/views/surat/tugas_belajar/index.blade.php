@extends('surat.layouts.main')

@section('main')

<div class="pagetitle">
    <div class="pagetitle">
    <div class="row justify-content-between">
        <div class="col">
            <h1>Daftar Surat Tugas Belajar</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat TugasB elajar</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Pengajuan Surat Tugas Belajar Title -->

<section class="row mt-4">
    <form method="GET" action="{{ route('tugas_belajar.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('tugas_belajar.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pengajuan
            </a>
        </div>
        <div style="min-width: 250px;">
            <div class="input-group">
                <input type="search" name="search" id="search" class="form-control" value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i> search
                </button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>Program</th>
                <th>Lembaga</th>
                <th>Fakultas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tugasbelajars as $tugasbelajar)
            <tr>
                <td>{{ $tugasbelajar->pegawai->nama }}</td>
                <td>{{ $tugasbelajar->pegawai->nip }}</td>
                <td>{{ $tugasbelajar->pegawai->jabatan->nama ?? '-' }}</td>
                <td>{{ $tugasbelajar->program }}</td>
                <td>{{ $tugasbelajar->lembaga }}</td>
                <td>{{ $tugasbelajar->fakultas }}</td>
                <td>
                    <a href="{{ route('tugas_belajar.export', $tugasbelajar->id) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-word"></i> Export
                    </a>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data tugas belajar yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Pagination -->
    {{ $tugasbelajars->appends(request()->query())->links() }}
</section>

@endsection