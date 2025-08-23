<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Pernyataan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\TemplateProcessor;

class PernyataanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pernyataan = Pernyataan::with(['pegawai', 'pejabat'])
            ->when($search, function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                    ->orWhere('tempat_surat', 'like', "%{$search}%")
                    ->orWhere('tentang_peraturan', 'like', "%{$search}%")
                    ->orWhereHas('pegawai', function ($q2) use ($search) {
                        $q2->where('nama', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%");
                    })
                    ->orWhereHas('pejabat', function ($q2) use ($search) {
                        $q2->where('nama', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%");
                    });
            })
            ->orderByDesc('tanggal_surat')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('surat.pernyataan.index', compact('pernyataan', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.pernyataan.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat'         => 'required|string|max:191|unique:pernyataans,nomor_surat',
            'tanggal_surat'       => 'required|date_format:d-m-Y',
            'tempat_surat'        => 'required|string|max:191',

            'pejabat_id'          => 'required|exists:pegawais,id',
            'pegawai_id'          => 'required|exists:pegawais,id',

            'peraturan_tugas'     => 'required|string',
            'nomor_peraturan'     => 'required|string',
            'tahun_peraturan'     => 'required|integer|digits:4',
            'tentang_peraturan'   => 'required|string',
            'tanggal_mulai_tugas' => 'required|date_format:d-m-Y',
            'jabatan_tugas'       => 'required|string',
            'lokasi_tugas'        => 'required|string',

            'tembusan'            => 'nullable|string',
        ]);

        // format tanggal
        $validated['tanggal_surat']       = Carbon::createFromFormat('d-m-Y', $validated['tanggal_surat'])->format('Y-m-d');
        $validated['tanggal_mulai_tugas'] = Carbon::createFromFormat('d-m-Y', $validated['tanggal_mulai_tugas'])->format('Y-m-d');

        $validated['tembusan'] = !empty($validated['tembusan'])
            ? array_map('trim', explode(',', $validated['tembusan']))
            : [];

        Pernyataan::create($validated);

        return redirect()->route('pernyataan.index')->with('success', 'Surat pernyataan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pernyataan $pernyataan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pernyataan $pernyataan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pernyataan $pernyataan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pernyataan $pernyataan)
    {
        //
    }

    public function export($id)
    {
        $pernyataan = Pernyataan::with(['pegawai.jabatan','pejabat.jabatan'])->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/pernyataanTugas_template.docx'));

        // detail surat
        $template->setValue('nomor', $pernyataan->nomor_surat);
        $template->setValue('tanggal', $pernyataan->tanggal_surat->translatedFormat('d F Y'));
        $template->setValue('tempat', $pernyataan->tempat_surat);

        // pejabat + pegawai tugas
        $template->setValue('nama_pegawai', optional($pernyataan->pegawai)->nama_lengkap ?? '-');
        $template->setValue('nip_pegawai', optional($pernyataan->pegawai)->nip ?? '-');
        $template->setValue('pangkat_pegawai', optional($pernyataan->pejabat)->pangkat_golongan ?? '-');
        $template->setValue('jabatan_pegawai', optional(optional($pernyataan->pegawai)->jabatan)->nama_jabatan ?? '-');

        $template->setValue('nama_pejabat', optional($pernyataan->pejabat)->nama_lengkap ?? '-');
        $template->setValue('nip_pejabat', optional($pernyataan->pejabat)->nip ?? '-');
        $template->setValue('pangkat_pejabat', optional($pernyataan->pejabat)->pangkat_golongan ?? '-');
        $template->setValue('jabatan_pejabat', optional(optional($pernyataan->pejabat)->jabatan)->nama_jabatan ?? '-');

        // tugas
        $template->setValue('peraturan_tugas', $pernyataan->peraturan_tugas);
        $template->setValue('nomor_peraturan', $pernyataan->nomor_peraturan);
        $template->setValue('tahun_peraturan', $pernyataan->tahun_peraturan);
        $template->setValue('tentang_peraturan', $pernyataan->tentang_peraturan);
        $template->setValue('tanggal_mulai_tugas', $pernyataan->tanggal_mulai_tugas->translatedFormat('d F Y'));
        $template->setValue('jabatan_tugas', $pernyataan->jabatan_tugas);
        $template->setValue('lokasi_tugas', $pernyataan->lokasi_tugas);

        // Tembusan
        $tembusan = is_array($pernyataan->tembusan) ? $pernyataan->tembusan : [];
        if (count($tembusan)) {
            $tr = new TextRun();
            foreach ($tembusan as $i => $item) {
                if ($i > 0) $tr->addTextBreak();
                $tr->addText(($i+1).'. '.trim($item));
            }
            try { $template->setComplexBlock('tembusan', $tr); }
            catch (\Throwable $e) { $template->setValue('tembusan', implode(', ', $tembusan)); }
        } else {
            $template->setValue('tembusan', '-');
        }

        $filename = 'surat_pernyataan_' . Str::slug($pernyataan->nomor_surat, '_') . '.docx';
        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
