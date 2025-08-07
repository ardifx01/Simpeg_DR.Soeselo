@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Riwayat | <small>Jabatan</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Jabatan</li>
                        </ol>
                    </nav>
                </div>
                <div class="col">
                    <div class="text-end">
                        <a href="{{ route('jabatan.create') }}"><button type="button" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah Jabatan</button></a>
                    </div>
                </div>
            </div>
        </div><!-- End Jabatan Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Jabatan view -->
            <div class="view">
                <div class="row align-items-center mb-3">
                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-center mb-3 mb-md-0">
                        <form method="GET" action="{{ route('jabatan.index') }}" class="d-flex align-items-center">
                            <label for="per_page" class="me-2 text-nowrap">Show:</label>
                            <select name="per_page" id="per_page" class="form-select w-auto me-2" onchange="this.form.submit()">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <label class="text-nowrap">Entries</label>
                            @if (request()->has('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                        </form>
                    </div>
                    
                    <div class="col-12 col-md-6 col-lg-4 offset-lg-4">
                        <form action="{{ route('jabatan.index') }}" method="GET">
                            @if (request()->has('per_page'))
                                <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                            @endif
                            <div class="input-group">
                                <input type="search" name="search" id="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="bi bi-search"></i> search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive small">
                    <table class="table table-bordered table-striped table-hover align-middle text-center">
                        <thead>
                            <tr class="text-center align-middle">
                                <th style="width: 50px;">No</th>
                                <th>Pegawai</th>
                                <th>Jabatan</th>
                                <th>Pangkat</th>
                                <th>Jenis jabatan</th>
                                <th>Jenis Kepegawaian</th>
                                <th>TMT</th>
                                <th>Eselon</th>
                                <th style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jabatans as $key => $jabatan)
                            <tr>
                                <td class="text-center">{{ $jabatans->firstItem() + $key }}</td>
                                <td>{{ $jabatan->pegawai->nip }} - {{ $jabatan->pegawai->nama_lengkap }}</td>
                                <td>{{ $jabatan->nama_jabatan }}</td>
                                <td>{{ $jabatan->pangkat }}</td>
                                <td>{{ $jabatan->jenis_jabatan }}</td>
                                <td>{{ $jabatan->jenis_kepegawaian }}</td>
                                <td>{{ $jabatan->tmt_golongan_ruang }}</td>
                                <td>{{ $jabatan->eselon }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('pegawai.show', $jabatan->pegawai->id) }}" onclick="localStorage.setItem('activePegawaiTab', '#jabatan')" class="btn btn-success btn-sm" title="Detail"><i class="bi bi-eye"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal{{$jabatan->id}}">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="exampleModal{{$jabatan->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus jabatan</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah anda yakin akan menghapus data {{$jabatan->nama}}
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('jabatan.destroy',['jabatan' => $jabatan->id]) }}" method="POST" style="display:inline;">
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
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    {{ $jabatans->appends(request()->query())->links() }}
                </div>
            </div><!-- End Jabatan view -->
        </div>
        </section>

@endsection