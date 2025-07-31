<!-- Arsip view -->
<div class="view">
    <div class="d-flex justify-content-end">
        <!-- Button Trigger Upload Modal -->
        <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#uploadarsipModal{{$pegawai->id}}">
            <i class="bi bi-plus-circle"></i> Upload Arsip
        </button>
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadarsipModal{{$pegawai->id}}" tabindex="-1" aria-labelledby="uploadarsipModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="uploadarsipModalLabel">Upload Arsip Kepegawaian</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container row">
                            <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                            <label for="jenis" class="col-md-4 col-lg-3 col-form-label">Nama Arsip</label>
                            <div class="col-md-8 col-lg-9 mb-3">
                                @include('components.arsip-jenis-dropdown', ['selected' => old('jenis')])
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
                    </div>
                </div>
            </form>
        </div>
    </div><!-- End Upload Modal -->

    <div class="table-responsive small">
        <table class="table table-bordered table-striped table-hover align-middle text-center">
            <thead>
                <tr class="text-center align-middle">
                    <th style="width: 50px;">No</th>
                    <th>Nama Arsip</th>
                    <th>File</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawai->arsips as $arsip)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $arsip->jenis }}</td>
                    <td class="text-center">
                        <a href="{{ route('arsip.view', $arsip->id) }}" target="_blank" class="text-danger fw-bold">
                            <i class="bi bi-file-earmark-pdf fs-4"></i>
                        </a>
                        {{-- <button onclick="showPreview('{{ asset('storage/' . $arsip->file) }}')" class="btn btn-sm btn-info">
                            Preview
                        </button> --}}
                        <!-- Modal preview -->
                        <div class="modal fade" id="previewModal" tabindex="-1">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <iframe id="pdfPreviewFrame" src="" style="width: 100%; height: 80vh;" frameborder="0"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarsipModal{{ $arsip->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <!-- Delete Button -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusarsipModal{{ $arsip->id }}">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editarsipModal{{$arsip->id}}" tabindex="-1" aria-labelledby="editarsipModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('arsip.update', $arsip->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editarsipModalLabel">Edit Arsip Kepegawaian</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container row">
                                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                                <label for="jenis" class="col-md-4 col-lg-3 col-form-label">Nama Arsip</label>
                                                <div class="col-md-8 col-lg-9 mb-3">
                                                    @include('components.arsip-jenis-dropdown', ['selected' => old('jenis') ?? $arsip->jenis])
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
                                            <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Save</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-90deg-left"></i> Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!-- End Edit Modal -->

                        <!-- Delete Modal -->
                        <div class="modal fade" id="hapusarsipModal{{ $arsip->id }}" tabindex="-1" aria-labelledby="hapusarsipModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('arsip.destroy', $arsip->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="hapusarsipModalLabel">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus <strong>{{ $arsip->jenis }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!-- End Delete Modal -->

                    </td>
                </tr>                                
                @endforeach
            </tbody>
        </table>
    </div>
</div><!-- End Arsip view -->
<script>
  function showPreview(fileUrl) {
    document.getElementById('pdfPreviewFrame').src = fileUrl;
    new bootstrap.Modal(document.getElementById('previewModal')).show();
  }
</script>