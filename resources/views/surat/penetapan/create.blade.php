@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <h1 class="h2 fw-bold text-primary">Tambah Surat Penetapan</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
            <li class="breadcrumb-item"><a href="{{ route('penetapan.index') }}">Surat Penetapan</a></li>
            <li class="breadcrumb-item active">Tambah Surat Penetapan</li>
        </ol>
    </nav>
</div>

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form Pengajuan Penetapan</h4>
                </div>
                <div class="card-body p-4">
                <form action="{{ route('penetapan.store') }}" method="POST" class="card shadow-sm p-4">
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
                            <label for="tahun_surat" class="form-label">Tahun Surat</label>
                            <input type="text" class="form-control @error('tahun_surat') is-invalid @enderror" id="tahun_surat" name="tahun_surat" value="{{ old('tahun_surat') }}" placeholder="YYYY" maxlength="4" required>
                            @error('tahun_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="tanggal_penetapan" class="form-label">Tanggal Penetapan</label>
                            <div class="input-group">
                                <div class="input-group">
                                <input type="text" class="form-control @error('tanggal_penetapan') is-invalid @enderror" id="tanggal_penetapan" name="tanggal_penetapan" value="{{ old('tanggal_penetapan') }}" autocomplete="off" required>
                                    <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_penetapan" for="tanggal_penetapan">
                                        <i class="bi bi-calendar3"></i>
                                    </button>
                                </div>
                            </div>
                            @error('tanggal_penetapan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="tentang" class="form-label">Tentang</label>
                            <input type="text" class="form-control @error('tentang') is-invalid @enderror" id="tentang" name="tentang" value="{{ old('tentang') }}" required>
                            @error('tentang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- PEJABAT PENETAP --}}
                    <h5 class="fw-bold mb-3">Pejabat Penetap</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="pegawai_id" class="form-label">Pejabat Penetap</label>
                            <select name="pegawai_id" id="pegawai_id" class="form-select @error('pegawai_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pejabat --</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }} - {{ $pegawai->nip ?? '' }}</option>
                                @endforeach
                            </select>
                            @error('pegawai_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- LIST POINS --}}
                    <h5 class="fw-bold mb-3">Poin-Poin Keputusan</h5>

                    {{-- MENIMBANG --}}
                    <div class="mb-3">
                        <label class="form-label">Menimbang</label>
                        @php
                            $menimbangOld = old('menimbang');

                            // kalau old() string → pecah per baris/koma; kalau null/empty → seed ['']
                            if (is_string($menimbangOld)) {
                                $menimbangOld = array_values(array_filter(array_map('trim', preg_split('/\r\n|\n|,/', $menimbangOld))));
                            }
                            if (!is_array($menimbangOld) || empty($menimbangOld)) {
                                $menimbangOld = [''];
                            }
                        @endphp

                        <div id="wrap-menimbang">
                            @foreach($menimbangOld as $i => $val)
                                <div class="input-group mb-2 menimbang-item">
                                    <span class="input-group-text">{{ $i+1 }}</span>
                                    <input type="text" name="menimbang[]" class="form-control @error('menimbang.'.$i) is-invalid @enderror" value="{{ $val }}" placeholder="Isi poin menimbang...">
                                    <button type="button" class="btn btn-outline-danger remove-row" title="Hapus">
                                        <i class="bi bi-x"></i>
                                    </button>
                                    @error('menimbang.'.$i)
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-primary add-row" data-target="#wrap-menimbang" data-name="menimbang[]">
                            <i class="bi bi-plus-lg"></i> Tambah Menimbang
                        </button>
                        @error('menimbang')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- MENGINGAT --}}
                    <div class="mb-3">
                        <label class="form-label">Mengingat</label>
                        @php
                            $mengingatOld = old('mengingat');
                            if (is_string($mengingatOld)) {
                                $mengingatOld = array_values(array_filter(array_map('trim', preg_split('/\r\n|\n|,/', $mengingatOld))));
                            }
                            if (!is_array($mengingatOld) || empty($mengingatOld)) {
                                $mengingatOld = [''];
                            }
                        @endphp

                        <div id="wrap-mengingat">
                            @foreach($mengingatOld as $i => $val)
                                <div class="input-group mb-2 mengingat-item">
                                    <span class="input-group-text">{{ $i+1 }}</span>
                                    <input type="text" name="mengingat[]" class="form-control @error('mengingat.'.$i) is-invalid @enderror" value="{{ $val }}" placeholder="Isi poin mengingat...">
                                    <button type="button" class="btn btn-outline-danger remove-row" title="Hapus">
                                        <i class="bi bi-x"></i>
                                    </button>
                                    @error('mengingat.'.$i)
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-primary add-row" data-target="#wrap-mengingat" data-name="mengingat[]">
                            <i class="bi bi-plus-lg"></i> Tambah Mengingat
                        </button>
                        @error('mengingat')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- MEMUTUSKAN --}}
                    <div class="mb-3">
                        <label class="form-label">Memutuskan</label>
                        @php
                            $memutuskanOld = old('memutuskan');
                            if (is_string($memutuskanOld)) {
                                $memutuskanOld = array_values(array_filter(array_map('trim', preg_split('/\r\n|\n|,/', $memutuskanOld))));
                            }
                            if (!is_array($memutuskanOld) || empty($memutuskanOld)) {
                                $memutuskanOld = [''];
                            }
                        @endphp

                        <div id="wrap-memutuskan">
                            @foreach($memutuskanOld as $i => $val)
                                <div class="input-group mb-2 memutuskan-item">
                                    <span class="input-group-text">{{ $i+1 }}</span>
                                    <input type="text" name="memutuskan[]" class="form-control @error('memutuskan.'.$i) is-invalid @enderror" value="{{ $val }}" placeholder="Isi poin keputusan (KESATU, KEDUA, ...)">
                                    <button type="button" class="btn btn-outline-danger remove-row" title="Hapus">
                                        <i class="bi bi-x"></i>
                                    </button>
                                    @error('memutuskan.'.$i)
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-primary add-row" data-target="#wrap-memutuskan" data-name="memutuskan[]">
                            <i class="bi bi-plus-lg"></i> Tambah Memutuskan
                        </button>
                        @error('memutuskan')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol -->
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Penetapan</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('click', function(e){
    const addBtn = e.target.closest('.add-row');
    if (addBtn) {
        const wrap = document.querySelector(addBtn.dataset.target);
        const name = addBtn.dataset.name;
        const group = document.createElement('div');
        group.className = 'input-group mb-2';
        const count = wrap.querySelectorAll('.input-group').length + 1;

        group.innerHTML = `
            <span class="input-group-text">${count}</span>
            <input type="text" name="${name}" class="form-control" placeholder="Isi poin...">
            <button type="button" class="btn btn-outline-danger remove-row" title="Hapus">
                <i class="bi bi-x"></i>
            </button>
        `;
        wrap.appendChild(group);

        // re-number
        wrap.querySelectorAll('.input-group-text').forEach((el, i)=> el.textContent = i+1);
        return;
    }

    const removeBtn = e.target.closest('.remove-row');
    if (removeBtn) {
        const row = removeBtn.closest('.input-group');
        const wrap = row.parentElement;
        row.remove();
        wrap.querySelectorAll('.input-group-text').forEach((el, i)=> el.textContent = i+1);
    }
});
</script>

@endsection