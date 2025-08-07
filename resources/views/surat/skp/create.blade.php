@extends('surat.layouts.main')

@section('main')

<div class="pagetitle mb-4">
    <div class="row justify-content-between g-2">
        <div class="col-auto">
            <h1 class="h2 fw-bold text-primary">Tambah SKP</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('skp.index') }}">Daftar Sasaran Kerja</a></li>
                    <li class="breadcrumb-item">Tambah SKP</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('skp.store') }}" method="POST" id="skpForm">
            @csrf
            
            {{-- Informasi Umum --}}
            <div class="mb-4">
                <h5 class="card-title text-primary border-bottom pb-2">Informasi Umum</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="pegawai_dinilai_id" class="form-label">Pegawai yang Dinilai <span class="text-danger">*</span></label>
                        <select name="pegawai_dinilai_id" id="pegawai_dinilai_id" class="form-select @error('pegawai_dinilai_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}" {{ old('pegawai_dinilai_id') == $pegawai->id ? 'selected' : '' }}>
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
                                <option value="{{ $pegawai->id }}" {{ old('pegawai_penilai_id') == $pegawai->id ? 'selected' : '' }}>
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
                                <option value="{{ $pegawai->id }}" {{ old('atasan_pegawai_penilai_id') == $pegawai->id ? 'selected' : '' }}>
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
                        <input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun', date('Y')) }}" min="2000" max="{{ date('Y') + 5 }}" required>
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="nilai_perilaku" class="form-label">Nilai Perilaku <span class="text-danger">*</span></label>
                        <input type="number" name="nilai_perilaku" id="nilai_perilaku" class="form-control @error('nilai_perilaku') is-invalid @enderror" value="{{ old('nilai_perilaku') }}" min="0" max="100" step="0.01" required>
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
                    {{-- Kegiatan akan ditambahkan di sini melalui JavaScript --}}
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
                    {{-- Catatan akan ditambahkan di sini melalui JavaScript --}}
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan SKP
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
        let kegiatanIndex = 0;
        let catatanIndex = 0;

        // Tambah kegiatan pertama dan catatan pertama saat halaman dimuat
        addKegiatanForm();
        addCatatanForm();

        // Event listener untuk tombol tambah kegiatan
        document.getElementById('addKegiatan').addEventListener('click', function() {
            addKegiatanForm();
            updateKegiatanNumbers();
        });

        // Event listener untuk tombol tambah catatan
        document.getElementById('addCatatan').addEventListener('click', function() {
            addCatatanForm();
            updateCatatanNumbers();
        });

        // Fungsi untuk menambah form kegiatan
        function addKegiatanForm() {
            const container = document.getElementById('kegiatanContainer');
            const currentIndex = kegiatanIndex;
            
            const kegiatanHtml = `
                <div class="card mb-3 kegiatan-item" id="kegiatan-${currentIndex}">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Kegiatan ${document.querySelectorAll('.kegiatan-item').length + 1}</h6>
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
                                    <option value="Dokumen">Dokumen</option>
                                    <option value="Kegiatan">Kegiatan</option>
                                    <option value="Lapangan">Lapangan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                                <input type="text" name="kegiatan[${currentIndex}][nama_kegiatan]" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">AK (Angka Kredit)</label>
                                <input type="text" name="kegiatan[${currentIndex}][ak]" class="form-control">
                            </div>
                            
                            <div class="col-12">
                                <h6 class="text-muted border-bottom pb-1">Target & Realisasi</h6>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Target Kuantitatif Output <span class="text-danger">*</span></label>
                                <input type="text" name="kegiatan[${currentIndex}][target_kuantitatif_output]" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Realisasi Kuantitatif Output</label>
                                <input type="text" name="kegiatan[${currentIndex}][realisasi_kuantitatif_output]" class="form-control">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Target Kualitatif Mutu <span class="text-danger">*</span></label>
                                <input type="number" name="kegiatan[${currentIndex}][target_kualitatif_mutu]" class="form-control" min="0" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Realisasi Kualitatif Mutu</label>
                                <input type="number" name="kegiatan[${currentIndex}][realisasi_kualitatif_mutu]" class="form-control" min="0" step="0.01">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Target Waktu (Bulan) <span class="text-danger">*</span></label>
                                <input type="number" name="kegiatan[${currentIndex}][target_waktu_bulan]" class="form-control" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Realisasi Waktu (Bulan)</label>
                                <input type="number" name="kegiatan[${currentIndex}][realisasi_waktu_bulan]" class="form-control" min="0">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Target Biaya</label>
                                <input type="number" name="kegiatan[${currentIndex}][target_biaya]" class="form-control" min="0" step="0.01">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Realisasi Biaya</label>
                                <input type="number" name="kegiatan[${currentIndex}][realisasi_biaya]" class="form-control" min="0" step="0.01">
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', kegiatanHtml);
            
            // Event listener untuk tombol hapus kegiatan
            const newItem = document.getElementById(`kegiatan-${currentIndex}`);
            newItem.querySelector('.remove-kegiatan').addEventListener('click', function() {
                newItem.remove();
                updateKegiatanNumbers();
            });

            kegiatanIndex++;
        }

        // Fungsi untuk menambah form catatan
        function addCatatanForm() {
            const container = document.getElementById('catatanContainer');
            const currentIndex = catatanIndex;

            let optionsHtml = '<option value="">-- Pilih Pegawai --</option>';
            pegawais.forEach(pegawai => {
                optionsHtml += `<option value="${pegawai.id}">${pegawai.nama}</option>`;
            });
            
            const catatanHtml = `
                <div class="card mb-3 catatan-item" id="catatan-${currentIndex}">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Catatan ${document.querySelectorAll('.catatan-item').length + 1}</h6>
                        <button type="button" class="btn btn-danger btn-sm remove-catatan">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </div>
                    <div class="card-body">
                    <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label for="catatan_tanggal_${currentIndex}" class="form-label">Tanggal</label>
                                <div class="input-group">
                                    <input type="text" name="catatan[${currentIndex}][tanggal]" id="catatan_tanggal_${currentIndex}" class="form-control" placeholder="Pilih tanggal">
                                    <button class="btn btn-outline-secondary" type="button" id="btn_catatan_tanggal_${currentIndex}">
                                        <i class="bi bi-calendar3"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="pegawai_penilai_id_catatan_${currentIndex}" class="form-label">Pegawai Penilai <span class="text-danger">*</span></label>
                                <select name="catatan[${currentIndex}][pegawai_penilai_id]" id="pegawai_penilai_id_catatan_${currentIndex}" class="form-select pegawai-penilai-select" required>
                                    <option value="">-- Pilih Pegawai Penilai --</option>
                                    ${optionsHtml}
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Pegawai Penilai</label>
                                <input type="text" name="catatan[${currentIndex}][nama_pegawai_penilai]" id="nama_pegawai_penilai_catatan_${currentIndex}" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NIP Pegawai Penilai</label>
                                <input type="text" name="catatan[${currentIndex}][nip_pegawai_penilai]" id="nip_pegawai_penilai_catatan_${currentIndex}" class="form-control" readonly>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Uraian</label>
                                <textarea name="catatan[${currentIndex}][uraian]" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', catatanHtml);

            $(`#pegawai_penilai_id_catatan_${currentIndex}`).select2({
                placeholder: "-- Pilih Pegawai Penilai --",
                allowClear: true,
                width: '100%'
            });
            
            // Event listener untuk dropdown autofill
            const selectDropdown = document.getElementById(`pegawai_penilai_id_catatan_${currentIndex}`);
            const namaInput = document.getElementById(`nama_pegawai_penilai_catatan_${currentIndex}`);
            const nipInput = document.getElementById(`nip_pegawai_penilai_catatan_${currentIndex}`);

            selectDropdown.addEventListener('change', function() {
                const selectedId = this.value;
                const selectedPegawai = pegawais.find(p => p.id == selectedId);

                if (selectedPegawai) {
                    namaInput.value = selectedPegawai.nama;
                    nipInput.value = selectedPegawai.nip || '';
                } else {
                    namaInput.value = '';
                    nipInput.value = '';
                }
            });

            // Event listener untuk tombol hapus catatan
            const newItem = document.getElementById(`catatan-${currentIndex}`);
            newItem.querySelector('.remove-catatan').addEventListener('click', function() {
                newItem.remove();
                updateCatatanNumbers();
            });

            catatanIndex++;
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