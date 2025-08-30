<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Penetapan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class PenetapanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $penetapan = Penetapan::with('pegawai')
            ->when($search, function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                ->orWhere('tentang', 'like', "%{$search}%")
                ->orWhereHas('pegawai', function ($q2) use ($search) {
                    $q2->where('nama', 'like', "%{$search}%")
                        ->orWhere('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nip', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('tanggal_penetapan')
            ->paginate(10);

        return view('surat.penetapan.index', compact('penetapan', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.penetapan.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Helper function untuk convert array ke string
        $toLines = function ($val) {
            if (is_array($val)) {
                return implode(PHP_EOL, array_filter(array_map('trim', $val)));
            }
            return trim((string)$val);
        };

        // Merge data yang sudah diproses
        $request->merge([
            'menimbang'  => $toLines($request->input('menimbang')),
            'mengingat'  => $toLines($request->input('mengingat')),
            'memutuskan' => $toLines($request->input('memutuskan')),
        ]);

        // Validasi
        $validated = $request->validate([
            'pegawai_id'         => 'required|exists:pegawais,id',
            'nomor_surat'        => 'required|string|max:191|unique:penetapans,nomor_surat',
            'tahun_surat'        => 'required|integer|digits:4',
            'tanggal_penetapan'  => 'required|date_format:d-m-Y',
            'tentang'            => 'required|string',
            'menimbang'          => 'required|string',
            'mengingat'          => 'required|string',
            'memutuskan'         => 'required|string',
        ]);

        // Convert tanggal
        $validated['tanggal_penetapan'] = \Carbon\Carbon::createFromFormat('d-m-Y', $validated['tanggal_penetapan'])->format('Y-m-d');

        // Simpan ke database
        Penetapan::create($validated);

        return redirect()->route('penetapan.index')->with('success', 'Surat penetapan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penetapan $penetapan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penetapan $penetapan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penetapan $penetapan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penetapan $penetapan)
    {
        $penetapan->delete();
        return back()->with('success', 'Data penetapan dipindahkan ke tong sampah.');
    }

    public function trash(Request $request)
    {
        $search = $request->input('search');

        $penetapans = Penetapan::onlyTrashed()
            ->when($search, function ($q) use ($search) {
                $q->where('nama_penetapan', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhereHas('pegawai', fn ($qp) =>
                            $qp->where('nama', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%")
                    );
            })
            ->orderByDesc('deleted_at')
            ->paginate(10);

        return view('penetapan.trash', compact('penetapans', 'search'));
    }

    public function restore($id)
    {
        $penetapan = Penetapan::onlyTrashed()->findOrFail($id);
        $penetapan->restore();

        return back()->with('success', 'Data penetapan berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $penetapan = Penetapan::onlyTrashed()->findOrFail($id);
        $penetapan->forceDelete();

        return back()->with('success', 'Data penetapan dihapus permanen.');
    }

    public function export($id)
    {
        $sp = Penetapan::with('pegawai.jabatan')->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/penetapan_template.docx'));

        // Detail surat
        $template->setValue('nomor_surat', $sp->nomor_surat);
        $template->setValue('tahun_surat', $sp->tahun_surat);
        $template->setValue('tentang', $sp->tentang);
        $template->setValue('tanggal_penetapan', $sp->tanggal_penetapan->translatedFormat('d F Y'));

        // Pejabat
        $pejabat = $sp->pegawai;
        $template->setValue('nama_pejabat', optional($pejabat)->nama_lengkap ?? optional($pejabat)->nama ?? '-');
        $template->setValue('nip_pejabat', optional($pejabat)->nip ?? '-');
        $template->setValue('jabatan_pejabat', optional(optional($pejabat)->jabatan)->nama_jabatan ?? '-');
        $template->setValue('pangkat_pejabat', optional($pejabat)->pangkat_golongan ?? '-');

        // Helper untuk convert string ke array
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

        // Set menimbang dan mengingat sebagai list biasa
        $template->setValue('menimbang', $formatList($sp->menimbang));
        $template->setValue('mengingat', $formatList($sp->mengingat));

        // Set memutuskan per item (KESATU, KEDUA, KETIGA)
        $memutuskanArray = $stringToArray($sp->memutuskan);
        $template->setValue('memutuskan_kesatu', $memutuskanArray[0] ?? '-');
        $template->setValue('memutuskan_kedua', $memutuskanArray[1] ?? '-');
        $template->setValue('memutuskan_ketiga', $memutuskanArray[2] ?? '-');

        $filename = 'surat_penetapan_' . Str::slug($sp->nomor_surat, '_') . '.docx';
        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
