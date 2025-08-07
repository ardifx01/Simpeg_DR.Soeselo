@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Edit SKP</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('skp.index') }}">Daftar Sasaran Kerja</a></li>
                    <li class="breadcrumb-item">Edit SKP</li>
                </ol>
            </nav>
        </div>
        <div class="col-auto">
            <a href="{{ route('skp.show', $skp->id) }}" class="btn btn-info btn-sm text-white me-2">
                <i class="bi bi-eye"></i> Detail
            </a>
            <a href="{{ route('skp.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('skp.update', $skp->id) }}" method="POST" id="skpForm">
            @csrf
            @method('PUT')
            
            {{-- Informasi Umum --}}
            <div class="mb-4">
                <h5 class="card-title text-primary border-bottom pb-2">Informasi Umum</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="pegawai_dinilai_id" class="form-label">Pegawai yang Dinilai <span class="text-danger">*</span></label>
                        <select name="pegawai_dinilai_id" id="pegawai_dinilai_id" class="form-select @error('pegawai_dinilai_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}" {{ (old('pegawai_dinilai_id') ?? $skp->pegawai_dinilai_id) == $pegawai->id ? 'selected' : '' }}>
                                    {{ $pegawai->nama_lengkap }} - {{ $pegawai->nip ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                        @error('pegawai_dinilai_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="pegawai_penilai_id" class="form-label">Pegawai Penilai <span class="text-danger">*</span></label>
                        <select name="pegawai_penilai_id" id="pegawai_penilai_id" class="form-select @error('pegawai_penilai_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}" {{ (old('pegawai_penilai_id') ?? $skp->pegawai_penilai_id) == $pegawai->id ? 'selected' : '' }}>
                                    {{ $pegawai->nama_lengkap }} - {{ $pegawai->nip ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                        @error('pegawai_penilai_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="atasan_pegawai_penilai_id" class="form-label">Atasan Pegawai Penilai <span class="text-danger">*</span></label>
                        <select name="atasan_pegawai_penilai_id" id="atasan_pegawai_penilai_id" class="form-select @error('atasan_pegawai_penilai_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}" {{ (old('atasan_pegawai_penilai_id') ?? $skp->atasan_pegawai_penilai_id) == $pegawai->id ? 'selected' : '' }}>
                                    {{ $pegawai->nama_lengkap }} - {{ $pegawai->nip ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                        @error('atasan_pegawai_penilai_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun') ?? $skp->tahun }}" min="2000" max="{{ date('Y') + 5 }}" required>
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="nilai_perilaku" class="form-label">Nilai Perilaku <span class="text-danger">*</span></label>
                        <input type="number" name="nilai_perilaku" id="nilai_perilaku" class="form-control @error('nilai_perilaku') is-invalid @enderror" value="{{ old('nilai_perilaku') ?? $skp->nilai_perilaku }}" min="0" max="100" step="0.01" required>
                        @error('nilai_perilaku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Kegiatan --}}
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title text-primary border-bottom pb-2 mb-0">Daftar Kegiatan</h5>
                    <button type="button" class="btn btn-success btn-sm" id="addKegiatan">
                        <i class="bi bi-plus-circle"></i> Tambah Kegiatan
                    </button>
                </div>
                
                <div id="kegiatanContainer">
                    {{-- Kegiatan existing akan dimuat di sini --}}
                </div>
            </div>

            {{-- Catatan Penilaian --}}
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title text-primary border-bottom pb-2 mb-0">Catatan Penilaian</h5>
                    <button type="button" class="btn btn-info btn-sm" id="addCatatan">
                        <i class="bi bi-plus-circle"></i> Tambah Catatan
                    </button>
                </div>
                
                <div id="catatanContainer">
                    {{-- Catatan existing akan dimuat di sini --}}
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update SKP
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const pegawais = @json($pegawais);
</script>

{{-- JavaScript untuk Dynamic Form --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load existing kegiatan
    const existingKegiatan = @json($skp->kegiatan);
    existingKegiatan.forEach(function(kegiatan, index) {
        addKegiatanForm(kegiatan, index);
    });

    // Load existing catatan
    const existingCatatan = @json($skp->catatanPenilaian);
    existingCatatan.forEach(function(catatan, index) {
        addCatatanForm(catatan, index);
    });

    // Jika tidak ada kegiatan, tambah form kosong
    if (existingKegiatan.length === 0) {
        addKegiatanForm();
    }

    // Event listener untuk tombol tambah kegiatan
    document.getElementById('addKegiatan').addEventListener('click', function() {
        addKegiatanForm();
    });

    // Event listener untuk tombol tambah catatan
    document.getElementById('addCatatan').addEventListener('click', function() {
        addCatatanForm();
    });

    // Fungsi untuk mendapatkan index kegiatan berikutnya
    function getNextKegiatanIndex() {
        const existingItems = document.querySelectorAll('.kegiatan-item');
        const indices = Array.from(existingItems).map(item => {
            const id = item.id;
            return parseInt(id.replace('kegiatan-', ''));
        });
        return indices.length > 0 ? Math.max(...indices) + 1 : 0;
    }

    // Fungsi untuk mendapatkan index catatan berikutnya
    function getNextCatatanIndex() {
        const existingItems = document.querySelectorAll('.catatan-item');
        const indices = Array.from(existingItems).map(item => {
            const id = item.id;
            return parseInt(id.replace('catatan-', ''));
        });
        return indices.length > 0 ? Math.max(...indices) + 1 : 0;
    }

    // Fungsi untuk menambah form kegiatan
    function addKegiatanForm(data = null, index = null) {
        const currentIndex = index !== null ? index : getNextKegiatanIndex();
        const container = document.getElementById('kegiatanContainer');
        const displayNumber = document.querySelectorAll('.kegiatan-item').length + 1;
        
        const kegiatanHtml = `
            <div class="card mb-3 kegiatan-item" id="kegiatan-${currentIndex}">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Kegiatan ${displayNumber}</h6>
                    <button type="button" class="btn btn-danger btn-sm remove-kegiatan">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
                <div class="card-body">
                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kegiatan <span class="text-danger">*</span></label>
                            <select name="kegiatan[${currentIndex}][jenis_kegiatan]" class="form-select" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Dokumen" ${data && data.jenis_kegiatan === 'Dokumen' ? 'selected' : ''}>Dokumen</option>
                                <option value="Kegiatan" ${data && data.jenis_kegiatan === 'Kegiatan' ? 'selected' : ''}>Kegiatan</option>
                                <option value="Lapangan" ${data && data.jenis_kegiatan === 'Lapangan' ? 'selected' : ''}>Lapangan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" name="kegiatan[${currentIndex}][nama_kegiatan]" class="form-control" value="${data ? data.nama_kegiatan || '' : ''}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">AK (Angka Kredit)</label>
                            <input type="text" name="kegiatan[${currentIndex}][ak]" class="form-control" value="${data ? data.ak || '' : ''}">
                        </div>
                        
                        <div class="col-12">
                            <h6 class="text-muted border-bottom pb-1">Target & Realisasi</h6>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Target Kuantitatif Output <span class="text-danger">*</span></label>
                            <input type="text" name="kegiatan[${currentIndex}][target_kuantitatif_output]" class="form-control" value="${data ? data.target_kuantitatif_output || '' : ''}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Realisasi Kuantitatif Output</label>
                            <input type="text" name="kegiatan[${currentIndex}][realisasi_kuantitatif_output]" class="form-control" value="${data ? data.realisasi_kuantitatif_output || '' : ''}">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Target Kualitatif Mutu <span class="text-danger">*</span></label>
                            <input type="number" name="kegiatan[${currentIndex}][target_kualitatif_mutu]" class="form-control" min="0" step="0.01" value="${data ? data.target_kualitatif_mutu || '' : ''}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Realisasi Kualitatif Mutu</label>
                            <input type="number" name="kegiatan[${currentIndex}][realisasi_kualitatif_mutu]" class="form-control" min="0" step="0.01" value="${data ? data.realisasi_kualitatif_mutu || '' : ''}">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Target Waktu (Bulan) <span class="text-danger">*</span></label>
                            <input type="number" name="kegiatan[${currentIndex}][target_waktu_bulan]" class="form-control" min="1" value="${data ? data.target_waktu_bulan || '' : ''}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Realisasi Waktu (Bulan)</label>
                            <input type="number" name="kegiatan[${currentIndex}][realisasi_waktu_bulan]" class="form-control" min="0" value="${data ? data.realisasi_waktu_bulan || '' : ''}">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Target Biaya</label>
                            <input type="number" name="kegiatan[${currentIndex}][target_biaya]" class="form-control" min="0" step="0.01" value="${data ? data.target_biaya || '' : ''}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Realisasi Biaya</label>
                            <input type="number" name="kegiatan[${currentIndex}][realisasi_biaya]" class="form-control" min="0" step="0.01" value="${data ? data.realisasi_biaya || '' : ''}">
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', kegiatanHtml);
        
        // Update nomor setelah menambah
        updateKegiatanNumbers();
        
        // Event listener untuk tombol hapus kegiatan
        const newItem = document.getElementById(`kegiatan-${currentIndex}`);
        newItem.querySelector('.remove-kegiatan').addEventListener('click', function() {
            newItem.remove();
            updateKegiatanNumbers();
        });
    }

    // Fungsi untuk menambah form catatan
    function addCatatanForm(data = null, index = null) {
        const currentIndex = index !== null ? index : getNextCatatanIndex();
        const container = document.getElementById('catatanContainer');
        const displayNumber = document.querySelectorAll('.catatan-item').length + 1;
        
        // Buat opsi select pegawai
        let optionsHtml = '<option value="">-- Pilih Pegawai Penilai --</option>';
        if (pegawais) {
            pegawais.forEach(pegawai => {
                const isSelected = data && data.pegawai_penilai_id == pegawai.id ? 'selected' : '';
                optionsHtml += `<option value="${pegawai.id}" ${isSelected}>${pegawai.nama} - ${pegawai.nip}</option>`;
            });
        }
        
        // Format tanggal untuk display
        let displayDate = '';
        if (data && data.tanggal) {
            // Jika tanggal dalam format Y-m-d, konversi ke d-m-Y untuk display
            const dateObj = new Date(data.tanggal);
            if (!isNaN(dateObj.getTime())) {
                displayDate = String(dateObj.getDate()).padStart(2, '0') + '-' + 
                            String(dateObj.getMonth() + 1).padStart(2, '0') + '-' + 
                            dateObj.getFullYear();
            } else {
                displayDate = data.tanggal;
            }
        }
        
        const catatanHtml = `
            <div class="card mb-3 catatan-item" id="catatan-${currentIndex}">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Catatan ${displayNumber}</h6>
                    <button type="button" class="btn btn-danger btn-sm remove-catatan">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
                <div class="card-body">
                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label for="catatan_tanggal_${currentIndex}" class="form-label">Tanggal</label>
                            <div class="input-group">
                                <input type="text" name="catatan[${currentIndex}][tanggal]" id="catatan_tanggal_${currentIndex}" class="form-control" value="${displayDate}">
                                <button class="btn btn-outline-secondary" type="button" for="catatan_tanggal_${currentIndex}">
                                    <i class="bi bi-calendar3"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="pegawai_penilai_id_catatan_${currentIndex}" class="form-label">Pegawai Penilai <span class="text-danger">*</span></label>
                            <select name="catatan[${currentIndex}][pegawai_penilai_id]" id="pegawai_penilai_id_catatan_${currentIndex}" class="form-select" required>
                                ${optionsHtml}
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Pegawai Penilai</label>
                            <input type="text" name="catatan[${currentIndex}][nama_pegawai_penilai]" id="nama_pegawai_penilai_${currentIndex}" class="form-control" value="${data ? data.nama_pegawai_penilai || '' : ''}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIP Pegawai Penilai</label>
                            <input type="text" name="catatan[${currentIndex}][nip_pegawai_penilai]" id="nip_pegawai_penilai_${currentIndex}" class="form-control" value="${data ? data.nip_pegawai_penilai || '' : ''}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Uraian</label>
                            <textarea name="catatan[${currentIndex}][uraian]" class="form-control" rows="3">${data ? data.uraian || '' : ''}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', catatanHtml);
        
        // Inisialisasi datepicker setelah elemen ditambahkan (sesuai dengan dashboard)
        const dateInput = $(`#catatan_tanggal_${currentIndex}`);
        if (!dateInput.data('datepicker')) {
            dateInput.datepicker({
                autoclose: true,
                clearBtn: true,
                format: "dd-mm-yyyy",
                todayHighlight: true,
                orientation: "bottom auto"
            });
        }

        // Event listener untuk tombol calendar datepicker
        $(`button[for="catatan_tanggal_${currentIndex}"]`).off('click').on('click', function () {
            $(`#catatan_tanggal_${currentIndex}`).datepicker('show');
        });

        // Inisialisasi Select2 untuk pegawai penilai (sesuai dengan dashboard)
        const selectElement = $(`#pegawai_penilai_id_catatan_${currentIndex}`);
        selectElement.select2({
            placeholder: "-- Pilih Pegawai Penilai --",
            allowClear: true,
            width: '100%'
        });

        // Event listener untuk perubahan pegawai penilai menggunakan Select2
        selectElement.on('change', function () {
            const selectedId = this.value;
            const selectedPegawai = pegawais.find(p => p.id == selectedId);

            const namaInput = document.getElementById(`nama_pegawai_penilai_${currentIndex}`);
            const nipInput = document.getElementById(`nip_pegawai_penilai_${currentIndex}`);

            if (selectedPegawai) {
                namaInput.value = selectedPegawai.nama_lengkap || selectedPegawai.nama || '';
                nipInput.value = selectedPegawai.nip || '';
            } else {
                namaInput.value = '';
                nipInput.value = '';
            }
        });

        // Update nomor setelah menambah
        updateCatatanNumbers();
        
        // Event listener untuk tombol hapus catatan
        const newItem = document.getElementById(`catatan-${currentIndex}`);
        newItem.querySelector('.remove-catatan').addEventListener('click', function() {
            newItem.remove();
            updateCatatanNumbers();
        });
    }

    // Fungsi untuk update nomor kegiatan
    function updateKegiatanNumbers() {
        const kegiatanItems = document.querySelectorAll('.kegiatan-item');
        kegiatanItems.forEach(function(item, index) {
            const header = item.querySelector('.card-header h6');
            header.textContent = `Kegiatan ${index + 1}`;
        });
    }

    // Fungsi untuk update nomor catatan
    function updateCatatanNumbers() {
        const catatanItems = document.querySelectorAll('.catatan-item');
        catatanItems.forEach(function(item, index) {
            const header = item.querySelector('.card-header h6');
            header.textContent = `Catatan ${index + 1}`;
        });
    }

    // Validasi form sebelum submit
    document.getElementById('skpForm').addEventListener('submit', function(e) {
        const kegiatanItems = document.querySelectorAll('.kegiatan-item');
        if (kegiatanItems.length === 0) {
            e.preventDefault();
            alert('Minimal harus ada satu kegiatan!');
            return false;
        }
    });
});
</script>

@endsection