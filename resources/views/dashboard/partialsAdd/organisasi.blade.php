<!-- Organisasi create -->
<div class="view mt-1">
    <form action="{{ route('organisasi.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama Organisasi</label>
            <div class="col-md-8 col-lg-9">
                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="jenis" class="col-md-4 col-lg-3 col-form-label">Jenis Organisasi</label>
            <div class="col-md-8 col-lg-9">
                <input name="jenis" type="text" class="form-control @error('jenis') is-invalid @enderror" id="jenis" value="{{ old('jenis') }}" required>
                @error('jenis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="jabatan" class="col-md-4 col-lg-3 col-form-label">Jabatan</label>
            <div class="col-md-8 col-lg-9">
                <input name="jabatan" type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" value="{{ old('jabatan') }}" required>
                @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="tmt" class="col-md-4 col-lg-3 col-form-label">TMT</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tmt" type="text" class="form-control @error('tmt') is-invalid @enderror" id="tmt" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tmt') }}" required>
                    @error('tmt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <button class="btn btn-outline-secondary" type="button" for="tmt" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="text-center p-2">
                <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> save</button>
            </div>
            <div class="text-center p-2">
                <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-arrow-90deg-left"></i> cancel</button>
            </div>
        </div>
    </form>
</div><!-- End Organisasi create -->