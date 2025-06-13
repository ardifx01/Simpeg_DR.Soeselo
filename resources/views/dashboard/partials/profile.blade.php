
<div class="row">
    <div class="col-xl-3 pt-4 d-flex flex-column align-items-center">
        @if($pegawai->image)
        <img src="{{ asset('storage/' . $pegawai->image) }}" alt="project-image" class="rounded" height="250px">
        @else
        <img src="{{ asset('assets/img/nophoto.jpg') }}" alt="project-image" class="rounded">
        @endif
    </div>

    <div class="col-xl-8 ms-4 mt-4">
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Nama Lengkap</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->nama }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">NIP</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->nip }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">NIP Lama</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->nip_lama }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">No. Karpeg</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->no_karpeg }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">No.KPE</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->no_kpe }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">No. KTP</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->no_ktp }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">No. NPWP</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->no_npwp }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Gelar Depan</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->gelar_depan }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Gelar Belakang</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->gelar_belakang }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Tempat, Tanggal Lahir</div>
        <div class="col-6 col-lg-8 col-md-8">: <i class="bi bi-geo-alt-fill"></i> {{ $pegawai->tempat_lahir }}, {{ $pegawai->tanggal_lahir }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Jenis Kelamin</div>
        <div class="col-6 col-lg-8 col-md-8">: <i class="bi bi-gender-ambiguous"></i> {{ $pegawai->jenis_kelamin }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Agama</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->agama }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Status Perkawinan</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->status_nikah }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Alamat</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->alamat }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Telepon</div>
        <div class="col-6 col-lg-8 col-md-8">: <i class="bi bi-phone"></i> {{ $pegawai->telepon }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Tingkat Pendidikan</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->tingkat_pendidikan }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Nama Pendidikan</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->nama_pendidikan }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Nama Sekolah</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->nama_sekolah }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Tahun Lulus</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->tahun_lulus }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Golongan Ruang</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->golongan_ruang }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">TMT Golongan Ruang</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->tmt_golongan_ruang }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Golongan ruang CPNS</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->golongan_ruang_cpns }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">TMT Golongan Ruang CPNS</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->tmt_golongan_ruang_cpns }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">TMT PNS</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->tmt_pns }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Jenis Kepegawaian</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->jenis_kepegawaian }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Status Hukum</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->status_hukum }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">SKPD</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->skpd }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Jenis Jabatan</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->jenis_jabatan }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Jabatan Fungsional</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->jabatan_fungsional }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">TMT Jabatan</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->tmt_jabatan }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Diklat Pimpinan</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->diklat_pimpinan }}</div>
        </div>
        <div class="row">
        <div class="col-6 col-lg-4 col-md-4 label">Tahun Diklat Pimpinan</div>
        <div class="col-6 col-lg-8 col-md-8">: {{ $pegawai->tahun_diklat_pimpinan }}</div>
        </div>
    </div>
</div>