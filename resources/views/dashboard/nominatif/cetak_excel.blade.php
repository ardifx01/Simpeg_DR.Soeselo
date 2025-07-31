<table>
    <thead>
        <tr>
            @foreach ($displayColumns as $col)
                <th>{{ $col }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse ($pegawais as $index => $pegawai)
        <tr>
            @foreach ($displayColumns as $key => $col)
                <td>
                    @switch($key)
                        @case('no')
                            {{ $index + 1 }}
                            @break
                        @case('nip')
                            {{ $pegawai ->nip ?? '-' }}
                            @break
                        @case('nama')
                            {{ $pegawai->nama ?? '-' }}
                            @break
                        @case('tempat_lahir')
                            {{ $pegawai->tempat_lahir ?? '-' }}
                            @break
                        @case('tanggal_lahir')
                            {{ $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                            @break
                        @case('agama')
                            {{ $pegawai->agama ?? '-' }}
                            @break
                        @case('jenis_kelamin')
                            {{ $pegawai->jenis_kelamin ?? '-' }}
                            @break
                        @case('alamat')
                            {{
                                collect([
                                    $pegawai->alamat,
                                    $pegawai->rt ? 'RT ' . $pegawai->rt : null,
                                    $pegawai->rw ? 'RW ' . $pegawai->rw : null,
                                    $pegawai->desa ? 'Desa ' . $pegawai->desa : null,
                                    $pegawai->kecamatan ? 'Kec. ' . $pegawai->kecamatan : null,
                                    $pegawai->kabupaten ? 'Kab. ' . $pegawai->kabupaten : null,
                                    $pegawai->provinsi ? 'Prov. ' . $pegawai->provinsi : null,
                                    $pegawai->pos ? 'Kode Pos ' . $pegawai->pos : null
                                ])->filter()->implode(', ') ?: '-'
                            }}
                            @break
                        @case('telepon')
                            {{ $pegawai->telepon ?? '-' }}
                            @break
                        @case('no_npwp')
                            {{ $pegawai->no_npwp ?? '-' }}
                            @break
                        @case('no_ktp')
                            {{ $pegawai->no_ktp ?? '-' }}
                            @break
                        @case('status')
                            {{ optional($pegawai->jabatan)->status ?? '-' }}
                            @break
                        @case('jenis_kepegawaian')
                            {{ optional($pegawai->jabatan)->jenis_kepegawaian ?? '-' }}
                            @break
                        @case('tmt_golongan_ruang_cpns')
                            {{ $pegawai->tmt_golongan_ruang_cpns ? \Carbon\Carbon::parse($pegawai->tmt_golongan_ruang_cpns)->translatedFormat('d F Y') : '-' }}
                            @break
                        @case('tmt_pns')
                            {{ $pegawai->tmt_pns ? \Carbon\Carbon::parse($pegawai->tmt_pns)->translatedFormat('d F Y') : '-' }}
                            @break
                        @case('pangkat')
                            {{ optional($pegawai->jabatan)->pangkat ?? '-' }}
                            @break
                        @case('golongan_ruang')
                            {{ optional($pegawai->jabatan)->golongan_ruang ?? '-' }}
                            @break
                        @case('tingkat')
                            {{ optional($pegawai->pendidikans->sortByDesc('tahun_lulus')->first())->tingkat ?? '-' }}
                            @break
                        @case('jurusan')
                            {{ optional($pegawai->pendidikans->sortByDesc('tahun_lulus')->first())->jurusan ?? '-' }}
                            @break
                        @case('nama_sekolah')
                            {{ optional($pegawai->pendidikans->sortByDesc('tahun_lulus')->first())->nama_sekolah ?? '-' }}
                            @break
                        @case('tahun_lulus')
                            {{ optional($pegawai->pendidikans->sortByDesc('tahun_lulus')->first())->tahun_lulus ?? '-' }}
                            @break
                        @case('unit_kerja')
                            {{ optional($pegawai->jabatan)->skpd ?? '-' }}
                            @break
                        @case('nama_jabatan')
                            {{ optional($pegawai->jabatan)->nama_jabatan ?? '-' }}
                            @break
                        @case('jenis_jabatan')
                            {{ optional($pegawai->jabatan)->jenis_jabatan ?? '-' }}
                            @break
                        @case('tmt_golongan_ruang')
                            {{ optional($pegawai->jabatan)->tmt_golongan_ruang ? \Carbon\Carbon::parse(optional($pegawai->jabatan)->tmt_golongan_ruang)->translatedFormat('d F Y') : '-' }}
                            @break
                        @case('eselon')
                            {{ optional($pegawai->jabatan)->eselon ?? '-' }}
                            @break
                        @default
                            {{ $pegawai[$key] ?? '-' }}
                    @endswitch
                </td>
            @endforeach
        </tr>
        @empty
        <tr>
            <td colspan="{{ count($displayColumns) }}">Tidak ada data pegawai ditemukan.</td>
        </tr>
        @endforelse
    </tbody>
</table>