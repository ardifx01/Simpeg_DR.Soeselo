<!-- Fiklat Pendidikan Umum Create -->
<div class="view mt-1">
    <form action="{{ route('pendidikan.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <label for="tingkat" class="col-md-4 col-lg-3 col-form-label">Tingkat Pendidikan</label>
            <div class="col-md-4 col-lg-3">
                <select class="form-select" aria-label="Default select example" name="tingkat" id="tingkat">
                    <option selected disabled>-- Pilihan --</option>
                    <option value="SD" {{ old('tingkat')=='SD' ? 'selected': '' }} >SD</option>
                    <option value="SMP" {{ old('tingkat')=='SMP' ? 'selected': '' }} >SMP</option>
                    <option value="SMA" {{ old('tingkat')=='SMA' ? 'selected': '' }} >SMA</option>
                    <option value="D3" {{ old('tingkat')=='D3' ? 'selected': '' }} >D3</option>
                    <option value="D4" {{ old('tingkat')=='D4' ? 'selected': '' }} >D4</option>
                    <option value="S1" {{ old('tingkat')=='S1' ? 'selected': '' }} >S1</option>
                    <option value="S2" {{ old('tingkat')=='S2' ? 'selected': '' }} >S2</option>
                    <option value="S3" {{ old('tingkat')=='S3' ? 'selected': '' }} >S3</option>
                </select>
                @error('tingkat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="jurusan" class="col-md-4 col-lg-3 col-form-label">Jurusan</label>
            <div class="col-md-8 col-lg-9">
                <input name="jurusan" type="text" class="form-control @error('jurusan') is-invalid @enderror" id="jurusan" value="{{ old('jurusan') }}" required>
                @error('jurusan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama Sekolah</label>
            <div class="col-md-8 col-lg-9">
                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="tahun_lulus" class="col-md-4 col-lg-3 col-form-label">Tahun Lulus</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tahun_lulus" type="text" class="form-control @error('tahun_lulus') is-invalid @enderror" id="tahun_lulus" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tahun_lulus') }}" required>
                    <button class="btn btn-outline-secondary" type="button" for="tahun_lulus" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                    @error('tahun_lulus')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="no_ijazah" class="col-md-4 col-lg-3 col-form-label">No Ijazah</label>
            <div class="col-md-4 col-lg-3">
                <input name="no_ijazah" type="text" class="form-control @error('no_ijazah') is-invalid @enderror" id="no_ijazah" value="{{ old('no_ijazah') }}" required>
                @error('no_ijazah')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="tanggal_ijazah" class="col-md-4 col-lg-3 col-form-label">Tanggal Ijazah</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group mb-3">
                    <input name="tanggal_ijazah" type="text" class="form-control @error('tanggal_ijazah') is-invalid @enderror" id="tanggal_ijazah" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tanggal_ijazah') }}" required>
                    <button class="btn btn-outline-secondary" type="button" for="tanggal_ijazah" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                    @error('tanggal_ijazah')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
</div><!-- End Pendidikan Umum Create -->