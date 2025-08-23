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

        $tugas = Tugas::with(['pegawai.jabatan','penandatangan.jabatan'])
            ->when($search, function ($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                    ->orWhere('tempat_dikeluarkan', 'like', "%{$search}%")
                    ->orWhere('dasar', 'like', "%{$search}%")
                    ->orWhere('untuk', 'like', "%{$search}%")
                    ->orWhereHas('pegawai', fn($qq)=> $qq->where('nama','like',"%{$search}%")->orWhere('nip','like',"%{$search}%"))
                    ->orWhereHas('penandatangan', fn($qq)=> $qq->where('nama','like',"%{$search}%")->orWhere('nip','like',"%{$search}%"));
            })
            ->orderByDesc('tanggal_dikeluarkan')
            ->paginate(10)
            ->appends(['search' => $search]);

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
        //
    }

    public function export($id)
    {
        $tugas = Tugas::with(['pegawai.jabatan','penandatangan.jabatan'])->findOrFail($id);
        $template = new TemplateProcessor(storage_path('app/templates/tugas_template.docx'));

        // formatter sesuai format kamu (pakai titik & ; untuk Dasar, numbering untuk Untuk)
        $dotSemi = function ($tugasrOrArr) {
            $arr = is_array($tugasrOrArr) ? $tugasrOrArr : preg_split('/\r\n|\n|\r|;|,/', (string)$tugasrOrArr);
            $arr = array_values(array_filter(array_map('trim', $arr)));
            if (!$arr) return '. -;';
            return implode("\n", array_map(fn($x)=>'. '.$x.';', $arr));
        };
        $numSemi = function ($tugasrOrArr) {
            $arr = is_array($tugasrOrArr) ? $tugasrOrArr : preg_split('/\r\n|\n|\r|;|,/', (string)$tugasrOrArr);
            $arr = array_values(array_filter(array_map('trim', $arr)));
            if (!$arr) return '1. -;';
            $out = '';
            foreach ($arr as $i=>$x) { $out .= ($i? "\n":"").(($i+1).'. '.$x.';'); }
            return $out;
        };

        // header
        $template->setValue('nomor', $tugas->nomor);
        $template->setValue('tempat_tanggal', $tugas->tempat_dikeluarkan.', '.$tugas->tanggal_dikeluarkan->translatedFormat('d F Y'));

        // isi
        $template->setValue('dasar_text', $dotSemi($tugas->dasar));

        // Kepada (single)
        $pegawais = $tugas->pegawai;
        $kepada = "1. Nama : ".($pegawais->nama_lengkap ?? $pegawais->nama ?? '-')."\n"
                . "   Pangkat (Gol.Ruang): ".($pegawais->pangkat_golongan ?? '-')."\n"
                . "   NIP : ".($pegawais->nip ?? '-')."\n"
                . "   Jabatan : ".(optional($pegawais->jabatan)->nama_jabatan ?? '-');
        $template->setValue('kepada_list', $kepada);

        // Untuk
        $template->setValue('untuk_text', $numSemi($tugas->untuk));

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
