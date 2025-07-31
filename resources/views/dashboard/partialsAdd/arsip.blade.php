<!-- Arsip view -->
<div class="view">
    <div class="d-flex justify-content-end">
        <!-- Button Trigger Upload Modal -->
        <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#uploadarsipModal">
            <i class="bi bi-plus-circle"></i> Upload Arsip
        </button>
        
        <!-- Upload Modal -->
        <div class="modal fade" id="uploadarsipModal" tabindex="-1" aria-labelledby="uploadarsipModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="uploadarsipModalLabel">Upload Arsip Kepegawaian</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data" style="display:inline;">
                        @csrf
                        <div class="container row">
                            <input type="hidden" name="pegawai_id" value="{{ isset($pegawai) && $pegawai ? $pegawai->id : '' }}">
                            <label for="jenis" class="col-md-4 col-lg-3 col-form-label">Nama Arsip</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select" aria-label="Default select example" name="jenis" id="jenis">
                                    <option selected>...</option>
                                    <option value="SK CPNS" {{ old('jenis')=='SK CPNS' ? 'selected': '' }} >SK CPNS</option>
                                    <option value="Surat Tugas" {{ old('jenis')=='Surat Tugas' ? 'selected': '' }} >Surat Tugas</option>
                                    <option value="Surat Menghadapkan" {{ old('jenis')=='Surat Menghadapkan' ? 'selected': '' }} >Surat Menghadapkan</option>
                                    <option value="Ijazah Pendidikan" {{ old('jenis')=='Ijazah Pendidikan' ? 'selected': '' }} >Ijazah Pendidikan (Pertama s.d Terakhir)</option>
                                    <option value="Surat Nikah" {{ old('jenis')=='Surat Nikah' ? 'selected': '' }} >Surat Nikah</option>
                                    <option value="KTP" {{ old('jenis')=='KTP' ? 'selected': '' }} >KTP</option>
                                    <option value="NPWP" {{ old('jenis')=='NPWP' ? 'selected': '' }} >NPWP</option>
                                    <option value="Kartu Keluarga" {{ old('jenis')=='Kartu Keluarga' ? 'selected': '' }} >Kartu Keluarga</option>
                                    <option value="Akta Lahir Keluarga" {{ old('jenis')=='Akta Lahir Keluarga' ? 'selected': '' }} >Akta Lahir Keluarga</option>
                                    <option value="Pas Photo" {{ old('jenis')=='Pas Photo' ? 'selected': '' }} >Pas Photo</option>
                                    <option value="FIP" {{ old('jenis')=='FIP' ? 'selected': '' }} >FIP</option>
                                    <option value="Konversi NIP" {{ old('jenis')=='Konversi NIP' ? 'selected': '' }} >Konversi NIP</option>
                                    <option value="SK PNS" {{ old('jenis')=='SK PNS' ? 'selected': '' }} >SK PNS</option>
                                    <option value="SK Kenaikan Pangkat" {{ old('jenis')=='SK Kenaikan Pangkat' ? 'selected': '' }} >SK Kenaikan Pangkat</option>
                                    <option value="KPE" {{ old('jenis')=='KPE' ? 'selected': '' }} >KPE</option>
                                    <option value="Karpeg" {{ old('jenis')=='Karpeg' ? 'selected': '' }} >Karpeg</option>
                                    <option value="Taspen" {{ old('jenis')=='Taspen' ? 'selected': '' }} >Taspen</option>
                                    <option value="Karis / Karsu" {{ old('jenis')=='Karis / Karsu' ? 'selected': '' }} >Karis / Karsu</option>
                                    <option value="SK Mutasi BKN / Gubernur" {{ old('jenis')=='SK Mutasi BKN / Gubernur' ? 'selected': '' }} >SK Mutasi BKN / Gubernur</option>
                                    <option value="ASKES / BPJS" {{ old('jenis')=='ASKES / BPJS' ? 'selected': '' }} >ASKES / BPJS</option>
                                    <option value="STTPL" {{ old('jenis')=='STTPL' ? 'selected': '' }} >STTPL</option>
                                    <option value="Sumpah Jabatan PNS" {{ old('jenis')=='Sumpah Jabatan PNS' ? 'selected': '' }} >Sumpah Jabatan PNS</option>
                                    <option value="KGB" {{ old('jenis')=='KGB' ? 'selected': '' }} >KGB</option>
                                    <option value="Rekomendasi Ijin Belajar" {{ old('jenis')=='Rekomendasi Ijin Belajar' ? 'selected': '' }} >Rekomendasi Ijin Belajar</option>
                                    <option value="Ijin Belajar" {{ old('jenis')=='Ijin Belajar' ? 'selected': '' }} >Ijin Belajar</option>
                                    <option value="Penggunaan Gelar" {{ old('jenis')=='Penggunaan Gelar' ? 'selected': '' }} >Penggunaan Gelar</option>
                                    <option value="Ujian Dinas" {{ old('jenis')=='Ujian Dinas' ? 'selected': '' }} >Ujian Dinas</option>
                                    <option value="Penyesuaian Ijazah" {{ old('jenis')=='Penyesuaian Ijazah' ? 'selected': '' }} >Penyesuaian Ijazah</option>
                                </select>
                            </div>
                            <div class="row mb-3 form-group">
                                <label for="file" class="col-md-4 col-lg-3 col-form-label">File</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="file" type="file" class="form-control @error('file') is-invalid @enderror" id="file" accept=".pdf" required>
                                    @error('file')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Save </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-90deg-left"></i> Cancel</button>
                    </form>
                    </div>
                </div>
            </div>
        </div><!-- End Upload Modal -->
    </div>
    <div class="table-responsive small">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr class="text-center align-middle">
                    <th>No</th>
                    <th>Nama Arsip</th>
                    <th>File</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $arsips = isset($pegawai) && $pegawai ? $pegawai->arsips : [];
                @endphp
                @forelse ($arsips as $arsip)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $arsip->jenis }}</td>
                    <td><a href="{{ route('arsip.view', $arsip->id) }}" target="_blank" class="text-danger fw-bold">
                        <i class="bi bi-file-earmark-pdf fs-4"></i></a>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <!-- Button Trigger Edit Modal -->
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarsipModal{{ $arsip->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusarsipModal{{ $arsip->id }}">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editarsipModal{{ $arsip->id }}" tabindex="-1" aria-labelledby="editarsipModalLabel{{ $arsip->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="editarsipModalLabel{{ $arsip->id }}">Edit Arsip Kepegawaian</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="{{ route('arsip.update', $arsip->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="container row">
                                            <input type="hidden" name="pegawai_id" value="{{ isset($pegawai) && $pegawai ? $pegawai->id : '' }}">
                                            <label for="jenis_edit_{{ $arsip->id }}" class="col-md-4 col-lg-3 col-form-label">Nama Arsip</label>
                                            <div class="col-md-8 col-lg-9 mb-3">
                                                <select class="form-select" aria-label="Default select example" name="jenis" id="jenis_edit_{{ $arsip->id }}">
                                                    <option selected>...</option>
                                                    <option value="SK CPNS" {{ (old('jenis') ?? $arsip->jenis)=='SK CPNS' ? 'selected': '' }} >SK CPNS</option>
                                                    <option value="Surat Tugas" {{ (old('jenis') ?? $arsip->jenis)=='Surat Tugas' ? 'selected': '' }} >Surat Tugas</option>
                                                    <option value="Surat Menghadapkan" {{ (old('jenis') ?? $arsip->jenis)=='Surat Menghadapkan' ? 'selected': '' }} >Surat Menghadapkan</option>
                                                    <option value="Ijazah Pendidikan" {{ (old('jenis') ?? $arsip->jenis)=='Ijazah Pendidikan' ? 'selected': '' }} >Ijazah Pendidikan (Pertama s.d Terakhir)</option>
                                                    <option value="Surat Nikah" {{ (old('jenis') ?? $arsip->jenis)=='Surat Nikah' ? 'selected': '' }} >Surat Nikah</option>
                                                    <option value="KTP" {{ (old('jenis') ?? $arsip->jenis)=='KTP' ? 'selected': '' }} >KTP</option>
                                                    <option value="NPWP" {{ (old('jenis') ?? $arsip->jenis)=='NPWP' ? 'selected': '' }} >NPWP</option>
                                                    <option value="Kartu Keluarga" {{ (old('jenis') ?? $arsip->jenis)=='Kartu Keluarga' ? 'selected': '' }} >Kartu Keluarga</option>
                                                    <option value="Akta Lahir Keluarga" {{ (old('jenis') ?? $arsip->jenis)=='Akta Lahir Keluarga' ? 'selected': '' }} >Akta Lahir Keluarga</option>
                                                    <option value="Pas Photo" {{ (old('jenis') ?? $arsip->jenis)=='Pas Photo' ? 'selected': '' }} >Pas Photo</option>
                                                    <option value="FIP" {{ (old('jenis') ?? $arsip->jenis)=='FIP' ? 'selected': '' }} >FIP</option>
                                                    <option value="Konversi NIP" {{ (old('jenis') ?? $arsip->jenis)=='Konversi NIP' ? 'selected': '' }} >Konversi NIP</option>
                                                    <option value="SK PNS" {{ (old('jenis') ?? $arsip->jenis)=='SK PNS' ? 'selected': '' }} >SK PNS</option>
                                                    <option value="SK Kenaikan Pangkat" {{ (old('jenis') ?? $arsip->jenis)=='SK Kenaikan Pangkat' ? 'selected': '' }} >SK Kenaikan Pangkat</option>
                                                    <option value="KPE" {{ (old('jenis') ?? $arsip->jenis)=='KPE' ? 'selected': '' }} >KPE</option>
                                                    <option value="Karpeg" {{ (old('jenis') ?? $arsip->jenis)=='Karpeg' ? 'selected': '' }} >Karpeg</option>
                                                    <option value="Taspen" {{ (old('jenis') ?? $arsip->jenis)=='Taspen' ? 'selected': '' }} >Taspen</option>
                                                    <option value="Karis / Karsu" {{ (old('jenis') ?? $arsip->jenis)=='Karis / Karsu' ? 'selected': '' }} >Karis / Karsu</option>
                                                    <option value="SK Mutasi BKN / Gubernur" {{ (old('jenis') ?? $arsip->jenis)=='SK Mutasi BKN / Gubernur' ? 'selected': '' }} >SK Mutasi BKN / Gubernur</option>
                                                    <option value="ASKES / BPJS" {{ (old('jenis') ?? $arsip->jenis)=='ASKES / BPJS' ? 'selected': '' }} >ASKES / BPJS</option>
                                                    <option value="STTPL" {{ (old('jenis') ?? $arsip->jenis)=='STTPL' ? 'selected': '' }} >STTPL</option>
                                                    <option value="Sumpah Jabatan PNS" {{ (old('jenis') ?? $arsip->jenis)=='Sumpah Jabatan PNS' ? 'selected': '' }} >Sumpah Jabatan PNS</option>
                                                    <option value="KGB" {{ (old('jenis') ?? $arsip->jenis)=='KGB' ? 'selected': '' }} >KGB</option>
                                                    <option value="Rekomendasi Ijin Belajar" {{ (old('jenis') ?? $arsip->jenis)=='Rekomendasi Ijin Belajar' ? 'selected': '' }} >Rekomendasi Ijin Belajar</option>
                                                    <option value="Ijin Belajar" {{ (old('jenis') ?? $arsip->jenis)=='Ijin Belajar' ? 'selected': '' }} >Ijin Belajar</option>
                                                    <option value="Penggunaan Gelar" {{ (old('jenis') ?? $arsip->jenis)=='Penggunaan Gelar' ? 'selected': '' }} >Penggunaan Gelar</option>
                                                    <option value="Ujian Dinas" {{ (old('jenis') ?? $arsip->jenis)=='Ujian Dinas' ? 'selected': '' }} >Ujian Dinas</option>
                                                    <option value="Penyesuaian Ijazah" {{ (old('jenis') ?? $arsip->jenis)=='Penyesuaian Ijazah' ? 'selected': '' }} >Penyesuaian Ijazah</option>
                                                </select>
                                            </div>
                                            <div class="row mb-3 form-group">
                                                <label for="file_edit_{{ $arsip->id }}" class="col-md-4 col-lg-3 col-form-label">File</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="file" type="file" class="form-control @error('file') is-invalid @enderror" id="file_edit_{{ $arsip->id }}" accept=".pdf" required>
                                                    @error('file')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Save </button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-90deg-left"></i> Cancel</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Edit Modal -->

                        <!-- Confirm Delete Modal -->
                        <div class="modal fade" id="hapusarsipModal{{ $arsip->id }}" tabindex="-1" aria-labelledby="hapusarsipModalLabel{{ $arsip->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusarsipModalLabel{{ $arsip->id }}">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda Yakin Ingin Menghapus <strong>{{ $arsip->jenis }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('arsip.destroy', $arsip->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div><!-- End Arsip view -->