<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tugas;
use App\Models\Pegawai;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $tugas = Tugas::with(['penandatangan.jabatan'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('nomor', 'like', "%{$search}%")
                    ->orWhere('tempat_dikeluarkan', 'like', "%{$search}%")
                    ->orWhere('dasar', 'like', "%{$search}%")
                    ->orWhere('untuk', 'like', "%{$search}%")
                    ->orWhereRaw("CAST(pegawai AS CHAR) LIKE ?", ["%{$search}%"]);
                });
            })
            ->orderByDesc('tanggal_dikeluarkan')
            ->paginate(10)
            ->appends(['search' => $search]);

        $allIds = collect($tugas->items())
            ->flatMap(function ($row) {
                $arr = is_array($row->pegawai) ? $row->pegawai : [];
                return collect($arr)->map(function ($v) {
                    return is_array($v) ? ($v['id'] ?? null) : (is_numeric($v) ? (int) $v : null);
                })->filter();
            })->unique()->values();

        $pegawaiIndex = \App\Models\Pegawai::whereIn('id', $allIds)
            ->with('jabatan')
            ->get()
            ->keyBy('id')
            ->map(fn($p) => [
                'nama' => $p->nama_lengkap ?? $p->nama ?? '-',
                'nip'  => $p->nip ?? '-',
                'pang' => $p->pangkat_golongan ?? '-',
                'jab'  => optional($p->jabatan)->nama_jabatan ?? '-',
            ]);

        $tugas->setCollection(
            $tugas->getCollection()->map(function ($row) use ($pegawaiIndex) {
                $arr = is_array($row->pegawai) ? $row->pegawai : [];
                $row->total_pegawai = count($arr);

                $preview = [];
                foreach ($arr as $v) {
                    if (count($preview) >= 2) break;
                    if (is_array($v)) {
                        $preview[] = $v['nama'] ?? $v['nama_lengkap'] ?? ($v['nip'] ?? '-');
                    } else {
                        $info = $pegawaiIndex[$v] ?? null;
                        $preview[] = $info['nama'] ?? '-';
                    }
                }
                $row->nama_preview = implode(', ', array_filter($preview)) ?: '-';

                return $row;
            })
        );

        return view('surat.tugas.index', compact('tugas','search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.tugas.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $toLines = fn($v) => is_array($v)
            ? implode(PHP_EOL, array_filter(array_map('trim', $v)))
            : trim((string)$v);

        $validated = $request->validate([
            'nomor'               => 'required|string|max:191|unique:tugas,nomor',
            'tempat_dikeluarkan'  => 'required|string|max:191',
            'tanggal_dikeluarkan' => 'required|date_format:d-m-Y',

            'dasar'               => 'required',
            'untuk'               => 'required',

            'penandatangan_id'    => 'required|exists:pegawais,id',
            'pegawai'             => 'required|array|min:1',
            'pegawai.*'           => 'exists:pegawais,id',
        ]);

        $validated['tanggal_dikeluarkan'] = Carbon::createFromFormat('d-m-Y', $validated['tanggal_dikeluarkan'])->format('Y-m-d');

        $validated['dasar'] = $toLines($request->input('dasar'));
        $validated['untuk'] = $toLines($request->input('untuk'));
        $validated['pegawai'] = $request->input('pegawai');

        Tugas::create($validated);

        return redirect()->route('tugas.index')->with('success', 'Surat tugas berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tugas $tugas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tugas $tugas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tugas $tugas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tugas $tugas)
    {
        $tugas->delete();
        return back()->with('success', 'Surat tugas dipindahkan ke tong sampah.');
    }

    public function trash(Request $request)
    {
        $search = $request->input('search');

        $tugases = Tugas::onlyTrashed()
            ->when($search, function ($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                    ->orWhere('tempat_dikeluarkan', 'like', "%{$search}%")
                    ->orWhere('dasar', 'like', "%{$search}%")
                    ->orWhere('untuk', 'like', "%{$search}%")
                    ->orWhereHas('penandatangan', fn($qp) =>
                            $qp->where('nama', 'like', "%{$search}%")
                            ->orWhere('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%")
                    );
            })
            ->orderByDesc('deleted_at')
            ->paginate(10)
            ->withQueryString();

        return view('tugas.trash', compact('tugases', 'search'));
    }

    public function restore($id)
    {
        $tugas = Tugas::onlyTrashed()->findOrFail($id);
        $tugas->restore();

        return back()->with('success', 'Surat tugas berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $tugas = Tugas::onlyTrashed()->findOrFail($id);
        $tugas->forceDelete();

        return back()->with('success', 'Surat tugas dihapus permanen.');
    }

    public function export($id)
    {
        $tugas = Tugas::with(['penandatangan.jabatan'])->findOrFail($id);
        $template = new TemplateProcessor(storage_path('app/templates/tugas_template.docx'));

        // formatter: ". item;" dan "1. item;"
        $dotSemi = function ($strOrArr) {
            $arr = is_array($strOrArr) ? $strOrArr : preg_split('/\r\n|\n|\r|;|,/', (string) $strOrArr);
            $arr = array_values(array_filter(array_map('trim', $arr)));
            if (!$arr) return '. -;';
            return implode("\n", array_map(fn($x) => '. '.$x.';', $arr));
        };
        $numSemi = function ($strOrArr) {
            $arr = is_array($strOrArr) ? $strOrArr : preg_split('/\r\n|\n|\r|;|,/', (string) $strOrArr);
            $arr = array_values(array_filter(array_map('trim', $arr)));
            if (!$arr) return '1. -;';
            $out = '';
            foreach ($arr as $i => $x) {
                $out .= ($i ? "\n" : '').(($i + 1).'. '.$x.';');
            }
            return $out;
        };

        // header
        $template->setValue('nomor', $tugas->nomor);
        $template->setValue(
            'tempat_tanggal',
            ($tugas->tempat_dikeluarkan ?? '-') . ', ' . $tugas->tanggal_dikeluarkan->translatedFormat('d F Y')
        );

        // isi
        $template->setValue('dasar', $dotSemi($tugas->dasar));

        // === Kepada ===

        $rawPegawai = is_array($tugas->pegawai) ? $tugas->pegawai : [];

        // kalau array ID → lookup sekali
        $ids = collect($rawPegawai)
            ->map(fn($v) => is_array($v) ? ($v['id'] ?? null) : (is_numeric($v) ? (int)$v : null))
            ->filter()->unique()->values();

        $lookup = $ids->isNotEmpty()
            ? Pegawai::whereIn('id', $ids)->with('jabatan')->get()->keyBy('id')
            : collect();

        $kepadaBlocks = [];
        foreach ($rawPegawai as $i => $v) {
            if (is_array($v)) {
                // snapshot
                $nama = $v['nama'] ?? $v['nama_lengkap'] ?? '-';
                $nip  = $v['nip'] ?? '-';
                $pang = $v['pangkat_golongan'] ?? '-';
                $jab  = $v['jabatan'] ?? '-';
            } else {
                // id → ambil dari lookup
                $p = $lookup[$v] ?? null;
                $nama = $p?->nama_lengkap ?? $p?->nama ?? '-';
                $nip  = $p?->nip ?? '-';
                $pang = $p?->pangkat_golongan ?? '-';
                $jab  = optional($p?->jabatan)->nama_jabatan ?? '-';
            }

            $kepadaBlocks[] =
                ($i + 1).". Nama : {$nama}\n".
                "   Pangkat (Gol.Ruang): {$pang}\n".
                "   NIP : {$nip}\n".
                "   Jabatan : {$jab}";
        }

        $template->setValue('kepada_list', $kepadaBlocks ? implode("\n\n", $kepadaBlocks) : "1. Nama : -\n   Pangkat (Gol.Ruang): -\n   NIP : -\n   Jabatan : -");

        // Untuk
        $template->setValue('untuk', $numSemi($tugas->untuk));

        // penandatangan
        $pen = $tugas->penandatangan;
        $template->setValue('jabatan_penandatangan', optional($pen->jabatan)->nama_jabatan ?? '-');
        $template->setValue('nama_penandatangan', $pen->nama_lengkap ?? $pen->nama ?? '-');
        $template->setValue('pangkat_penandatangan', $pen->pangkat_golongan ?? '-');
        $template->setValue('nip_penandatangan', $pen->nip ?? '-');

        $filename = 'surat_tugas_'.Str::slug($tugas->nomor, '_').'.docx';
        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
