<select class="form-select" name="jenis" id="jenis" required>
    <option value="">Pilih jenis arsip</option>
    @php
        $options = [
            'SK CPNS', 'Surat Tugas', 'Surat Menghadapkan', 'Ijazah Pendidikan', 'Surat Nikah',
            'KTP', 'NPWP', 'Kartu Keluarga', 'Akta Lahir Keluarga', 'Pas Photo', 'FIP',
            'Konversi NIP', 'SK PNS', 'SK Kenaikan Pangkat', 'KPE', 'Karpeg', 'Taspen',
            'Karis / Karsu', 'SK Mutasi BKN / Gubernur', 'ASKES / BPJS', 'STTPL',
            'Sumpah Jabatan PNS', 'KGB', 'Rekomendasi Ijin Belajar', 'Ijin Belajar',
            'Penggunaan Gelar', 'Ujian Dinas', 'Penyesuaian Ijazah'
        ];
    @endphp
    @foreach ($options as $option)
        <option value="{{ $option }}" {{ $selected == $option ? 'selected' : '' }}>{{ $option }}</option>
    @endforeach
</select>
