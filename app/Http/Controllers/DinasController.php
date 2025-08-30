<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dinas;
use App\Models\Pegawai;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\TemplateProcessor;

class DinasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Biarkan query builder tetap aktif
        $query = Dinas::with('penandatangan');

        // Pencarian dengan relasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor', 'like', "%$search%")
                    ->orWhere('hal', 'like', "%$search%")
                    ->orWhereHas('penandatangan', function ($q) use ($search) {
                        $q->where('nama', 'like', "%$search%")
                            ->orWhere('nip', 'like', "%$search%");
                    });
            });
        }

        // Eksekusi kueri hanya di akhir
        $dinas = $query->latest()->paginate(10)->appends($request->query());
        
        return view('surat.dinas.index', compact('dinas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data pegawai untuk dropdown
        $pegawais = Pegawai::with('jabatan')->get();

        return view('surat.dinas.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomor' => 'required|unique:dinas',
            'sifat' => 'required|string|max:255',
            'lampiran' => 'nullable|string|max:255',
            'hal' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tempat' => 'required|string|max:255',
            'kepada_yth' => 'required|string|max:255',
            'alamat_tujuan' => 'required|string|max:255',
            'penandatangan_id' => 'required|exists:pegawais,id',
            'tembusan' => 'nullable|string',
        ]);

        // Konversi tanggal dari dd-mm-yyyy ke YYYY-MM-DD sebelum disimpan
        if (isset($validatedData['tanggal_surat'])) {
            $validatedData['tanggal_surat'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal_surat'])->format('Y-m-d');
        }

        // Simpan data dinas
        Dinas::create($validatedData);

        return redirect()->route('dinas.index')->with('success', 'Surat Dinas berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dinas $dinas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dinas $dinas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dinas $dinas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dinas $dinas)
    {
        $dinas->delete();
        return back()->with('success', 'Surat dinas dipindahkan ke tong sampah.');
    }

    public function trash(Request $request)
    {
        $search = $request->input('search');

        $dinas = Dinas::onlyTrashed()
            ->when($search, function ($q) use ($search) {
                $q->where('kepada_yth', 'like', "%{$search}%")
                    ->orWhere('tanggal_surat', 'like', "%{$search}%")
                    ->orWhereHas('penandatangan', fn ($qp) =>
                            $qp->where('nama', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%")
                    );
            })
            ->orderByDesc('deleted_at')
            ->paginate(10);

        return view('dinas.trash', compact('dinas', 'search'));
    }

    public function restore($id)
    {
        $dinas = Dinas::onlyTrashed()->findOrFail($id);
        $dinas->restore();

        return back()->with('success', 'Surat dinas berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $dinas = Dinas::onlyTrashed()->findOrFail($id);
        $dinas->forceDelete();

        return back()->with('success', 'Surat dinas dihapus permanen.');
    }

    /**
     * Export the specified resource to a document.
     */
    public function export($id)
    {
        $dinas = Dinas::with('penandatangan')->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/dinas_template.docx'));

        $template->setValue('nomor', $dinas->nomor);
        $template->setValue('sifat', $dinas->sifat);
        $template->setValue('lampiran', $dinas->lampiran);
        $template->setValue('hal', $dinas->hal);
        $template->setValue('tanggal_surat', \Carbon\Carbon::parse($dinas->tanggal_surat)->format('d-m-Y'));
        $template->setValue('tempat', $dinas->tempat);
        $template->setValue('kepada_yth', $dinas->kepada_yth);
        $template->setValue('alamat_tujuan', $dinas->alamat_tujuan);
        $template->setValue('nama_penandatangan', optional($dinas->penandatangan)->nama_lengkap ?? '-');
        $template->setValue('nip_penandatangan', optional($dinas->penandatangan)->nip ?? '-');
        $template->setValue('jabatan_penandatangan', optional($dinas->penandatangan->jabatan)->nama_jabatan ?? '-');
        $template->setValue('pangkat_penandatangan', optional($dinas->penandatangan)->pangkat_golongan ?? '-');
        
        if ($dinas->tembusan) {
            $tembusanArray = explode(',', $dinas->tembusan);
            $tr = new TextRun();

            foreach ($tembusanArray as $i => $item) {
                if ($i > 0) {
                    $tr->addTextBreak();
                }
                $tr->addText(($i + 1) . '. ' . trim($item));
            }

            $template->setComplexBlock('tembusan', $tr);
        } else {
            $template->setValue('tembusan', '-');
        }
        
        $namaPenandatangan = optional($dinas->penandatangan)->nama_lengkap ?? 'tanpa_nama';
        $filename = 'surat_dinas_' . Str::slug($namaPenandatangan, '_') . '.docx';

        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
