<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Perintah;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class PerintahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $perintah = Perintah::with('pegawai')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('nomor_surat', 'like', "%{$search}%")
                        ->orWhere('tempat_dikeluarkan', 'like', "%{$search}%")
                        ->orWhere('menimbang', 'like', "%{$search}%")
                        ->orWhere('dasar', 'like', "%{$search}%")
                        ->orWhere('untuk', 'like', "%{$search}%")
                        ->orWhereHas('pegawai', function ($q2) use ($search) {
                            $q2->where('nama', 'like', "%{$search}%")
                                ->orWhere('nip', 'like', "%{$search}%")
                                ->orWhere('gelar_depan', 'like', "%{$search}%")
                                ->orWhere('gelar_belakang', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('tanggal_perintah')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('surat.perintah.index', compact('perintah', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.perintah.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // helper: normalisasi array/string → string newline
        $toLines = function ($val) {
            if (is_array($val)) {
                return implode(PHP_EOL, array_filter(array_map('trim', $val)));
            }
            return trim((string) $val);
        };

        // Validasi
        $validated = $request->validate([
            'pegawai_id'         => 'required|exists:pegawais,id',
            'nomor_surat'        => 'required|string|max:191|unique:perintahs,nomor_surat',
            'tanggal_perintah'   => 'required|date_format:d-m-Y',
            'tempat_dikeluarkan' => 'required|string|max:191',

            'menimbang'          => 'required',
            'dasar'              => 'required',
            'untuk'              => 'required',

            // Select2 multiple -> array of pegawai_id
            'penerima'           => 'required|array|min:1',
            'penerima.*'         => 'exists:pegawais,id',
        ]);

        // Konversi tanggal ke format DB
        $validated['tanggal_perintah'] = \Carbon\Carbon::createFromFormat('d-m-Y', $validated['tanggal_perintah'])->format('Y-m-d');

        // Normalisasi menimbang/dasar/untuk → string per baris
        $validated['menimbang'] = $toLines($request->input('menimbang'));
        $validated['dasar']     = $toLines($request->input('dasar'));
        $validated['untuk']     = $toLines($request->input('untuk'));

        // Map penerima (IDs) -> snapshot JSON [{nama, pangkat_golongan, nip, jabatan}, ...]
        $penerimaPegawai = \App\Models\Pegawai::whereIn('id', $validated['penerima'])
            ->with('jabatan')
            ->get();

        $validated['penerima'] = $penerimaPegawai->map(function ($p) {
            return [
                'nama'             => $p->nama_lengkap ?? $p->nama ?? '-',
                'pangkat_golongan' => $p->pangkat_golongan ?? '-',
                'nip'              => $p->nip ?? '-',
                'jabatan'          => optional($p->jabatan)->nama_jabatan ?? '-',
            ];
        })->toArray();

        // Simpan
        \App\Models\Perintah::create($validated);

        return redirect()->route('perintah.index')->with('success', 'Surat perintah berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Perintah $perintah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perintah $perintah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Perintah $perintah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perintah $perintah)
    {
        $perintah->delete();
        return back()->with('success', 'Surat perintah dipindahkan ke tong sampah.');
    }

    public function trash(Request $request)
    {
        $search = $request->input('search');

        $perintah = Perintah::onlyTrashed()
            ->when($search, function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                    ->orWhere('tempat_dikeluarkan', 'like', "%{$search}%")
                    ->orWhere('menimbang', 'like', "%{$search}%")
                    ->orWhere('dasar', 'like', "%{$search}%")
                    ->orWhere('untuk', 'like', "%{$search}%")
                    ->orWhereHas('pegawai', fn($qp) =>
                            $qp->where('nama', 'like', "%{$search}%")
                            ->orWhere('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%")
                    );
            })
            ->orderByDesc('deleted_at')
            ->paginate(10)
            ->withQueryString();

        return view('perintah.trash', compact('perintah', 'search'));
    }

    public function restore($id)
    {
        $perintah = Perintah::onlyTrashed()->findOrFail($id);
        $perintah->restore();

        return back()->with('success', 'Surat perintah berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $perintah = Perintah::onlyTrashed()->findOrFail($id);
        $perintah->forceDelete();

        return back()->with('success', 'Surat perintah dihapus permanen.');
    }

    public function export($id)
    {
        $sp = \App\Models\Perintah::with('pegawai.jabatan')->findOrFail($id);

        $template = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/templates/perintah_template.docx'));

        // Detail surat
        $template->setValue('nomor', $sp->nomor_surat);
        $template->setValue('tempat', $sp->tempat_dikeluarkan);
        $template->setValue('tanggal', \Carbon\Carbon::parse($sp->tanggal_perintah)->translatedFormat('d F Y'));

        // Pejabat penandatangan
        $template->setValue('nama_pegawai', optional($sp->pegawai)->nama_lengkap ?? optional($sp->pegawai)->nama ?? '-');
        $template->setValue('nip_pegawai', optional($sp->pegawai)->nip ?? '-');
        $template->setValue('jabatan_pegawai', optional(optional($sp->pegawai)->jabatan)->nama_jabatan ?? '-');
        $template->setValue('pangkat_pegawai', optional($sp->pegawai)->pangkat_golongan ?? '-');

        // Helper: string → array baris, lalu format bernomor
        $stringToArray = function ($str) {
            if (is_string($str)) {
                return array_filter(array_map('trim', explode(PHP_EOL, $str)));
            }
            return is_array($str) ? $str : [];
        };

        $formatList = function ($items) use ($stringToArray) {
            $itemsArray = $stringToArray($items);
            if (!empty($itemsArray)) {
                $formatted = '';
                foreach ($itemsArray as $i => $item) {
                    if ($i > 0) $formatted .= "\n";
                    $formatted .= ($i + 1) . '. ' . $item;
                }
                return $formatted;
            }
            return '-';
        };

        // Menimbang/Dasar/Untuk (list bernomor)
        $template->setValue('menimbang', $formatList($sp->menimbang));
        $template->setValue('dasar', $formatList($sp->dasar));
        $template->setValue('untuk', $formatList($sp->untuk));

        // ===== PENERIMA dari JSON -> blok teks =====
        // Struktur tiap item: ['nama','pangkat_golongan','nip','jabatan']
        $kepadaLines = [];
        foreach ((array) $sp->penerima as $i => $r) {
            $no      = $i + 1;
            $nama    = $r['nama']             ?? '-';
            $pangkat = $r['pangkat_golongan'] ?? '-';
            $nip     = $r['nip']              ?? '-';
            $jabatan = $r['jabatan']          ?? '-';

            $kepadaLines[] =
                "{$no}. Nama\t: {$nama}\n" .
                "   Pangkat (Gol.Ruang)\t: {$pangkat}\n" .
                "   NIP/NRB\t\t: {$nip}\n" .
                "   Jabatan\t\t: {$jabatan}";
        }
        $kepadaText = count($kepadaLines) ? implode("\n\n", $kepadaLines) : '-';
        $template->setValue('kepada_list', $kepadaText);

        $filename = 'surat_perintah_' . \Illuminate\Support\Str::slug($sp->nomor_surat, '_') . '.docx';
        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
