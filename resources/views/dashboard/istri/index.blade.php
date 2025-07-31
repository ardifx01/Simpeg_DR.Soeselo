@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Riwayat | <small>Suami / Istri</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Suami / Istri</li>
                        </ol>
                    </nav>
                </div>
                <div class="col">
                    <div class="text-end">
                        <a href="{{ route('istri.create') }}"><button type="button" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah istri</button></a>
                    </div>
                </div>
            </div>
        </div><!-- End Istri Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Istri view -->
            <div class="view">
                <div class="d-flex justify-content-between row">
                    <div class="col-sm-2 col-md-8 col-lg-6">
                        <div class="row mb-3 form-group">
                            <form method="GET" action="{{ route('istri.index') }}" class="d-flex align-items-center">
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
                        <form action="{{ route('istri.index') }}" method="GET">
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
                    <table class="table table-bordered table-striped table-hover align-middle text-center">
                        <thead>
                            <tr class="text-center align-middle">
                                <th style="width: 50px;">No</th>
                                <th>Pegawai</th>
                                <th>Nama Suami/Istri</th>
                                <th>TTL</th>
                                <th>Profesi</th>
                                <th>Tanggal Nikah</th>
                                <th>Status</th>
                                <th style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($istris as $key => $istri)
                            <tr>
                                <td class="text-center">{{ $istris->firstItem() + $key }}</td>
                                <td>
                                    {{ $istri->pegawai->nip }} - {{ $istri->pegawai->nama_lengkap }}
                                </td>
                                <td>{{ $istri->nama }}</td>
                                <td>{{ $istri->tempat_lahir }}, {{ \Carbon\Carbon::parse($istri->tanggal_lahir_istri)->translatedFormat('d F Y') }}</td>
                                <td>{{ $istri->profesi }}</td>
                                <td>{{ \Carbon\Carbon::parse($istri->tanggal_nikah)->translatedFormat('d F Y') }}</td>
                                <td>{{ $istri->status_hubungan }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                    <a href="{{ route('pegawai.show', $istri->pegawai->id) }}" onclick="localStorage.setItem('activePegawaiTab', '#suami-istri')" class="btn btn-success btn-sm" title="Detail"><i class="bi bi-eye"></i> Detail</a>
                                    </div>
                                </td>
                            </tr>                                
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    {{ $istris->appends(request()->query())->links() }}
                </div>
            </div><!-- End Istri view -->
        </div>
        </section>

@endsection