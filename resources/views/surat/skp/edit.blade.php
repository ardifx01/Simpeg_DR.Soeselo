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

            {{-- Tugas Tambahan --}}
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title text-primary border-bottom pb-2 mb-0">Tugas Tambahan</h5>
                    <button type="button" class="btn btn-warning btn-sm" id="addTugasTambahan">
                        <i class="bi bi-plus-circle"></i> Tambah Tugas Tambahan
                    </button>
                </div>
                
                <div id="tugasTambahanContainer">
                    {{-- Tugas Tambahan existing akan dimuat di sini --}}
                </div>
            </div>
            
            {{-- Catatan Penilaian --}}
            <div class="mb-4">
                <h5 class="card-title text-primary border-bottom pb-2">Catatan Penilaian</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="catatan_tanggal" class="form-label">Tanggal</label>
                        <div class="input-group">
                            <input type="text" name="catatan_tanggal" id="catatan_tanggal" class="form-control" placeholder="Pilih tanggal" value="{{ old('catatan_tanggal', $skp->catatanPenilaian?->tanggal ? \Carbon\Carbon::parse($skp->catatanPenilaian->tanggal)->format('d-m-Y') : '') }}">
                            <button class="btn btn-outline-secondary" type="button" for="catatan_tanggal">
                                <i class="bi bi-calendar3"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-12 mb-4">
                        <label class="form-label">Uraian</label>
                        <textarea name="uraian" id="uraian" class="form-control bg-light" rows="8" readonly style="resize:none">{{ old('uraian', $skp->catatanPenilaian?->uraian) }}</textarea>
                    </div>
                    <div class="col-12">
                        <h6 class="pb-2">Aspek Perilaku</h6>
                    </div>

                    @php
                        $uraianText = $skp->catatanPenilaian?->uraian ?? '';

                        $extractedValues = [
                            'orientasi_pelayanan' => null,
                            'integritas' => null,
                            'komitmen' => null,
                            'disiplin' => null,
                            'kerjasama' => null,
                            'kepemimpinan' => null,
                        ];

                        if ($uraianText) {
                            // Regex yang lebih tepat untuk mengambil nilai numeric
                            preg_match('/Orientasi Pelayanan\s*:\s*([0-9]*\.?[0-9]+)/', $uraianText, $matches);
                            if (isset($matches[1])) {
                                $extractedValues['orientasi_pelayanan'] = trim($matches[1]);
                            }

                            preg_match('/Integritas\s*:\s*([0-9]*\.?[0-9]+)/', $uraianText, $matches);
                            if (isset($matches[1])) {
                                $extractedValues['integritas'] = trim($matches[1]);
                            }

                            preg_match('/Komitmen\s*:\s*([0-9]*\.?[0-9]+)/', $uraianText, $matches);
                            if (isset($matches[1])) {
                                $extractedValues['komitmen'] = trim($matches[1]);
                            }

                            preg_match('/Disiplin\s*:\s*([0-9]*\.?[0-9]+)/', $uraianText, $matches);
                            if (isset($matches[1])) {
                                $extractedValues['disiplin'] = trim($matches[1]);
                            }
                            
                            preg_match('/Kerjasama\s*:\s*([0-9]*\.?[0-9]+)/', $uraianText, $matches);
                            if (isset($matches[1])) {
                                $extractedValues['kerjasama'] = trim($matches[1]);
                            }

                            preg_match('/Kepemimpinan\s*:\s*([0-9]*\.?[0-9]+)/', $uraianText, $matches);
                            if (isset($matches[1])) {
                                $extractedValues['kepemimpinan'] = trim($matches[1]);
                            }
                        }
                    @endphp

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Orientasi Pelayanan</label>
                            <input type="number" class="form-control" name="orientasi_pelayanan" id="orientasi_pelayanan" min="0" max="100" step="0.01" value="{{ old('orientasi_pelayanan', $extractedValues['orientasi_pelayanan']) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Integritas</label>
                            <input type="number" class="form-control" name="integritas" id="integritas" min="0" max="100" step="0.01" value="{{ old('integritas', $extractedValues['integritas']) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Komitmen</label>
                            <input type="number" class="form-control" name="komitmen" id="komitmen" min="0" max="100" step="0.01" value="{{ old('komitmen', $extractedValues['komitmen']) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Disiplin</label>
                            <input type="number" class="form-control" name="disiplin" id="disiplin" min="0" max="100" step="0.01" value="{{ old('disiplin', $extractedValues['disiplin']) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kerjasama</label>
                            <input type="number" class="form-control" name="kerjasama" id="kerjasama" min="0" max="100" step="0.01" value="{{ old('kerjasama', $extractedValues['kerjasama']) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kepemimpinan</label>
                            <input type="number" class="form-control" name="kepemimpinan" id="kepemimpinan" min="0" max="100" step="0.01" value="{{ old('kepemimpinan', $extractedValues['kepemimpinan']) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nilai Perilaku</label>
                            <input type="number" class="form-control" name="nilai_perilaku" id="nilai_perilaku" readonly value="{{ old('nilai_perilaku', $skp->nilai_perilaku) }}">
                        </div>
                        <input type="hidden" name="catatan_id" value="{{ old('catatan_id', $skp->catatan?->id) }}">
                    </div>
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

    // Load existing tugas tambahan
    const existingTugasTambahan = @json($skp->tugasTambahan ?? []);
    existingTugasTambahan.forEach(function(tugasTambahan, index) {
        addTugasTambahanForm(tugasTambahan, index);
    });

    // Jika tidak ada kegiatan, tambah form kosong
    if (existingKegiatan.length === 0) {
        addKegiatanForm();
    }

    // Event listener untuk tombol tambah kegiatan
    document.getElementById('addKegiatan').addEventListener('click', function() {
        addKegiatanForm();
    });

    // Event listener untuk tombol tambah tugas tambahan
    document.getElementById('addTugasTambahan').addEventListener('click', function() {
        addTugasTambahanForm();
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

    // Fungsi untuk mendapatkan index tugas tambahan berikutnya
    function getNextTugasTambahanIndex() {
        const existingItems = document.querySelectorAll('.tugas-tambahan-item');
        const indices = Array.from(existingItems).map(item => {
            const id = item.id;
            return parseInt(id.replace('tugas-tambahan-', ''));
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

    // Fungsi untuk menambah form tugas tambahan
    function addTugasTambahanForm(data = null, index = null) {
        const currentIndex = index !== null ? index : getNextTugasTambahanIndex();
        const container = document.getElementById('tugasTambahanContainer');
        const displayNumber = document.querySelectorAll('.tugas-tambahan-item').length + 1;
        
        const tugasTambahanHtml = `
            <div class="card mb-3 tugas-tambahan-item" id="tugas-tambahan-${currentIndex}">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Tugas Tambahan ${displayNumber}</h6>
                    <button type="button" class="btn btn-danger btn-sm remove-tugas-tambahan">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
                <div class="card-body">
                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label class="form-label">Nama Tugas Tambahan <span class="text-danger">*</span></label>
                            <input type="text" name="tugas_tambahan[${currentIndex}][nama_tambahan]" class="form-control" value="${data ? data.nama_tambahan || '' : ''}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nilai Tugas Tambahan <span class="text-danger">*</span></label>
                            <input type="number" name="tugas_tambahan[${currentIndex}][nilai_tambahan]" class="form-control" min="0" max="100" step="0.01" value="${data ? data.nilai_tambahan || '' : ''}">
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', tugasTambahanHtml);
        
        // Update nomor setelah menambah
        updateTugasTambahanNumbers();
        
        // Event listener untuk tombol hapus tugas tambahan
        const newItem = document.getElementById(`tugas-tambahan-${currentIndex}`);
        newItem.querySelector('.remove-tugas-tambahan').addEventListener('click', function() {
            newItem.remove();
            updateTugasTambahanNumbers();
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

    // Fungsi untuk update nomor tugas tambahan
    function updateTugasTambahanNumbers() {
        const tugasTambahanItems = document.querySelectorAll('.tugas-tambahan-item');
        tugasTambahanItems.forEach(function(item, index) {
            const header = item.querySelector('.card-header h6');
            header.textContent = `Tugas Tambahan ${index + 1}`;
        });
    }

    // Hitung nilai perilaku + isi uraian
    const orientasiPelayananInput = document.getElementById('orientasi_pelayanan');
    if (orientasiPelayananInput) {
        $('#orientasi_pelayanan, #integritas, #komitmen, #disiplin, #kerjasama, #kepemimpinan').on('input', function () {
            let total = 0;
            let count = 0;

            const values = {
                orientasi: $('#orientasi_pelayanan').val(),
                integritas: $('#integritas').val(),
                komitmen: $('#komitmen').val(),
                disiplin: $('#disiplin').val(),
                kerjasama: $('#kerjasama').val(),
                kepemimpinan: $('#kepemimpinan').val()
            };

            Object.values(values).forEach(val => {
                const num = parseFloat(val);
                if (!isNaN(num)) {
                    total += num;
                    count++;
                }
            });

            const avg = count > 0 ? (total / count).toFixed(2) : '';
            $('#nilai_perilaku').val(avg);

            // Gabungkan ke uraian
            const uraianText = 
            `Aspek Perilaku Pegawai

            Orientasi Pelayanan : ${values.orientasi || '-'}
            Integritas          : ${values.integritas || '-'}
            Komitmen            : ${values.komitmen || '-'}
            Disiplin            : ${values.disiplin || '-'}
            Kerjasama           : ${values.kerjasama || '-'}
            Kepemimpinan        : ${values.kepemimpinan || '-'}`;
            $('#uraian').val(uraianText);
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