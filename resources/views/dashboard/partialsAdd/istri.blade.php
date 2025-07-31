<!-- Istri create -->
<div class="view mt-1">
    <form action="{{ route('istri.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama</label>
            <div class="col-md-8 col-lg-9">
                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="tempat_lahir_istri" class="col-md-4 col-lg-3 col-form-label">Tempat, Tanggal Lahir</label>
            <div class="col-md-4 col-lg-3">
                <input name="tempat_lahir_istri" type="text" class="form-control @error('tempat_lahir_istri') is-invalid @enderror" id="tempat_lahir_istri" value="{{ old('tempat_lahir_istri') }}" required>
                @error('tempat_lahir_istri')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tanggal_lahir_istri" type="text" class="form-control @error('tanggal_lahir_istri') is-invalid @enderror" id="tanggal_lahir_istri" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tanggal_lahir_istri') }}" required>
                    <button class="btn btn-outline-secondary" type="button" for="tanggal_lahir_istri" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                    @error('tanggal_lahir_istri')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="profesi" class="col-md-4 col-lg-3 col-form-label">Profesi</label>
            <div class="col-md-8 col-lg-9">
                <input name="profesi" type="text" class="form-control" id="profesi" value="{{ old('profesi') }}" required>
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="tanggal_nikah" class="col-md-4 col-lg-3 col-form-label">Tanggal Nikah</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tanggal_nikah" type="text" class="form-control @error('tanggal_nikah') is-invalid @enderror" id="tanggal_nikah" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tanggal_nikah') }}" required>
                    <button class="btn btn-outline-secondary" type="button" for="tanggal_nikah" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                    @error('tanggal_nikah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="status_hubungan" class="col-md-4 col-lg-3 col-form-label">Status Hubungan</label>
            <div class="col-md-4 col-lg-3">
                <select class="form-select" aria-label="Default select example" name="status_hubungan" id="status_hubungan" required>
                    <option selected disabled>-- Pilihan --</option>
                    <option value="Suami" {{ old('status_hubungan')=='Suami' ? 'selected': '' }} >Suami</option>
                    <option value="Istri" {{ old('status_hubungan')=='Istri' ? 'selected': '' }} >Istri</option>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="text-center p-2">
                <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> save</button>
            </div>
            <div class="text-center p-2">
                <a href="{{ route('istri.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-90deg-left"></i> cancel</a>
            </div>
        </div>
    </form>
</div><!-- End Istri create -->