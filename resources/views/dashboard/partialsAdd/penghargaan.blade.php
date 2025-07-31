<!-- Fiklat Penghargaan create -->
<div class="view mt-1">
    <form action="{{ route('penghargaan.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama Tanda Jasa / Penghargaan</label>
            <div class="col-md-8 col-lg-9">
                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="pemberi" class="col-md-4 col-lg-3 col-form-label">Pemberi</label>
            <div class="col-md-8 col-lg-9">
                <input name="pemberi" type="text" class="form-control @error('pemberi') is-invalid @enderror" id="pemberi" value="{{ old('pemberi') }}" required>
                @error('pemberi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="tahun" class="col-md-4 col-lg-3 col-form-label">Tahun</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tahun" type="text" class="form-control @error('tahun') is-invalid @enderror" id="tahun" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tahun') }}" required>
                    @error('tahun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <button class="btn btn-outline-secondary" type="button" for="tahun" id="button-addon2"><i class="bi bi-calendar3"></i></button>
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
</div><!-- End Penghargaan create -->