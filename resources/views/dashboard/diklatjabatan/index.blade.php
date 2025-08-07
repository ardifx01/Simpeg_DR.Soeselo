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
                <div class="row align-items-center mb-3">
                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-center mb-3 mb-md-0">
                        <form method="GET" action="{{ route('diklatjabatan.index') }}" class="d-flex align-items-center">
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
                        <form action="{{ route('diklatjabatan.index') }}" method="GET">
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
                                <th>Nama</th>
                                <th>Penyelenggara</th>
                                <th>Jumlah Jam</th>
                                <th>Tanggal Selesai</th>
                                <th style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($diklatjabatans as $key => $diklatjabatan)
                            <tr>
                                <td class="text-center">{{ $diklatjabatans->firstItem() + $key }}</td>
                                <td>
                                    {{ $diklatjabatan->pegawai->nip }} - {{ $diklatjabatan->pegawai->nama_lengkap }}
                                </td>
                                <td>{{ $diklatjabatan->nama }}</td>
                                <td>{{ $diklatjabatan->penyelenggara }}</td>
                                <td>{{ $diklatjabatan->jumlah_jam }}</td>
                                <td>{{ \Carbon\Carbon::parse($diklatjabatan->tanggal_selesai)->translatedFormat('d F Y') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('pegawai.show', $diklatjabatan->pegawai->id) }}" onclick="localStorage.setItem('activePegawaiTab', '#diklat')" class="btn btn-success btn-sm" title="Detail"><i class="bi bi-eye"></i> Detail</a>
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