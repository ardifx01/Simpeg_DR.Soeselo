{{-- resources/views/surat/perintah/create.blade.php --}}
@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <h1 class="h2 fw-bold text-primary">Tambah Surat Perintah</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
            <li class="breadcrumb-item"><a href="{{ route('perintah.index') }}">Surat Perintah</a></li>
            <li class="breadcrumb-item active">Tambah Surat Perintah</li>
        </ol>
    </nav>
</div>

<section class="row mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Form Pengajuan Surat Perintah</h4>
                </div>
                <div class="card-body p-4">
                <form action="{{ route('perintah.store') }}" method="POST" class="card shadow-sm p-4">
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
                            <label for="tanggal_surat" class="form-label">Tanggal Perintah</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('tanggal_perintah') is-invalid @enderror" id="tanggal_surat" name="tanggal_perintah" value="{{ old('tanggal_perintah') }}" placeholder="dd-mm-YYYY" autocomplete="off" required>
                                <button class="btn btn-outline-secondary" type="button" id="btn_tanggal_surat" for="tanggal_surat">
                                    <i class="bi bi-calendar3"></i>
                                </button>
                            </div>
                            @error('tanggal_perintah') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="tempat_dikeluarkan" class="form-label">Tempat</label>
                            <input type="text" class="form-control @error('tempat_dikeluarkan') is-invalid @enderror" id="tempat_dikeluarkan" name="tempat_dikeluarkan" value="{{ old('tempat_dikeluarkan') }}" placeholder="Contoh: Slawi" required>
                            @error('tempat_dikeluarkan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- PEJABAT PENANDATANGAN --}}
                    <h5 class="fw-bold mb-3">Pejabat Penandatangan</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="pegawai_id" class="form-label">Pejabat</label>
                            <select name="pegawai_id" id="pegawai_id"
                                    class="form-select @error('pegawai_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($pegawais as $p)
                                    <option value="{{ $p->id }}" {{ old('pegawai_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_lengkap ?? $p->nama }} (NIP: {{ $p->nip }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pegawai_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Nama/NIP/Jabatan/Pangkat akan otomatis terpakai saat export.</small>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- PENERIMA SURAT (MULTIPLE) --}}
                    <h5 class="fw-bold mb-3">Penerima Surat</h5>
                    <div class="mb-3">
                        <label for="penerima" class="form-label">Pilih Pegawai</label>
                        <select name="penerima[]" id="penerima" class="form-select @error('penerima') is-invalid @enderror" multiple="multiple" required>
                            @php $oldPenerima = collect(old('penerima', []))->map(fn($v)=>(int)$v); @endphp
                            @foreach($pegawais as $p)
                                <option value="{{ $p->id }}" {{ $oldPenerima->contains($p->id) ? 'selected' : '' }}>
                                    {{ $p->nama_lengkap ?? $p->nama }} (NIP: {{ $p->nip }})
                                </option>
                            @endforeach
                        </select>
                        @error('penerima') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        @error('penerima.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        <small class="text-muted">* Tekan Ctrl / Cmd untuk memilih lebih dari satu peserta</small>
                    </div>

                    <hr class="my-4">

                    {{-- LIST: MENIMBANG / DASAR / UNTUK --}}
                    <h5 class="fw-bold mb-3">Pokok Surat</h5>

                    {{-- MENIMBANG --}}
                    <div class="mb-3">
                        <label class="form-label">Menimbang</label>
                        @php
                            $menimbangOld = old('menimbang');
                            if (is_string($menimbangOld)) {
                                $menimbangOld = array_values(array_filter(array_map('trim', preg_split('/\r\n|\n|,/', $menimbangOld))));
                            }
                            if (!is_array($menimbangOld) || empty($menimbangOld)) { $menimbangOld = ['']; }
                        @endphp
                        <div id="wrap-menimbang">
                            @foreach($menimbangOld as $i => $val)
                                <div class="input-group mb-2 menimbang-item">
                                    <span class="input-group-text">{{ $i+1 }}</span>
                                    <input type="text" name="menimbang[]" class="form-control @error('menimbang.'.$i) is-invalid @enderror" value="{{ $val }}" placeholder="Isi poin menimbang...">
                                    <button type="button" class="btn btn-outline-danger remove-row" title="Hapus">
                                        <i class="bi bi-x"></i>
                                    </button>
                                    @error('menimbang.'.$i) <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary add-row" data-target="#wrap-menimbang" data-name="menimbang[]">
                            <i class="bi bi-plus-lg"></i> Tambah Menimbang
                        </button>
                        @error('menimbang') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    {{-- DASAR --}}
                    <div class="mb-3">
                        <label class="form-label">Dasar</label>
                        @php
                            $dasarOld = old('dasar');
                            if (is_string($dasarOld)) {
                                $dasarOld = array_values(array_filter(array_map('trim', preg_split('/\r\n|\n|,/', $dasarOld))));
                            }
                            if (!is_array($dasarOld) || empty($dasarOld)) { $dasarOld = ['']; }
                        @endphp
                        <div id="wrap-dasar">
                            @foreach($dasarOld as $i => $val)
                                <div class="input-group mb-2 dasar-item">
                                    <span class="input-group-text">{{ $i+1 }}</span>
                                    <input type="text" name="dasar[]" class="form-control @error('dasar.'.$i) is-invalid @enderror" value="{{ $val }}" placeholder="Isi poin dasar...">
                                    <button type="button" class="btn btn-outline-danger remove-row" title="Hapus">
                                        <i class="bi bi-x"></i>
                                    </button>
                                    @error('dasar.'.$i) <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary add-row" data-target="#wrap-dasar" data-name="dasar[]">
                            <i class="bi bi-plus-lg"></i> Tambah Dasar
                        </button>
                        @error('dasar') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    {{-- UNTUK --}}
                    <div class="mb-3">
                        <label class="form-label">Untuk</label>
                        @php
                            $untukOld = old('untuk');
                            if (is_string($untukOld)) {
                                $untukOld = array_values(array_filter(array_map('trim', preg_split('/\r\n|\n|,/', $untukOld))));
                            }
                            if (!is_array($untukOld) || empty($untukOld)) { $untukOld = ['']; }
                        @endphp
                        <div id="wrap-untuk">
                            @foreach($untukOld as $i => $val)
                                <div class="input-group mb-2 untuk-item">
                                    <span class="input-group-text">{{ $i+1 }}</span>
                                    <input type="text" name="untuk[]" class="form-control @error('untuk.'.$i) is-invalid @enderror" value="{{ $val }}" placeholder="Isi tugas/perintah...">
                                    <button type="button" class="btn btn-outline-danger remove-row" title="Hapus">
                                        <i class="bi bi-x"></i>
                                    </button>
                                    @error('untuk.'.$i) <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary add-row" data-target="#wrap-untuk" data-name="untuk[]">
                            <i class="bi bi-plus-lg"></i> Tambah Untuk
                        </button>
                        @error('untuk') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Tombol -->
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Perintah</button>
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