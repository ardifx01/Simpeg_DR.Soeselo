<!-- Anak create -->
<div class="view mt-1">
    <form action="{{ route('anak.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <label for="Nama" class="col-md-4 col-lg-3 col-form-label">Nama</label>
            <div class="col-md-8 col-lg-9">
                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="tempat_lahir_anak" class="col-md-4 col-lg-3 col-form-label">Tempat, Tanggal Lahir</label>
            <div class="col-md-4 col-lg-3">
                <input name="tempat_lahir_anak" type="text" class="form-control @error('tempat_lahir_anak') is-invalid @enderror" id="tempat_lahir_anak" value="{{ old('tempat_lahir_anak') }}" required>
                @error('tempat_lahir_anak')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tanggal_lahir_anak_anak" type="text" class="form-control @error('tanggal_lahir_anak') is-invalid @enderror" id="tanggal_lahir_anak" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tanggal_lahir_anak') }}" required>
                    <button class="btn btn-outline-secondary" type="button" for="tanggal_lahir_anak" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                    @error('tanggal_lahir_anak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="status_keluarga" class="col-md-4 col-lg-3 col-form-label">Status Keluarga</label>
            <div class="col-md-4 col-lg-3">
                <select class="form-select" aria-label="Default select example" name="status_keluarga" id="status_keluarga">
                    <option selected>-- Pilihan --</option>
                    <option value="Anak Kandung" {{ old('status_keluarga')=='Anak Kandung' ? 'selected': '' }} >Anak Kandung</option>
                    <option value="Anak Angkat" {{ old('status_keluarga')=='Anak Angkat' ? 'selected': '' }} >Anak Angkat</option>
                    <option value="Anak Tiri" {{ old('status_keluarga')=='Anak Tiri' ? 'selected': '' }} >Anak Tiri</option>
                </select>
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="status_tunjangan" class="col-md-4 col-lg-3 col-form-label">Status Tunjangan</label>
            <div class="col-md-4 col-lg-3">
                <select class="form-select" aria-label="Default select example" name="status_tunjangan" id="status_tunjangan">
                    <option selected>-- Pilihan --</option>
                    <option value="Dapat" {{ old('status_tunjangan')=='Dapat' ? 'selected': '' }} >Dapat</option>
                    <option value="Tidak Dapat" {{ old('status_tunjangan')=='Tidak Dapat' ? 'selected': '' }} >Tidak Dapat</option>
                </select>
            </div>
        </div>

        <div class="row mb-3 form-group">
            <label class="col-md-4 col-lg-3 col-form-label">Jenis Kelamin</label>
            <div class="col-md-8 col-lg-9 mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="laki_laki" value="Laki-laki">
                    <label class="form-check-label" for="laki_laki">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan">
                    <label class="form-check-label" for="perempuan">Perempuan</label>
                </div>
                @error('jenis_kelamin')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="d-flex justify-content-center">
            <div class="text-center p-2">
                <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> save</button>
            </div>
            <div class="text-center p-2">
                <a href="{{ route('anak.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-90deg-left"></i> cancel</a>
            </div>
        </div>
    </form>
</div><!-- End Anak create -->