@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Pegawai | <small>Data Pegawai</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pegawai</li>
                        </ol>
                    </nav>
                </div>
                <div class="col">
                    <div class="text-end">
                        <a href="{{ route('pegawai.create') }}"><button type="button" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah Pegawai</button></a>
                    </div>
                </div>
            </div>
        </div><!-- End Pegawai Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Pegawai view -->
            <div class="view">
                <div class="row mb-3">
                    <form method="GET" action="{{ route('pegawai.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2">
                        <!-- Show Entries -->
                        <div class="d-flex align-items-center">
                            <label for="per_page" class="me-2 mb-0">Show:</label>
                            <select name="per_page" id="per_page" class="form-select" style="width: 80px;" onchange="this.form.submit()">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <span class="ms-2">Entries</span>
                        </div>
                
                        <!-- Jenis Kepegawaian -->
                        <div style="min-width: 180px;">
                            <select name="jenis_kepegawaian" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Pilihan --</option>
                                @foreach($jeniskepegawaianList as $jenis)
                                    <option value="{{ $jenis }}" {{ request('jenis_kepegawaian') == $jenis ? 'selected' : '' }}>
                                        {{ $jenis }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Unit Kerja -->
                        <div style="min-width: 250px;">
                            <select name="unit_kerja" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Pilihan --</option>
                                @foreach($unitkerjaList as $unit)
                                    <option value="{{ $unit }}" {{ request('unit_kerja') == $unit ? 'selected' : '' }}>
                                        {{ $unit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                
                        <!-- Search -->
                        <div style="min-width: 250px;">
                            <div class="input-group">
                                <input type="search" name="search" id="search" class="form-control" value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="bi bi-search"></i> search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive small">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr class="text-center align-middle">
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama Lengkap</th>
                                <th>NIP <br> NIP Lama</th>
                                <th>Jenis Kelamin <br> Tempat Tanggal Lahir</th>
                                <th>Golongan <br> Jenis Kepegawaian</th>
                                <th>Jabatan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($pegawais->isEmpty())
                                <tr>
                                    <td colspan="999" class="text-center text-muted">Data pegawai tidak ada yang cocok.</td>
                                </tr>
                            @else
                                @foreach ($pegawais as $index => $pegawai)
                                <tr>
                                    <td class="text-center">{{ $pegawais->firstItem() + $index }}</td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                            @if($pegawai->image)
                                                <img src="{{ asset('storage/' . $pegawai->image) }}" alt="photo-profile" class="rounded" height="64px">
                                            @else
                                                <img src="{{ asset('assets/img/nophoto.jpg') }}" alt="photo-profile" class="rounded" height="64px">
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $pegawai->gelar_depan }} {{ $pegawai->nama }}, {{ $pegawai->gelar_belakang }}</td>
                                    <td>{{ $pegawai->nip }}</td>
                                    <td>{{ $pegawai->jenis_kelamin }}<br>{{ $pegawai->tempat_lahir }}<br>{{ $pegawai->tanggal_lahir }}</td>
                                    <td>{{ $pegawai->golongan_ruang ?? '-' }}<br>{{ $pegawai->jabatan->jenis_kepegawaian ?? '-' }}</td>
                                    <td>{{ $pegawai->jabatan->nama ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                        <a href="{{ route('pegawai.show',['pegawai' => $pegawai->id]) }}" class="btn btn-success btn-sm" title="Detial"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('pegawai.edit',['pegawai' => $pegawai->id]) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal{{$pegawai->id}}">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{$pegawai->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Pegawai</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah anda yakin akan menghapus data {{$pegawai->nama}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('pegawai.destroy',['pegawai' => $pegawai->id]) }}" method="POST" style="display:inline;">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Delete</button>
                                                        </form>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-90deg-left"></i> Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    {{ $pegawais->appends(request()->query())->links() }}
                </div>
            </div><!-- End Pegawai view -->
        </div>
        </section>

@endsection