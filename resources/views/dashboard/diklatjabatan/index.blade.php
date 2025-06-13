@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Riwayat | <small>Diklat Jabatan</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Diklat Jabatan</li>
                        </ol>
                    </nav>
                </div>
                <div class="col">
                    <div class="text-end">
                        <a href="{{ route('diklatjabatan.create') }}"><button type="button" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah Diklat Jabatan</button></a>
                    </div>
                </div>
            </div>
        </div><!-- End Diklat Jabatan Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Diklat Jabatan view -->
            <div class="view">
                <div class="d-flex justify-content-between row">
                    <div class="col-sm-2 col-md-8 col-lg-6">
                        <div class="row mb-3 form-group">
                            <form method="GET" action="{{ route('diklatjabatan.index') }}" class="d-flex align-items-center">
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
                        <form action="{{ route('diklatjabatan.index') }}" method="GET">
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
                            <tr>
                                <th>No</th>
                                <th>Pegawai</th>
                                <th>Nama</th>
                                <th>Penyelenggara</th>
                                <th>Jumlah Jam</th>
                                <th>Tanggal Selesai</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($diklatjabatans as $key => $diklatjabatan)
                            <tr>
                                <td>{{ $diklatjabatans->firstItem() + $key }}</td>
                                <td>
                                    {{ $diklatjabatan->pegawai->nip }} - {{ $diklatjabatan->pegawai->nama }}
                                </td>
                                <td>{{ $diklatjabatan->nama }}</td>
                                <td>{{ $diklatjabatan->penyelenggara }}</td>
                                <td>{{ $diklatjabatan->jumlah_jam }}</td>
                                <td>{{ $diklatjabatan->tanggal_selesai }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('pegawai.show', $diklatjabatan->pegawai->id) }}" class="btn btn-success btn-sm" title="Detial"><i class="bi bi-eye"></i></a>
                                    </div>
                                </td>
                            </tr>                                
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    {{ $diklatjabatans->appends(request()->query())->links() }}
                </div>
            </div><!-- End Diklat Jabatan view -->
        </div>
        </section>

@endsection