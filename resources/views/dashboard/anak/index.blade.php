@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Riwayat | <small>Anak</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Anak</li>
                        </ol>
                    </nav>
                </div>
                <div class="col">
                    <div class="text-end">
                        <a href="{{ route('anak.create') }}"><button type="button" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah Anak</button></a>
                    </div>
                </div>
            </div>
        </div><!-- End Anak Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Anak view -->
            <div class="view">
                <div class="d-flex justify-content-between row">
                    <div class="col-sm-2 col-md-8 col-lg-6">
                        <div class="row mb-3 form-group">
                            <form method="GET" action="{{ route('anak.index') }}" class="d-flex align-items-center">
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
                        <form action="{{ route('anak.index') }}" method="GET">
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
                                <th>Nama Anak</th>
                                <th>TTL</th>
                                <th>Status keluarga</th>
                                <th>Status Tunjangan</th>
                                <th>Jenis Kelamin</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anaks as $key => $anak)
                            <tr>
                                <td>{{ $anaks->firstItem() + $key }}</td>
                                <td>
                                    {{ $anak->pegawai->nip }} - {{ $anak->pegawai->nama }}
                                </td>
                                <td>{{ $anak->nama }}</td>
                                <td>{{ $anak->tempat_lahir }}<br>{{ $anak->tanggal_lahir }}</td>
                                <td>{{ $anak->status_keluarga }}</td>
                                <td>{{ $anak->status_tunjangan }}</td>
                                <td>{{ $anak->jenis_kelamin }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('pegawai.show', $anak->pegawai->id) }}" class="btn btn-success btn-sm" title="Detial"><i class="bi bi-eye"></i></a>
                                    </div>
                                </td>
                            </tr>                                
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    {{ $anaks->appends(request()->query())->links() }}
                </div>            
            </div><!-- End Anak view -->
        </div>
        </section>

@endsection