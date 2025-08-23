{{-- resources/views/surat/pengantar/create.blade.php --}}
@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <h1 class="h2 fw-bold text-primary">Tambah Surat Pengantar</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengantar.index') }}">Surat Pengantar</a></li>
            <li class="breadcrumb-item active">Tambah Surat Pengantar</li>
        </ol>
    </nav>
</div>

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form Pengajuan Surat Pengantar</h4>
                </div>
                <div class="card-body p-4">
                <form action="{{ route('pengantar.store') }}" method="POST" class="card shadow-sm p-4">
                    @csrf

                    {{-- DETAIL SURAT --}}
                    <h5 class="fw-bold mb-3">Detail Surat</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nomor_surat" class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat') }}" placeholder="Contoh: 800/123/IV" required>
                            @error('nomor_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('tanggal_surat') is-invalid @enderror" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat') }}" autocomplete="off" required>
                                <button class="btn btn-outline-secondary" type="button"
                                        id="btn_tanggal_surat" for="tanggal_surat">
                                    <i class="bi bi-calendar3"></i>
                                </button>
                            </div>
                            @error('tanggal_surat') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="tujuan" class="form-label">Tujuan (Yth.)</label>
                            <input type="text" class="form-control @error('tujuan') is-invalid @enderror" id="tujuan" name="tujuan" value="{{ old('tujuan') }}">
                            @error('tujuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="alamat_tujuan" class="form-label">Alamat Tujuan</label>
                            <textarea class="form-control @error('alamat_tujuan') is-invalid @enderror" id="alamat_tujuan" name="alamat_tujuan" rows="2">{{ old('alamat_tujuan') }}</textarea>
                            @error('alamat_tujuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- PENERIMA & PENGIRIM --}}
                    <h5 class="fw-bold mb-3">Penerima & Pengirim</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="penerima_id" class="form-label">Penerima</label>
                            <select class="form-select @error('penerima_id') is-invalid @enderror" name="penerima_id" id="penerima_id" required>
                                <option value="" {{ old('penerima_id') ? '' : 'selected' }}>-- Pilih Pegawai --</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('penerima_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap ?? $pegawai->nama }}</option>
                                @endforeach
                            </select>
                            @error('penerima_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="pengirim_id" class="form-label">Pengirim</label>
                            <select class="form-select @error('pengirim_id') is-invalid @enderror" name="pengirim_id" id="pengirim_id" required>
                                <option value="" {{ old('pengirim_id') ? '' : 'selected' }}>-- Pilih Pegawai --</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('pengirim_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap ?? $pegawai->nama }}</option>
                                @endforeach
                            </select>
                            @error('pengirim_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- DAFTAR ITEM --}}
                    <h5 class="fw-bold mb-3">Daftar Item / Naskah</h5>
                    @php
                        $oldItems = old('daftar_item');
                        $rows = [];
                        if (is_array($oldItems)) {
                            foreach ($oldItems as $r) {
                                $rows[] = [
                                'naskah'     => $r['naskah']     ?? '',
                                'banyaknya'  => $r['banyaknya']  ?? '',
                                'keterangan' => $r['keterangan'] ?? '',
                                ];
                            }
                        }
                        if (empty($rows)) { $rows = [['naskah'=>'','banyaknya'=>'','keterangan'=>'']]; }
                    @endphp

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="table-items">
                            <thead class="table-light">
                                <tr class="text-center">
                                <th style="width:60px">No</th>
                                <th>Naskah</th>
                                <th style="width:160px">Banyaknya</th>
                                <th style="width:240px">Keterangan</th>
                                <th style="width:60px"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody-items">
                            @foreach($rows as $i => $r)
                                <tr class="item-row">
                                <td class="text-center fw-semibold align-middle no-col">{{ $i+1 }}</td>
                                <td>
                                    <input type="text" name="daftar_item[{{ $i }}][naskah]"
                                        class="form-control @error('daftar_item.'.$i.'.naskah') is-invalid @enderror"
                                        value="{{ $r['naskah'] }}" placeholder="Uraian naskah/barang">
                                    @error('daftar_item.'.$i.'.naskah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </td>
                                <td>
                                    <input type="text" name="daftar_item[{{ $i }}][banyaknya]"
                                        class="form-control @error('daftar_item.'.$i.'.banyaknya') is-invalid @enderror"
                                        value="{{ $r['banyaknya'] }}" placeholder="Jumlah / satuan">
                                    @error('daftar_item.'.$i.'.banyaknya') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </td>
                                <td>
                                    <input type="text" name="daftar_item[{{ $i }}][keterangan]"
                                        class="form-control @error('daftar_item.'.$i.'.keterangan') is-invalid @enderror"
                                        value="{{ $r['keterangan'] }}" placeholder="Catatan (opsional)">
                                    @error('daftar_item.'.$i.'.keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-row" title="Hapus">
                                    <i class="bi bi-x"></i>
                                    </button>
                                </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-row">
                        <i class="bi bi-plus-lg"></i> Tambah Baris
                    </button>
                    @error('daftar_item') <div class="text-danger small mt-1">{{ $message }}</div> @enderror

                    <div class="mt-4 d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Surat Pengantar
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Template baris (untuk JS clone) --}}
<template id="row-template">
    <tr class="item-row">
        <td class="text-center fw-semibold align-middle no-col">__NO__</td>
        <td>
            <input type="text" name="daftar_item[__IDX__][naskah]" class="form-control" placeholder="Uraian naskah/barang">
        </td>
        <td>
            <input type="text" name="daftar_item[__IDX__][banyaknya]" class="form-control" placeholder="Jumlah / satuan">
        </td>
        <td>
            <input type="text" name="daftar_item[__IDX__][keterangan]" class="form-control" placeholder="Catatan (opsional)">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-outline-danger btn-sm remove-row" title="Hapus">
            <i class="bi bi-x"></i>
            </button>
        </td>
    </tr>
</template>

<script>
(function(){
    const tbody = document.getElementById('tbody-items');
    const tpl   = document.getElementById('row-template').innerHTML;
    const addBtn= document.getElementById('btn-add-row');

    function renumber(){
        // nomor + reindex name agar urut 0..n
        [...tbody.querySelectorAll('tr.item-row')].forEach((tr, i)=>{
        tr.querySelector('.no-col').textContent = i+1;
        tr.querySelectorAll('input[name^="daftar_item["]').forEach(inp=>{
            const field = inp.name.match(/\[(naskah|banyaknya|keterangan)\]/)[1];
            inp.name = `daftar_item[${i}][${field}]`;
        });
        });
    }

    addBtn.addEventListener('click', ()=>{
        const idx = tbody.querySelectorAll('tr.item-row').length;
        const html = tpl.replaceAll('__NO__', idx+1).replaceAll('__IDX__', idx);
        tbody.insertAdjacentHTML('beforeend', html);
    });

    document.addEventListener('click', (e)=>{
        const btn = e.target.closest('.remove-row');
        if (!btn) return;
        const row = btn.closest('tr.item-row');
        row.remove();
        if (tbody.querySelectorAll('tr.item-row').length === 0) {
        // kalau semua terhapus, tambah 1 baris kosong
        const html = tpl.replaceAll('__NO__', 1).replaceAll('__IDX__', 0);
        tbody.insertAdjacentHTML('beforeend', html);
        }
        renumber();
    });
})();
</script>

@endsection