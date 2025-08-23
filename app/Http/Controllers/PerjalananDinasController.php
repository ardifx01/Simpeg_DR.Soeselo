<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PerjalananDinas;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class PerjalananDinasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));

        $data = PerjalananDinas::with(['pegawai', 'kuasaPenggunaAnggaran'])
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('nomor', 'like', "%{$search}%")
                        ->orWhere('maksud_perjalanan', 'like', "%{$search}%")
                        ->orWhere('tempat_berangkat', 'like', "%{$search}%")
                        ->orWhere('tempat_tujuan', 'like', "%{$search}%")
                        ->orWhere('tingkat_biaya', 'like', "%{$search}%")
                        ->orWhere('alat_angkut', 'like', "%{$search}%")
                        ->orWhereHas('pegawai', function ($q2) use ($search) {
                            $q2->where('nama', 'like', "%{$search}%")
                                ->orWhere('nip', 'like', "%{$search}%");
                        })
                        ->orWhereHas('kuasaPenggunaAnggaran', function ($q3) use ($search) {
                            $q3->where('nama', 'like', "%{$search}%")
                                ->orWhere('nip', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('tanggal_berangkat')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('surat.perjalanan_dinas.index', [
            'perjalanan' => $data,
            'search'     => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.perjalanan_dinas.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // helper: array/string → string, trim tiap item
        $toLines = function ($val) {
            if (is_array($val)) {
                return implode(PHP_EOL, array_filter(array_map('trim', $val)));
            }
            return trim((string) $val);
        };

        // Validasi
        $validated = $request->validate([
            'lembar_ke'                  => 'nullable|string|max:191',
            'kode_no'                    => 'nullable|string|max:191',
            'nomor'                      => 'required|string|max:191|unique:perjalanan_dinas,nomor',

            'pegawai_id'                 => 'required|exists:pegawais,id',
            'kuasa_pengguna_anggaran_id' => 'required|exists:pegawais,id',

            'tingkat_biaya'              => 'required|string|max:191',
            'maksud_perjalanan'          => 'required',
            'alat_angkut'                => 'required|string|max:191',
            'tempat_berangkat'           => 'required|string|max:191',
            'tempat_tujuan'              => 'required|string|max:191',
            'lama_perjalanan'            => 'required|integer|min:0',

            'tanggal_berangkat'          => 'required|date_format:d-m-Y',
            'tanggal_kembali'            => 'required|date_format:d-m-Y|after_or_equal:tanggal_berangkat',
            'tanggal_dikeluarkan'        => 'required|date_format:d-m-Y',

            'skpd_pembebanan'            => 'required|string|max:191',
            'kode_rekening_pembebanan'   => 'required|string|max:191',
            'keterangan_lain'            => 'nullable|string',

            'pengikut'                   => 'nullable|array',
            'pengikut.*.nama'            => 'required_with:pengikut|string|max:191',
            'pengikut.*.tgl_lahir'       => 'nullable|string',
            'pengikut.*.keterangan'      => 'nullable|string',

            'riwayat_perjalanan'         => 'nullable|array',
            'riwayat_perjalanan.*'       => 'array',
        ]);

        // Konversi tanggal → format DB
        $validated['tanggal_berangkat']   = Carbon::createFromFormat('d-m-Y', $validated['tanggal_berangkat'])->format('Y-m-d');
        $validated['tanggal_kembali']     = Carbon::createFromFormat('d-m-Y', $validated['tanggal_kembali'])->format('Y-m-d');
        $validated['tanggal_dikeluarkan'] = Carbon::createFromFormat('d-m-Y', $validated['tanggal_dikeluarkan'])->format('Y-m-d');

        // Normalisasi teks panjang (kalau kamu input list array di form, ini gabung per baris)
        $validated['maksud_perjalanan'] = $toLines($request->input('maksud_perjalanan'));
        $validated['keterangan_lain']   = $toLines($request->input('keterangan_lain'));

        // Map pengikut: parse tgl_lahir d-m-Y -> Y-m-d & buang baris kosong
        $pengikut = collect($request->input('pengikut', []))
            ->filter(function ($row) {
                // keep kalau ada minimal salah satu field terisi
                if (!is_array($row)) return false;
                $joined = trim(implode('', array_map(fn($v) => (string) $v, $row)));
                return $joined !== '';
            })
            ->map(function ($row) {
                $nama = trim((string)($row['nama'] ?? ''));
                $ket  = trim((string)($row['keterangan'] ?? ''));
                $tgl  = $row['tgl_lahir'] ?? null;
                // parse tanggal kalau format d-m-Y
                if (is_string($tgl) && preg_match('/^\d{2}-\d{2}-\d{4}$/', $tgl)) {
                    $tgl = Carbon::createFromFormat('d-m-Y', $tgl)->format('Y-m-d');
                } elseif (!is_string($tgl) || $tgl === '') {
                    $tgl = null;
                }
                return [
                    'nama'       => $nama,
                    'tgl_lahir'  => $tgl,
                    'keterangan' => $ket,
                ];
            })
            ->values()
            ->all();

        $validated['pengikut'] = $pengikut;

        $validated['riwayat_perjalanan'] = $request->input('riwayat_perjalanan', null);

        PerjalananDinas::create($validated);

        return redirect()->route('perjalanan_dinas.index')->with('success', 'Perjalanan dinas berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PerjalananDinas $perjalananDinas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerjalananDinas $perjalananDinas)
    {
        $pegawais = Pegawai::orderBy('nama')->get();
        return view('surat.perjalanan_dinas.edit', [
            'item'     => $perjalananDinas,
            'pegawais' => $pegawais,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerjalananDinas $perjalanan_dina)
    {
        $toLines = function ($val) {
            if (is_array($val)) {
                return implode(PHP_EOL, array_filter(array_map('trim', $val)));
            }
            return trim((string) $val);
        };

        $validated = $request->validate([
            'lembar_ke'                  => 'nullable|string|max:191',
            'kode_no'                    => 'nullable|string|max:191',
            'nomor'                      => [
                'required','string','max:191',
                Rule::unique('perjalanan_dinas','nomor')->ignore($perjalanan_dina->id),
            ],
            'pegawai_id'                 => 'required|exists:pegawais,id',
            'kuasa_pengguna_anggaran_id' => 'required|exists:pegawais,id',
            'tingkat_biaya'              => 'required|string|max:191',
            'maksud_perjalanan'          => 'required',
            'alat_angkut'                => 'required|string|max:191',
            'tempat_berangkat'           => 'required|string|max:191',
            'tempat_tujuan'              => 'required|string|max:191',
            'lama_perjalanan'            => 'required|integer|min:0',
            'tanggal_berangkat'          => 'required|date_format:d-m-Y',
            'tanggal_kembali'            => 'required|date_format:d-m-Y|after_or_equal:tanggal_berangkat',
            'tanggal_dikeluarkan'        => 'required|date_format:d-m-Y',
            'skpd_pembebanan'            => 'required|string|max:191',
            'kode_rekening_pembebanan'   => 'required|string|max:191',
            'keterangan_lain'            => 'nullable|string',

            'pengikut'                   => 'nullable|array',
            'pengikut.*.nama'            => 'required_with:pengikut|string|max:191',
            'pengikut.*.tgl_lahir'       => 'nullable|string',
            'pengikut.*.keterangan'      => 'nullable|string',

            'riwayat_perjalanan'         => 'nullable|array',
            'riwayat_perjalanan.*'       => 'array',
        ]);

        $validated['tanggal_berangkat']   = Carbon::createFromFormat('d-m-Y', $validated['tanggal_berangkat'])->format('Y-m-d');
        $validated['tanggal_kembali']     = Carbon::createFromFormat('d-m-Y', $validated['tanggal_kembali'])->format('Y-m-d');
        $validated['tanggal_dikeluarkan'] = Carbon::createFromFormat('d-m-Y', $validated['tanggal_dikeluarkan'])->format('Y-m-d');

        $validated['maksud_perjalanan'] = $toLines($request->input('maksud_perjalanan'));
        $validated['keterangan_lain']   = $toLines($request->input('keterangan_lain'));

        $pengikut = collect($request->input('pengikut', []))
            ->filter(fn($row) => is_array($row) && trim(implode('', array_map(fn($v)=>(string)$v, $row))) !== '')
            ->map(function ($row) {
                $tgl = $row['tgl_lahir'] ?? null;
                if (is_string($tgl) && preg_match('/^\d{2}-\d{2}-\d{4}$/', $tgl)) {
                    $tgl = Carbon::createFromFormat('d-m-Y', $tgl)->format('Y-m-d');
                } elseif (!is_string($tgl) || $tgl === '') {
                    $tgl = null;
                }
                return [
                    'nama'       => trim((string)($row['nama'] ?? '')),
                    'tgl_lahir'  => $tgl,
                    'keterangan' => trim((string)($row['keterangan'] ?? '')),
                ];
            })
            ->values()
            ->all();

        $validated['pengikut'] = $pengikut;
        $validated['riwayat_perjalanan'] = $request->input('riwayat_perjalanan', null);

        $perjalanan_dina->update($validated);

        return redirect()->route('perjalanan_dinas.index')->with('success', 'Perjalanan dinas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerjalananDinas $perjalanan_dina)
    {
        $perjalanan_dina->delete();
        return redirect()->route('perjalanan_dinas.index')->with('success', 'Perjalanan dinas berhasil dihapus.');
    }

    public function export($id)
    {
        $pd = PerjalananDinas::with(['pegawai.jabatan', 'kuasaPenggunaAnggaran.jabatan'])->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/perjalananDinas_template.docx'));

        // ======= Header / metadata (tetap) =======
        $template->setValue('lembar_ke', $pd->lembar_ke ?? '-');
        $template->setValue('kode_no', $pd->kode_no ?? '-');
        $template->setValue('nomor', $pd->nomor);
        $template->setValue('tingkat_biaya', $pd->tingkat_biaya);
        $template->setValue('maksud_perjalanan', $pd->maksud_perjalanan);
        $template->setValue('alat_angkut', $pd->alat_angkut);
        $template->setValue('tempat_berangkat', $pd->tempat_berangkat);
        $template->setValue('tempat_tujuan', $pd->tempat_tujuan);
        $template->setValue('lama_perjalanan', $pd->lama_perjalanan . ' hari');

        $template->setValue('tanggal_berangkat', $pd->tanggal_berangkat?->translatedFormat('d F Y') ?? '-');
        $template->setValue('tanggal_kembali', $pd->tanggal_kembali?->translatedFormat('d F Y') ?? '-');
        $template->setValue('tanggal_dikeluarkan', $pd->tanggal_dikeluarkan?->translatedFormat('d F Y') ?? '-');

        // ======= Pegawai yang diperintah (tetap) =======
        $template->setValue('nama_pegawai', $pd->pegawai->nama_lengkap ?? $pd->pegawai->nama ?? '-');
        $template->setValue('nip_pegawai', $pd->pegawai->nip ?? '-');
        $template->setValue('jabatan_pegawai', optional($pd->pegawai->jabatan)->nama_jabatan ?? '-');
        $template->setValue('pangkat_pegawai', $pd->pegawai->pangkat_golongan ?? '-');

        // ======= Kuasa Pengguna Anggaran (tetap) =======
        $kpa = $pd->kuasaPenggunaAnggaran;
        $template->setValue('nama_kpa', $kpa->nama_lengkap ?? $kpa->nama ?? '-');
        $template->setValue('nip_kpa', $kpa->nip ?? '-');
        $template->setValue('jabatan_kpa', optional($kpa->jabatan)->nama_jabatan ?? '-');
        $template->setValue('pangkat_kpa', $kpa->pangkat_golongan ?? '-');

        // ======= Pengikut → tabel cloneRow =======
        $rows = [];
        foreach ((array) $pd->pengikut as $row) {
            $tgl = $row['tgl_lahir'] ?? null;
            if ($tgl && preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl)) {
                $tgl = \Carbon\Carbon::parse($tgl)->translatedFormat('d F Y');
            }
            $rows[] = [
                'pengikut_nama' => trim($row['nama'] ?? '-') ?: '-',
                'pengikut_tgl'  => $tgl ?: '-',
                'pengikut_ket'  => trim($row['keterangan'] ?? '-') ?: '-',
            ];
        }

        if (count($rows)) {
            if (method_exists($template, 'cloneRowAndSetValues')) {
                $template->cloneRowAndSetValues('pengikut_nama', $rows);
            } else {
                $template->cloneRow('pengikut_nama', count($rows));
                foreach ($rows as $idx => $data) {
                    $n = $idx + 1;
                    foreach ($data as $key => $val) {
                        $template->setValue("{$key}#{$n}", $val);
                    }
                }
            }
        } else {
            $template->setValue('pengikut_nama', '-');
            $template->setValue('pengikut_tgl',  '-');
            $template->setValue('pengikut_ket',  '-');
        }

        // ======= Riwayat Perjalanan → 1 baris tabel per riwayat (kiri: Tiba, kanan: Berangkat) =======
        $riwayats = array_values((array) ($pd->riwayat_perjalanan ?? []));
        $rows = [];
        $roman = 2; // Tiba mulai II

        foreach ($riwayats as $idx => $r) {
            $tglB = self::fmtTanggal($r['tgl_berangkat'] ?? null) ?: '...................';
            $tglT = self::fmtTanggal($r['tgl_tiba'] ?? null) ?: '...................';

            $rows[] = [
                // KIRI (Tiba)
                'tiba_title'        => self::toRoman($roman) . '. Tiba di',
                'tiba_di'           => trim($r['tiba_di'] ?? '') ?: '...................',
                'tiba_tgl'          => $tglT,
                'tiba_kepala_nama'  => trim($r['kepala_tiba_nama'] ?? '') ?: '.................................',
                'tiba_kepala_nip'   => trim($r['kepala_tiba_nip']  ?? '') ?: '....................',

                // KANAN (Berangkat)
                // baris pertama pakai "I. Berangkat dari", selanjutnya tanpa nomor
                'berangkat_title'        => ($idx === 0) ? 'I. Berangkat dari' : 'Berangkat dari',
                'berangkat_dari'         => trim($r['dari'] ?? '') ?: '...................',
                'berangkat_ke'           => trim($r['ke']   ?? '') ?: '...................',
                'berangkat_tgl'          => $tglB,
                'berangkat_kepala_nama'  => trim($r['kepala_berangkat_nama'] ?? '') ?: '.................................',
                'berangkat_kepala_nip'   => trim($r['kepala_berangkat_nip']  ?? '') ?: '....................',

                // hanya muncul di baris pertama
                'berangkat_pejabat_kegiatan' => ($idx === 0)
                    ? "Selaku Pejabat Pelaksana Teknis\nKegiatan"
                    : '',

                // opsional: teks pemeriksaan di baris TERAKHIR (kanan bawah)
                // hapus/biarkan '' kalau nggak butuh
                'closing_note' => ($idx === count($riwayats) - 1)
                    ? "Telah diperiksa dengan keterangan bahwa perjalanan tersebut di atas\ndilakukan atas perintahnya dan semata-mata untuk kepentingan jabatan dalam waktu yang sesingkat-singkatnya."
                    : '',
            ];

            $roman++;
        }

        if (count($rows)) {
            if (method_exists($template, 'cloneRowAndSetValues')) {
                $template->cloneRowAndSetValues('tiba_title', $rows);
            } else {
                // fallback kalau PhpWord lama
                $template->cloneRow('tiba_title', count($rows));
                foreach ($rows as $i => $vals) {
                    $n = $i + 1;
                    foreach ($vals as $k => $v) {
                        $template->setValue("{$k}#{$n}", $v);
                    }
                }
            }
        } else {
            // minimal satu baris kosong
            $template->setValue('tiba_title', 'II. Tiba di');
            $template->setValue('tiba_di', '...................');
            $template->setValue('tiba_tgl', '...................');
            $template->setValue('tiba_kepala_nama', '.................................');
            $template->setValue('tiba_kepala_nip', '....................');

            $template->setValue('berangkat_title', 'I. Berangkat dari');
            $template->setValue('berangkat_dari', '...................');
            $template->setValue('berangkat_ke', '...................');
            $template->setValue('berangkat_tgl', '...................');
            $template->setValue('berangkat_kepala_nama', '.................................');
            $template->setValue('berangkat_kepala_nip', '....................');
            $template->setValue('berangkat_pejabat_kegiatan', "Selaku Pejabat Pelaksana Teknis\nKegiatan");
            $template->setValue('closing_note', '');
        }

        // ======= Pembebanan (tetap) =======
        $template->setValue('skpd_pembebanan', $pd->skpd_pembebanan);
        $template->setValue('kode_rekening_pembebanan', $pd->kode_rekening_pembebanan);
        $template->setValue('keterangan_lain', $pd->keterangan_lain ?: '-');

        $filename = 'perjalanan_dinas_' . Str::slug($pd->nomor, '_') . '.docx';
        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    /**
     * Helper: angka → romawi (besar)
     */
    private static function toRoman(int $num): string {
        $map = ['M'=>1000,'CM'=>900,'D'=>500,'CD'=>400,'C'=>100,'XC'=>90,'L'=>50,'XL'=>40,'X'=>10,'IX'=>9,'V'=>5,'IV'=>4,'I'=>1];
        $out=''; foreach($map as $r=>$v){ while($num>=$v){ $out.=$r; $num-=$v; } } return $out;
    }

    /**
     * Helper: format tanggal fleksibel (support 'Y-m-d' atau 'd-m-Y')
     */
    private static function fmtTanggal($raw): ?string {
        if(!$raw) return null;
        try {
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/',$raw)) return \Carbon\Carbon::parse($raw)->translatedFormat('d F Y');
            if (preg_match('/^\d{2}-\d{2}-\d{4}$/',$raw)) return \Carbon\Carbon::createFromFormat('d-m-Y',$raw)->translatedFormat('d F Y');
            return \Carbon\Carbon::parse($raw)->translatedFormat('d F Y');
        } catch (\Throwable $e) { return $raw; }
    }
}
