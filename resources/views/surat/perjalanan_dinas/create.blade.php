@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <h1 class="h2 fw-bold text-primary">Tambah Surat Perjalanan Dinas (SPD)</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
            <li class="breadcrumb-item"><a href="{{ route('perjalanan_dinas.index') }}">Daftar SPD</a></li>
            <li class="breadcrumb-item active">Tambah SPD</li>
        </ol>
    </nav>
</div>

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form Pengajuan Perjalanan Dinas</h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('perjalanan_dinas.store') }}" method="POST" class="card shadow-sm p-4">
                        @csrf

                        {{-- DETAIL SPD --}}
                        <h5 class="fw-bold mb-3">Detail SPD</h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="lembar_ke" class="form-label">Lembar Ke</label>
                                <input type="text" class="form-control @error('lembar_ke') is-invalid @enderror" id="lembar_ke" name="lembar_ke" value="{{ old('lembar_ke') }}">
                                @error('lembar_ke') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="kode_no" class="form-label">Kode/No</label>
                                <input type="text" class="form-control @error('kode_no') is-invalid @enderror" id="kode_no" name="kode_no" value="{{ old('kode_no') }}">
                                @error('kode_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nomor" class="form-label">Nomor SPD</label>
                                <input type="text" class="form-control @error('nomor') is-invalid @enderror" id="nomor" name="nomor" value="{{ old('nomor') }}" placeholder="Contoh: 090/123/SPD/2025" required>
                                @error('nomor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- PEJABAT & PEGAWAI --}}
                        <h5 class="fw-bold mb-3">Pejabat & Pegawai</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="kuasa_pengguna_anggaran_id" class="form-label">Kuasa Pengguna Anggaran (KPA)</label>
                                <select name="kuasa_pengguna_anggaran_id" id="kuasa_pengguna_anggaran_id" class="form-select @error('kuasa_pengguna_anggaran_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Pegawai --</option>
                                    @foreach($pegawais as $p)
                                        <option value="{{ $p->id }}" {{ old('kuasa_pengguna_anggaran_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap ?? $p->nama }} - {{ $p->nip }}</option>
                                    @endforeach
                                </select>
                                @error('kuasa_pengguna_anggaran_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="pegawai_id" class="form-label">Pegawai Yang Melaksanakan</label>
                                <select name="pegawai_id" id="pegawai_id" class="form-select @error('pegawai_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Pegawai --</option>
                                    @foreach($pegawais as $p)
                                        <option value="{{ $p->id }}" {{ old('pegawai_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap ?? $p->nama }} - {{ $p->nip }}</option>
                                    @endforeach
                                </select>
                                @error('pegawai_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- RINCIAN PERJALANAN --}}
                        <h5 class="fw-bold mb-3">Rincian Perjalanan</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="tingkat_biaya" class="form-label">Tingkat Biaya</label>
                                <input type="text" class="form-control @error('tingkat_biaya') is-invalid @enderror" id="tingkat_biaya" name="tingkat_biaya" value="{{ old('tingkat_biaya') }}" required>
                                @error('tingkat_biaya') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="alat_angkut" class="form-label">Alat Angkut</label>
                                <input type="text" class="form-control @error('alat_angkut') is-invalid @enderror" id="alat_angkut" name="alat_angkut" value="{{ old('alat_angkut') }}" required>
                                @error('alat_angkut') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="lama_perjalanan" class="form-label">Lama Perjalanan (hari)</label>
                                <input type="number" min="0" class="form-control @error('lama_perjalanan') is-invalid @enderror" id="lama_perjalanan" name="lama_perjalanan" value="{{ old('lama_perjalanan') }}" required>
                                @error('lama_perjalanan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tempat_berangkat" class="form-label">Tempat Berangkat</label>
                                <input type="text" class="form-control @error('tempat_berangkat') is-invalid @enderror" id="tempat_berangkat" name="tempat_berangkat" value="{{ old('tempat_berangkat') }}" required>
                                @error('tempat_berangkat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="tempat_tujuan" class="form-label">Tempat Tujuan</label>
                                <input type="text" class="form-control @error('tempat_tujuan') is-invalid @enderror" id="tempat_tujuan" name="tempat_tujuan" value="{{ old('tempat_tujuan') }}" required>
                                @error('tempat_tujuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-4">
                                <label for="tanggal_mulai_spd" class="form-label">Tanggal Berangkat</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('tanggal_berangkat') is-invalid @enderror" id="tanggal_mulai_spd" name="tanggal_berangkat" value="{{ old('tanggal_berangkat') }}" placeholder="dd-mm-YYYY" autocomplete="off" required>
                                    <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_mulai_spd" for="tanggal_mulai_spd">
                                        <i class="bi bi-calendar3"></i>
                                    </button>
                                </div>
                                @error('tanggal_berangkat') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="tanggal_selesai_spd" class="form-label">Tanggal Kembali</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('tanggal_kembali') is-invalid @enderror" id="tanggal_selesai_spd" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" placeholder="dd-mm-YYYY" autocomplete="off" required>
                                    <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_selesai_spd" for="tanggal_selesai_spd">
                                        <i class="bi bi-calendar3"></i>
                                    </button>
                                </div>
                                @error('tanggal_kembali') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="tanggal_surat_spd" class="form-label">Tanggal Surat Dikeluarkan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('tanggal_dikeluarkan') is-invalid @enderror" id="tanggal_surat_spd" name="tanggal_dikeluarkan" value="{{ old('tanggal_dikeluarkan') }}" placeholder="dd-mm-YYYY" autocomplete="off" required>
                                    <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_surat_spd" for="tanggal_surat_spd">
                                        <i class="bi bi-calendar3"></i>
                                    </button>
                                </div>
                                @error('tanggal_dikeluarkan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- MAKSUD & PEMBEBANAN --}}
                        <h5 class="fw-bold mb-3">Maksud & Pembebanan</h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="maksud_perjalanan" class="form-label">Maksud Perjalanan</label>
                                <textarea class="form-control @error('maksud_perjalanan') is-invalid @enderror" id="maksud_perjalanan" name="maksud_perjalanan" rows="3" placeholder="Tuliskan maksud perjalanan...">{{ old('maksud_perjalanan') }}</textarea>
                                @error('maksud_perjalanan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="skpd_pembebanan" class="form-label">SKPD Pembebanan</label>
                                <input type="text" class="form-control @error('skpd_pembebanan') is-invalid @enderror" id="skpd_pembebanan" name="skpd_pembebanan" value="{{ old('skpd_pembebanan') }}" required>
                                @error('skpd_pembebanan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="kode_rekening_pembebanan" class="form-label">Kode Rekening</label>
                                <input type="text" class="form-control @error('kode_rekening_pembebanan') is-invalid @enderror" id="kode_rekening_pembebanan" name="kode_rekening_pembebanan" value="{{ old('kode_rekening_pembebanan') }}" required>
                                @error('kode_rekening_pembebanan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label for="keterangan_lain" class="form-label">Keterangan Lain (Opsional)</label>
                                <textarea class="form-control @error('keterangan_lain') is-invalid @enderror" id="keterangan_lain" name="keterangan_lain" rows="2" placeholder="Tambahkan keterangan jika ada...">{{ old('keterangan_lain') }}</textarea>
                                @error('keterangan_lain') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- PENGIKUT (REPEATER) --}}
                        <h5 class="fw-bold mb-3">Pengikut</h5>
                        @php
                            $oldPengikut = old('pengikut');
                            if (!is_array($oldPengikut) || empty($oldPengikut)) {
                                $oldPengikut = [['nama' => '', 'tgl_lahir' => '', 'keterangan' => '']];
                            }
                        @endphp
                        <div id="wrap-pengikut">
                            @foreach($oldPengikut as $i => $row)
                                <div class="border rounded p-3 mb-2 pengikut-item">
                                    <div class="row g-2 align-items-end">
                                        <div class="col-md-4">
                                            <label class="form-label">Nama</label>
                                            <input type="text" name="pengikut[{{ $i }}][nama]" class="form-control @error("pengikut.$i.nama") is-invalid @enderror" value="{{ $row['nama'] ?? '' }}" placeholder="Nama pengikut">
                                            @error("pengikut.$i.nama") <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <div class="input-group">
                                                @php $tglId = "tanggal_lahir_keluarga_$i"; @endphp
                                                <input type="text" name="pengikut[{{ $i }}][tgl_lahir]" id="{{ $tglId }}" class="form-control" value="{{ $row['tgl_lahir'] ?? '' }}" placeholder="dd-mm-YYYY" autocomplete="off">
                                                <button class="btn btn-outline-secondary" type="button" id="btn_{{ $tglId }}" for="{{ $tglId }}">
                                                    <i class="bi bi-calendar3"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Keterangan</label>
                                            <div class="input-group">
                                                <input type="text" name="pengikut[{{ $i }}][keterangan]" class="form-control" value="{{ $row['keterangan'] ?? '' }}" placeholder="Hubungan/keterangan">
                                                <button type="button" class="btn btn-outline-danger remove-pengikut" title="Hapus">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add-pengikut">
                            <i class="bi bi-plus-lg"></i> Tambah Pengikut
                        </button>

                        <hr class="my-4">

                        {{-- RIWAYAT PERJALANAN (REPEATER) --}}
                        <h5 class="fw-bold mb-3">Riwayat Perjalanan</h5>
                        @php
                            $oldStep = old('riwayat_perjalanan');
                            if (!is_array($oldStep) || empty($oldStep)) {
                                $oldStep = [[
                                    'dari' => '',
                                    'ke' => '',
                                    'tgl_berangkat' => '',
                                    'kepala_berangkat_id' => '',
                                    'kepala_berangkat_nama' => '',
                                    'kepala_berangkat_nip' => '',
                                    'tiba_di' => '',
                                    'tgl_tiba' => '',
                                    'kepala_tiba_id' => '',
                                    'kepala_tiba_nama' => '',
                                    'kepala_tiba_nip' => '',
                                ]];
                            }
                        @endphp

                        <div id="wrap-riwayat">
                            @foreach($oldStep as $i => $step)
                                <div class="border rounded p-3 mb-3 riwayat-item">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="fw-bold mb-2">I. Keberangkatan</h6>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">Berangkat dari (Tempat Kedudukan)</label>
                                            <input type="text" name="riwayat_perjalanan[{{ $i }}][dari]" class="form-control" value="{{ $step['dari'] ?? '' }}">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">Ke</label>
                                            <input type="text" name="riwayat_perjalanan[{{ $i }}][ke]" class="form-control" value="{{ $step['ke'] ?? '' }}">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">Pada Tanggal</label>
                                            <div class="input-group">
                                                @php $rid1 = "tanggal_acara_berangkat_$i"; @endphp
                                                <input type="text" name="riwayat_perjalanan[{{ $i }}][tgl_berangkat]" id="{{ $rid1 }}" class="form-control" value="{{ $step['tgl_berangkat'] ?? '' }}" placeholder="dd-mm-YYYY" autocomplete="off">
                                                <button class="btn btn-outline-secondary" type="button" id="btn_{{ $rid1 }}" for="{{ $rid1 }}">
                                                    <i class="bi bi-calendar3"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Pilih Kepala (Keberangkatan)</label>
                                            <select name="riwayat_perjalanan[{{ $i }}][kepala_berangkat_id]" id="kepala_berangkat_id_{{ $i }}" class="form-select kepala-picker" data-target-nama="#kepala_berangkat_nama_{{ $i }}" data-target-nip="#kepala_berangkat_nip_{{ $i }}">
                                                <option value="">-- Pilih Pegawai --</option>
                                                @foreach($pegawais as $p)
                                                    <option value="{{ $p->id }}" data-nama="{{ $p->nama_lengkap ?? $p->nama }}" data-nip="{{ $p->nip }}"
                                                            {{ old("riwayat_perjalanan.$i.kepala_berangkat_id", $step['kepala_berangkat_id'] ?? '') == $p->id ? 'selected' : '' }}>
                                                        {{ $p->nama_lengkap ?? $p->nama }} - {{ $p->nip }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Selaku Pejabat Pelaksana Teknis Kegiatan</small>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Nama Kepala</label>
                                            <input type="text" id="kepala_berangkat_nama_{{ $i }}" name="riwayat_perjalanan[{{ $i }}][kepala_berangkat_nama]" class="form-control" value="{{ $step['kepala_berangkat_nama'] ?? '' }}" readonly>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">NIP Kepala</label>
                                            <input type="text" id="kepala_berangkat_nip_{{ $i }}" name="riwayat_perjalanan[{{ $i }}][kepala_berangkat_nip]" class="form-control" value="{{ $step['kepala_berangkat_nip'] ?? '' }}" readonly>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <h6 class="fw-bold mb-2">II. Tiba</h6>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Tiba di</label>
                                            <input type="text" name="riwayat_perjalanan[{{ $i }}][tiba_di]" class="form-control" value="{{ $step['tiba_di'] ?? '' }}">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Pada Tanggal</label>
                                            <div class="input-group">
                                                @php $rid2 = "tanggal_acara_tiba_$i"; @endphp
                                                <input type="text" name="riwayat_perjalanan[{{ $i }}][tgl_tiba]" id="{{ $rid2 }}" class="form-control" value="{{ $step['tgl_tiba'] ?? '' }}" placeholder="dd-mm-YYYY" autocomplete="off">
                                                <button class="btn btn-outline-secondary" type="button" id="btn_{{ $rid2 }}" for="{{ $rid2 }}">
                                                    <i class="bi bi-calendar3"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Pilih Kepala (Tiba)</label>
                                            <select name="riwayat_perjalanan[{{ $i }}][kepala_tiba_id]" id="kepala_tiba_id_{{ $i }}" class="form-select kepala-picker" data-target-nama="#kepala_tiba_nama_{{ $i }}" data-target-nip="#kepala_tiba_nip_{{ $i }}">
                                                <option value="">-- Pilih Pegawai --</option>
                                                @foreach($pegawais as $p)
                                                    <option value="{{ $p->id }}" data-nama="{{ $p->nama_lengkap ?? $p->nama }}" data-nip="{{ $p->nip }}"
                                                            {{ old("riwayat_perjalanan.$i.kepala_tiba_id", $step['kepala_tiba_id'] ?? '') == $p->id ? 'selected' : '' }}>
                                                        {{ $p->nama_lengkap ?? $p->nama }} - {{ $p->nip }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Nama Kepala</label>
                                            <input type="text" id="kepala_tiba_nama_{{ $i }}" name="riwayat_perjalanan[{{ $i }}][kepala_tiba_nama]" class="form-control" value="{{ $step['kepala_tiba_nama'] ?? '' }}" readonly>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">NIP Kepala</label>
                                            <input type="text" id="kepala_tiba_nip_{{ $i }}" name="riwayat_perjalanan[{{ $i }}][kepala_tiba_nip]" class="form-control" value="{{ $step['kepala_tiba_nip'] ?? '' }}" readonly>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end mt-2">
                                            <button type="button" class="btn btn-outline-danger remove-riwayat">
                                                <i class="bi bi-x-lg"></i> Hapus Riwayat
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add-riwayat">
                            <i class="bi bi-plus-lg"></i> Tambah Riwayat
                        </button>

                        <!-- Tombol -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Simpan SPD</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
// ======================
// PENGIKUT REPEATER
// ======================
(function () {
    let pengikutIndex = document.querySelectorAll('#wrap-pengikut .pengikut-item').length || 0;

    function initDatepickerSingle(tglId) {
        setTimeout(function () {
        if (typeof $ === 'undefined' || typeof $.fn.datepicker === 'undefined') return;
        const inputElement = document.getElementById(tglId);
        const buttonElement = document.getElementById('btn_' + tglId);
        if (inputElement && !$(inputElement).data('datepicker')) {
            $(inputElement).datepicker({
            autoclose: true,
            clearBtn: true,
            format: "dd-mm-yyyy",
            todayHighlight: true,
            orientation: "bottom auto"
            });
            if (buttonElement) {
            $(buttonElement).off('click').on('click', function () {
                $(inputElement).datepicker('show');
            });
            }
        }
        }, 100);
    }

    document.getElementById('add-pengikut')?.addEventListener('click', function () {
        const wrap = document.getElementById('wrap-pengikut');
        const i = pengikutIndex++;
        const tglId = `tanggal_lahir_keluarga_${i}`;
        const btnId = `btn_${tglId}`;

        const html = `
        <div class="border rounded p-3 mb-2 pengikut-item">
            <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Nama</label>
                <input type="text" name="pengikut[${i}][nama]" class="form-control" placeholder="Nama pengikut">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Lahir</label>
                <div class="input-group">
                <input type="text" name="pengikut[${i}][tgl_lahir]" id="${tglId}" class="form-control" placeholder="dd-mm-YYYY" autocomplete="off">
                <button class="btn btn-outline-secondary" type="button" id="${btnId}" for="${tglId}">
                    <i class="bi bi-calendar3"></i>
                </button>
                </div>
            </div>
            <div class="col-md-5">
                <label class="form-label">Keterangan</label>
                <div class="input-group">
                <input type="text" name="pengikut[${i}][keterangan]" class="form-control" placeholder="Hubungan/keterangan">
                <button type="button" class="btn btn-outline-danger remove-pengikut" title="Hapus">
                    <i class="bi bi-x-lg"></i>
                </button>
                </div>
            </div>
            </div>
        </div>`;
        wrap.insertAdjacentHTML('beforeend', html);
        initDatepickerSingle(tglId);
    });

    // Delegated remove
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-pengikut')) {
        e.target.closest('.pengikut-item')?.remove();
        }
    });
})();


// ================================================
// RIWAYAT REPEATER (Select2 + Datepicker + Numbering)
// ================================================
(function () {
    // counter khusus index form (biar unik, ga di-reset saat hapus)
    let riwayatFormIndex = document.querySelectorAll('#wrap-riwayat .riwayat-item').length || 0;

    // helper angka -> romawi
    function toRoman(num) {
        const romans = [
        ["M", 1000], ["CM", 900], ["D", 500], ["CD", 400],
        ["C", 100], ["XC", 90], ["L", 50], ["XL", 40],
        ["X", 10], ["IX", 9], ["V", 5], ["IV", 4], ["I", 1]
        ];
        let out = "";
        for (const [r, v] of romans) {
        while (num >= v) { out += r; num -= v; }
        }
        return out;
    }

    // map pegawai (fallback)
    window.PEGAWAI_MAP = window.PEGAWAI_MAP || {};
    @if(isset($pegawais))
        window.PEGAWAI_MAP = @json(
        $pegawais->mapWithKeys(fn($p)=>[
            $p->id => [
            'nama' => $p->nama_lengkap ?? $p->nama,
            'nip'  => $p->nip,
            ]
        ])
        );
    @endif

    // init Select2 untuk .kepala-picker (scoped)
    window.initKepalaPicker = function (scope) {
        if (typeof $ === 'undefined' || typeof $.fn.select2 === 'undefined') return;
        const $scope = scope ? $(scope) : $(document);
        $scope.find('select.kepala-picker').each(function () {
        const $sel = $(this);
        if ($sel.hasClass('select2-hidden-accessible')) return;

        const $modalParent = $sel.closest('.modal');
        const extra = $modalParent.length ? { dropdownParent: $modalParent } : {};

        try {
            $sel.select2({
            placeholder: "-- Pilih Pegawai --",
            allowClear: true,
            width: '100%',
            ...extra
            });
        } catch (_) {}

        $sel.off('change.kepala').on('change.kepala', function () {
            const $opt = $(this).find('option:selected');
            const nama = $opt.data('nama') || (window.PEGAWAI_MAP[$opt.val()]?.nama ?? '');
            const nip  = $opt.data('nip')  || (window.PEGAWAI_MAP[$opt.val()]?.nip  ?? '');
            const namaTarget = $(this).data('target-nama');
            const nipTarget  = $(this).data('target-nip');
            if (namaTarget) $(namaTarget).val(nama);
            if (nipTarget)  $(nipTarget).val(nip);
        });

        if ($sel.val()) $sel.trigger('change.kepala');
        });
    };

    // init datepicker (array id)
    function initDatepicker(ids) {
        if (typeof $ === 'undefined' || typeof $.fn.datepicker === 'undefined') return;
        (Array.isArray(ids) ? ids : [ids]).forEach(function (tglId) {
        setTimeout(function () {
            const inputElement = document.getElementById(tglId);
            const buttonElement = document.getElementById('btn_' + tglId);
            if (inputElement && !$(inputElement).data('datepicker')) {
            $(inputElement).datepicker({
                autoclose: true,
                clearBtn: true,
                format: "dd-mm-yyyy",
                todayHighlight: true,
                orientation: "bottom auto"
            });
            if (buttonElement) {
                $(buttonElement).off('click').on('click', function () {
                $(inputElement).datepicker('show');
                });
            }
            }
        }, 100);
        });
    }

    // generate option pegawai
    function generatePegawaiOptions() {
        let options = '<option value="">-- Pilih Pegawai --</option>';
        @if(isset($pegawais))
        @foreach($pegawais as $p)
            options += `<option value="{{ $p->id }}"
                            data-nama="{{ $p->nama_lengkap ?? $p->nama }}"
                            data-nip="{{ $p->nip }}">
                            {{ $p->nama_lengkap ?? $p->nama }} (NIP: {{ $p->nip }})
                        </option>`;
        @endforeach
        @endif
        return options;
    }

    // ambil hanya item riil (hindari template tersembunyi) pakai penanda data-riwayat="1"
    function getRiwayatItems() {
        return Array.from(document.querySelectorAll('#wrap-riwayat .riwayat-item[data-riwayat="1"]'));
    }

    // re-number heading "Tiba" (II, III, ...)
    function reIndexRiwayat() {
        const items = getRiwayatItems();
        items.forEach((item, idx) => {
        const h = item.querySelector('.tiba-heading');
        if (h) h.textContent = `${toRoman(idx + 2)}. Tiba`; // start dari II
        });
    }

    // Tambah riwayat
    document.getElementById('add-riwayat')?.addEventListener('click', function () {
        const wrap = document.getElementById('wrap-riwayat');
        const i = riwayatFormIndex++; // hanya untuk name/id input (unik), bukan untuk penomoran tampilan
        const rid1 = `tanggal_acara_berangkat_${i}`;
        const rid2 = `tanggal_acara_tiba_${i}`;
        const pegawaiOptions = generatePegawaiOptions();

        const html = `
        <div class="border rounded p-3 mb-3 riwayat-item" data-riwayat="1">
            <div class="row">
            <div class="col-12">
                <h6 class="fw-bold mb-2">Keberangkatan</h6>
            </div>

            <div class="col-md-4 mb-2">
                <label class="form-label">Berangkat dari (Tempat Kedudukan)</label>
                <input type="text" name="riwayat_perjalanan[${i}][dari]" class="form-control">
            </div>
            <div class="col-md-4 mb-2">
                <label class="form-label">Ke</label>
                <input type="text" name="riwayat_perjalanan[${i}][ke]" class="form-control">
            </div>
            <div class="col-md-4 mb-2">
                <label class="form-label">Pada Tanggal</label>
                <div class="input-group">
                <input type="text" name="riwayat_perjalanan[${i}][tgl_berangkat]" id="${rid1}" class="form-control" placeholder="dd-mm-YYYY" autocomplete="off">
                <button class="btn btn-outline-secondary" type="button" id="btn_${rid1}" for="${rid1}">
                    <i class="bi bi-calendar3"></i>
                </button>
                </div>
            </div>

            <div class="col-md-6 mb-2">
                <label class="form-label">Pilih Kepala (Keberangkatan)</label>
                <select name="riwayat_perjalanan[${i}][kepala_berangkat_id]" id="kepala_berangkat_id_${i}" class="form-select kepala-picker" data-target-nama="#kepala_berangkat_nama_${i}" data-target-nip="#kepala_berangkat_nip_${i}">
                ${pegawaiOptions}
                </select>
                <small class="text-muted">Selaku Pejabat Pelaksana Teknis Kegiatan</small>
            </div>
            <div class="col-md-3 mb-2">
                <label class="form-label">Nama Kepala</label>
                <input type="text" id="kepala_berangkat_nama_${i}" name="riwayat_perjalanan[${i}][kepala_berangkat_nama]" class="form-control" readonly>
            </div>
            <div class="col-md-3 mb-2">
                <label class="form-label">NIP Kepala</label>
                <input type="text" id="kepala_berangkat_nip_${i}" name="riwayat_perjalanan[${i}][kepala_berangkat_nip]" class="form-control" readonly>
            </div>

            <div class="col-12 mt-3">
                <h6 class="fw-bold mb-2 tiba-heading"></h6>
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label">Tiba di</label>
                <input type="text" name="riwayat_perjalanan[${i}][tiba_di]" class="form-control">
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label">Pada Tanggal</label>
                <div class="input-group">
                <input type="text" name="riwayat_perjalanan[${i}][tgl_tiba]" id="${rid2}" class="form-control" placeholder="dd-mm-YYYY" autocomplete="off">
                <button class="btn btn-outline-secondary" type="button" id="btn_${rid2}" for="${rid2}">
                    <i class="bi bi-calendar3"></i>
                </button>
                </div>
            </div>

            <div class="col-md-6 mb-2">
                <label class="form-label">Pilih Kepala (Tiba)</label>
                <select name="riwayat_perjalanan[${i}][kepala_tiba_id]" id="kepala_tiba_id_${i}" class="form-select kepala-picker" data-target-nama="#kepala_tiba_nama_${i}" data-target-nip="#kepala_tiba_nip_${i}">
                ${pegawaiOptions}
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <label class="form-label">Nama Kepala</label>
                <input type="text" id="kepala_tiba_nama_${i}" name="riwayat_perjalanan[${i}][kepala_tiba_nama]" class="form-control" readonly>
            </div>
            <div class="col-md-3 mb-2">
                <label class="form-label">NIP Kepala</label>
                <input type="text" id="kepala_tiba_nip_${i}" name="riwayat_perjalanan[${i}][kepala_tiba_nip]" class="form-control" readonly>
            </div>

            <div class="col-12 d-flex justify-content-end mt-2">
                <button type="button" class="btn btn-outline-danger remove-riwayat">
                <i class="bi bi-x-lg"></i> Hapus Riwayat
                </button>
            </div>
            </div>
        </div>
        `;
        wrap.insertAdjacentHTML('beforeend', html);

        // re-number SELALU setelah insert
        reIndexRiwayat();

        // init select2 & datepicker utk item baru
        setTimeout(function () {
        const lastItem = wrap.querySelector('.riwayat-item:last-child');
        if (lastItem && typeof window.initKepalaPicker === 'function') {
            window.initKepalaPicker(lastItem);
            initDatepicker([rid1, rid2]);
        }
        }, 0);
    });

    // delegated remove (plus re-number)
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-riwayat')) {
        e.target.closest('.riwayat-item')?.remove();
        reIndexRiwayat();
        }
    });

    // init awal saat lib siap
    function initializeWhenReady() {
        if (typeof $ === 'undefined') { setTimeout(initializeWhenReady, 100); return; }
        if (typeof $.fn.select2 === 'undefined') { setTimeout(initializeWhenReady, 100); return; }

        // init select2 utk item statis yang sudah ada
        window.initKepalaPicker();

        // numbering awal utk item yang sudah render di server
        reIndexRiwayat();

        // kalau dipakai di modal, re-init saat modal muncul
        $(document).on('shown.bs.modal', '.modal', function(){
        window.initKepalaPicker(this);
        reIndexRiwayat();
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeWhenReady);
    } else {
        initializeWhenReady();
    }
})();
</script>


@endsection