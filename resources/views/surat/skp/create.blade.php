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
                            <input type="text" name="catatan_tanggal" id="catatan_tanggal" class="form-control" placeholder="Pilih tanggal" value="{{ old('catatan_tanggal') }}">
                            <button class="btn btn-outline-secondary" type="button" for="catatan_tanggal">
                                <i class="bi bi-calendar3"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-12 mb-4">
                        <label class="form-label">Uraian</label>
                        <textarea name="uraian" id="uraian" class="form-control bg-light" rows="8" readonly style="resize:none">{{ old('uraian') }}</textarea>
                    </div>
                    <div class="col-12">
                        <h6 class="pb-2">Aspek Perilaku</h6>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Orientasi Pelayanan</label>
                            <input type="number" class="form-control" name="orientasi_pelayanan" id="orientasi_pelayanan" min="0" max="100" step="0.01" value="{{ old('orientasi_pelayanan') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Integritas</label>
                            <input type="number" class="form-control" name="integritas" id="integritas" min="0" max="100" step="0.01" value="{{ old('integritas') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Komitmen</label>
                            <input type="number" class="form-control" name="komitmen" id="komitmen" min="0" max="100" step="0.01" value="{{ old('komitmen') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Disiplin</label>
                            <input type="number" class="form-control" name="disiplin" id="disiplin" min="0" max="100" step="0.01" value="{{ old('disiplin') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kerjasama</label>
                            <input type="number" class="form-control" name="kerjasama" id="kerjasama" min="0" max="100" step="0.01" value="{{ old('kerjasama') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kepemimpinan</label>
                            <input type="number" class="form-control" name="kepemimpinan" id="kepemimpinan" min="0" max="100" step="0.01" value="{{ old('kepemimpinan') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nilai Perilaku</label>
                            <input type="number" class="form-control" name="nilai_perilaku" id="nilai_perilaku" readonly value="{{ old('nilai_perilaku') }}" readonly>
                        </div>
                        <input type="hidden" name="catatan_id" value="{{ old('catatan_id', '') }}">
                    </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let kegiatanIndex = 0;
        let tugasTambahanIndex = 0;

        // Tambah kegiatan pertama dan catatan pertama saat halaman dimuat
        addKegiatanForm();

        // Event listener untuk tombol tambah kegiatan
        document.getElementById('addKegiatan').addEventListener('click', function() {
            addKegiatanForm();
            updateKegiatanNumbers();
        });

        // Event listener tombol tambah tugas tambahan
        document.getElementById('addTugasTambahan').addEventListener('click', function() {
            addTugasTambahanForm();
            updateTugasTambahanNumbers();
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
                                <input type="number" name="kegiatan[${currentIndex}][ak]" class="form-control">
                            </div>
                            
                            <div class="col-12">
                                <h6 class="text-muted border-bottom pb-1">Target & Realisasi</h6>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Target Kuantitatif Output <span class="text-danger">*</span></label>
                                <input type="number" name="kegiatan[${currentIndex}][target_kuantitatif_output]" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Realisasi Kuantitatif Output</label>
                                <input type="number" name="kegiatan[${currentIndex}][realisasi_kuantitatif_output]" class="form-control">
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

        // Fungsi menambah form tugas tambahan
        function addTugasTambahanForm() {
            const container = document.getElementById('tugasTambahanContainer');
            const currentIndex = tugasTambahanIndex;
            
            const tugasHtml = `
                <div class="card mb-3 tugas-item" id="tugas-${currentIndex}">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Tugas Tambahan ${document.querySelectorAll('.tugas-item').length + 1}</h6>
                        <button type="button" class="btn btn-danger btn-sm remove-tugas">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mt-1">
                            <div class="col-md-12">
                                <label class="form-label">Nama Tugas Tambahan <span class="text-danger">*</span></label>
                                <input type="text" name="tugas_tambahan[${currentIndex}][nama_tambahan]" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nilai Tugas Tambahan</label>
                                <input type="number" name="tugas_tambahan[${currentIndex}][nilai_tambahan]" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', tugasHtml);
            
            const newItem = document.getElementById(`tugas-${currentIndex}`);
            newItem.querySelector('.remove-tugas').addEventListener('click', function() {
                newItem.remove();
                updateTugasTambahanNumbers();
            });
            
            tugasTambahanIndex++;
        }

        // Fungsi untuk update nomor kegiatan
        function updateKegiatanNumbers() {
            const kegiatanItems = document.querySelectorAll('.kegiatan-item');
            kegiatanItems.forEach(function(item, index) {
                const header = item.querySelector('.card-header h6');
                header.textContent = `Kegiatan ${index + 1}`;
            });
        }

        // Fungsi update nomor tugas tambahan
        function updateTugasTambahanNumbers() {
            const tugasItems = document.querySelectorAll('.tugas-item');
            tugasItems.forEach(function(item, index) {
                const header = item.querySelector('.card-header h6');
                header.textContent = `Tugas Tambahan ${index + 1}`;
            });
        }

        // Autofill pegawai penilai
        $('#pegawai_penilai_id').on('change', function () {
            const selectedId = $(this).val();
            const selectedPegawai = pegawais.find(p => p.id == selectedId);

            if (selectedPegawai) {
                $('#nama_pegawai_penilai').val(selectedPegawai.nama);
                $('#nip_pegawai_penilai').val(selectedPegawai.nip || '');
            } else {
                $('#nama_pegawai_penilai').val('');
                $('#nip_pegawai_penilai').val('');
            }
        });

        // Hitung nilai perilaku + isi uraian
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