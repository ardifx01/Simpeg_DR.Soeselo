<!-- Jabatan view -->
<div class="view">
    @if ($pegawai->jabatan)
    @php
        $jabatan = $pegawai->jabatan;
    @endphp
    <div class="row">
        <div class="col-md-6">
            <div class="section">
                <h6 class="border-bottom border-2 pb-2"><strong>LOKASI KERJA</strong></h6>
                <div class="row mb-3 form-group">
                    <label for="skpd" class="col-md-4 col-lg-3 col-form-label">Unit Kerja</label>
                    <div class="col-md-6 col-lg-7">
                        <input name="skpd" type="text" class="form-control @error('skpd') is-invalid @enderror" value="{{ old('skpd') ?? $jabatan->skpd }}">
                        @error('skpd')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3 form-group">
                    <label for="unit_kerja" class="col-md-4 col-lg-3 col-form-label">Sub Unit Kerja</label>
                    <div class="col-md-6 col-lg-7">
                        <input name="unit_kerja" type="text" class="form-control @error('unit_kerja') is-invalid @enderror" value="{{ old('unit_kerja') ?? $jabatan->unit_kerja }}">
                        @error('unit_kerja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3 form-group">
                    <label for="jenis_kepegawaian" class="col-md-4 col-lg-3 col-form-label">Jenis Kepegawaian</label>
                    <div class="col-md-6 col-lg-7">
                        <select class="form-select" aria-label="Default select example" name="jenis_kepegawaian" id="jenis_kepegawaian" required>
                            <option selected disabled>...</option>
                            <option value="PNS" {{ (old('jenis_kepegawaian') ?? $jabatan->jenis_kepegawaian)=='PNS' ? 'selected': '' }} >PNS</option>
                            <option value="PPPK" {{ (old('jenis_kepegawaian') ?? $jabatan->jenis_kepegawaian)=='PPPK' ? 'selected': '' }} >PPPK</option>
                            <option value="CPNS" {{ (old('jenis_kepegawaian') ?? $jabatan->jenis_kepegawaian)=='CPNS' ? 'selected': '' }} >CPNS</option>
                            <option value="BLUD" {{ (old('jenis_kepegawaian') ?? $jabatan->jenis_kepegawaian)=='BLUD' ? 'selected': '' }} >BLUD</option>
                        </select>
                        @error('jenis_kepegawaian')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3 form-group">
                    <label for="status" class="col-md-4 col-lg-3 col-form-label">Status Kedudukan Pegawai</label>
                    <div class="col-md-6 col-lg-7">
                        <select class="form-select" aria-label="Default select example" name="status" id="status">
                            <option selected disabled>...</option>
                            <option value="Aktif" {{ (old('status') ?? $jabatan->status)=='Aktif' ? 'selected': '' }} >Aktif</option>
                            <option value="CLTN" {{ (old('status') ?? $jabatan->status)=='CLTN' ? 'selected': '' }} >CLTN</option>
                            <option value="Tugas Belajar" {{ (old('status') ?? $jabatan->status)=='Tugas Belajar' ? 'selected': '' }} >Tugas Belajar</option>
                            <option value="Pemberhentian sementara" {{ (old('status') ?? $jabatan->status)=='Pemberhentian sementara' ? 'selected': '' }} >Pemberhentian sementara</option>
                            <option value="Penerima Uang Tunggu" {{ (old('status') ?? $jabatan->status)=='Penerima Uang Tunggu' ? 'selected': '' }} >Penerima Uang Tunggu</option>
                            <option value="Wajib Militer" {{ (old('status') ?? $jabatan->status)=='Wajib Militer' ? 'selected': '' }} >Wajib Militer</option>
                            <option value="Pejabat Negara" {{ (old('status') ?? $jabatan->status)=='Pejabat Negara' ? 'selected': '' }} >Pejabat Negara</option>
                            <option value="Kepala Desa" {{ (old('status') ?? $jabatan->status)=='Kepala Desa' ? 'selected': '' }} >Kepala Desa</option>
                            <option value="Proses Banding BAPEK" {{ (old('status') ?? $jabatan->status)=='Proses Banding BAPEK' ? 'selected': '' }} >Proses Banding BAPEK</option>
                            <option value="Masa Persiapan Pensiun" {{ (old('status') ?? $jabatan->status)=='Masa Persiapan Pensiun' ? 'selected': '' }} >Masa Persiapan Pensiun</option>
                            <option value="Pensiun" {{ (old('status') ?? $jabatan->status)=='Pensiun' ? 'selected': '' }} >Pensiun</option>
                            <option value="Calon CPNS" {{ (old('status') ?? $jabatan->status)=='Calon CPNS' ? 'selected': '' }} >Calon CPNS</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="section">
                <h6 class="border-bottom border-2 pb-2"><strong>JABATAN TERAKHIR</strong></h6>
                <div class="row mb-3 form-group">
                    <label for="jenis_jabatan" class="col-md-4 col-lg-3 col-form-label">Jenis Jabatan</label>
                    <div class="col-md-6 col-lg-7">
                        <select class="form-select" aria-label="Default select example" name="jenis_jabatan" id="jenis_jabatan">
                            <option selected disabled>...</option>
                            <option value="Struktural" {{ (old('jenis_jabatan') ?? $jabatan->jenis_jabatan)=='Struktural' ? 'selected': '' }} >Struktural</option>
                            <option value="Fungsional Khusus" {{ (old('jenis_jabatan') ?? $jabatan->jenis_jabatan)=='Fungsional Khusus' ? 'selected': '' }} >Fungsional Khusus</option>
                            <option value="Fungsional Umum" {{ (old('jenis_jabatan') ?? $jabatan->jenis_jabatan)=='Fungsional Umum' ? 'selected': '' }} >Fungsional Umum</option>
                            <option value="Sekretaris Desa" {{ (old('jenis_jabatan') ?? $jabatan->jenis_jabatan)=='Sekretaris Desa' ? 'selected': '' }} >Sekretaris Desa</option>
                        </select>
                    </div>
                    @error('jenis_jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row mb-3">
                    <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama Jabatan</label>
                    <div class="col-md-6 col-lg-7">
                        <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') ?? $jabatan->nama }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
        <h6 class="text-center"><em>Belum ada jabatan</em></h6>
    @endif
</div><!-- End Jabatan view -->