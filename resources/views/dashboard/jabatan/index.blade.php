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
                <div class="d-flex justify-content-between row">
                    <div class="col-sm-2 col-md-8 col-lg-6">
                        <div class="row mb-3 form-group">
                            <form method="GET" action="{{ route('jabatan.index') }}" class="d-flex align-items-center">
                                <label for="per_page" class="me-2">Show:</label>
                                <select name="per_page" class="form-select w-auto me-3" onchange="this.form.submit()">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <label for="per_page" class="me-2">Entries</label>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-3 col-lg-2">
                        <form action="{{ route('jabatan.index') }}" method="GET">
                            <div class="row mb-3 form-group">
                                <label type="text" id="search" name="search" for="search" class="col-sm-1 col-md-3 col-lg-3 col-form-label">search: </label>
                                <div class="col-sm-1 col-md-8 col-lg-9">
                                    <input type="search" class="form-control" name="search" id="search" value="{{ request('search') }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive small">
                    <table class="table table-striped table-bordered table-hover table-sm">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Pegawai</th>
                                <th>Unit Kerja</th>
                                <th>Pangkat</th>
                                <th>Jenis jabatan</th>
                                <th>Jenis Kepegawaian</th>
                                <th>TMT</th>
                                <th>Eselon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jabatans as $key => $jabatan)
                            <tr>
                                <td class="text-center">{{ $jabatans->firstItem() + $key }}</td>
                                <td>{{ $jabatan->pegawai->nama }}</td>
                                <td>{{ $jabatan->unit_kerja }}</td>
                                <td>{{ $jabatan->nama }}</td>
                                <td>{{ $jabatan->jenis_jabatan }}</td>
                                <td>{{ $jabatan->jenis_kepegawaian }}</td>
                                <td>{{ $jabatan->tmt }}</td>
                                <td>{{ $jabatan->eselon }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('pegawai.show', $jabatan->pegawai->id) }}" class="btn btn-success btn-sm" title="Detial"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('jabatan.edit',['jabatan' => $jabatan->id]) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil-square"></i></a>
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