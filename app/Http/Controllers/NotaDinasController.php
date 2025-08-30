<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\notaDinas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\TemplateProcessor;

class NotaDinasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = NotaDinas::with(['pemberi','penerima']);

        // Search: nomor, hal, sifat, isi, nama pemberi/penerima
        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('nomor', 'like', "%{$s}%")
                    ->orWhere('hal', 'like', "%{$s}%")
                    ->orWhere('sifat', 'like', "%{$s}%")
                    ->orWhere('isi', 'like', "%{$s}%")
                    ->orWhereHas('pemberi', fn($qq)=>$qq->where('nama','like',"%{$s}%"))
                    ->orWhereHas('penerima', fn($qq)=>$qq->where('nama','like',"%{$s}%"));
            });
        }

        $notas = $query->latest('tanggal')->paginate(10)->withQueryString();

        return view('surat.nota_dinas.index', compact('notas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.nota_dinas.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor'        => 'required|string|max:191|unique:nota_dinas,nomor',
            'tanggal'      => 'required|date_format:d-m-Y',
            'sifat'        => 'nullable|string|max:191',
            'lampiran'     => 'nullable|string|max:191',
            'hal'          => 'required|string|max:255',
            'isi'          => 'required|string',
            'pemberi_id'   => 'required|exists:pegawais,id|different:penerima_id',
            'penerima_id'  => 'required|exists:pegawais,id',
            'tembusan'     => 'nullable|string',
        ]);

        $data['tanggal']  = Carbon::createFromFormat('d-m-Y', $data['tanggal'])->format('Y-m-d');
        $data['tembusan'] = !empty($data['tembusan'])
            ? array_map('trim', explode(',', $data['tembusan']))
            : [];

        NotaDinas::create($data);

        return redirect()->route('nota_dinas.index')->with('success', 'Nota Dinas berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(notaDinas $notaDinas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(notaDinas $notaDinas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, notaDinas $notaDinas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotaDinas $notaDinas)
    {
        $notaDinas->delete();
        return back()->with('success', 'Nota dinas dipindahkan ke tong sampah.');
    }

    public function trash(Request $request)
    {
        $search = $request->input('search');

        $notas = NotaDinas::onlyTrashed()
            ->when($search, function ($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                    ->orWhere('sifat', 'like', "%{$search}%")
                    ->orWhere('hal', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'like', "%{$search}%")
                    ->orWhereHas('pemberi', fn($qp) =>
                            $qp->where('nama', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%")
                    )
                    ->orWhereHas('penerima', fn($qr) =>
                            $qr->where('nama', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%")
                    );
            })
            ->orderByDesc('deleted_at')
            ->paginate(10)
            ->withQueryString();

        return view('nota_dinas.trash', compact('notas', 'search'));
    }

    public function restore($id)
    {
        $nota = NotaDinas::onlyTrashed()->findOrFail($id);
        $nota->restore();

        return back()->with('success', 'Nota dinas berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $nota = NotaDinas::onlyTrashed()->findOrFail($id);
        $nota->forceDelete();

        return back()->with('success', 'Nota dinas dihapus permanen.');
    }

    public function export($id)
    {
        $nota = NotaDinas::with(['pemberi.jabatan','penerima.jabatan'])->findOrFail($id);

        $templatePath = storage_path('app/templates/notaDinas_template.docx');

        if (!file_exists($templatePath)) {
            throw new \Exception('Template notaDinas_template.docx tidak ditemukan.');
        }

        $template = new TemplateProcessor($templatePath);

        // Header fields
        $template->setValue('nomor', $nota->nomor ?? '...');
        $template->setValue('tanggal', $nota->tanggal?->format('d-m-Y') ?? '-');
        $template->setValue('sifat', $nota->sifat ?? '-');
        $template->setValue('lampiran', $nota->lampiran ?? '-');
        $template->setValue('hal', $nota->hal ?? '-');

        // Yth (tujuan) & Dari (pengirim)
        $pemberi = $nota->pemberi;
        $template->setValue('nama_pemberi', optional($pemberi)->nama_lengkap ?? '-');
        $template->setValue('nip_pemberi', optional($pemberi)->nip ?? '-');
        $template->setValue('pangkat_pemberi', optional($pemberi)->pangkat_golongan ?? '-');
        $template->setValue('jabatan_pemberi', optional(optional($pemberi)->jabatan)->nama_jabatan ?? '-');
        
        // --- Penerima nota ---
        $penerima = $nota->penerima;
        $template->setValue('nama_penerima', optional($penerima)->nama_lengkap ?? '-');

        // Isi naskah
        $template->setValue('isi', strip_tags($nota->isi ?? '-'));

        // Tembusan
        $tembusan = is_array($nota->tembusan) ? $nota->tembusan : [];
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

        $fileName = 'NotaDinas_'.Str::slug($nota->nomor,'_').'.docx';
        $tmp = tempnam(sys_get_temp_dir(), $fileName);
        $template->saveAs($tmp);

        return response()->download($tmp, $fileName)->deleteFileAfterSend(true);
    }
}
