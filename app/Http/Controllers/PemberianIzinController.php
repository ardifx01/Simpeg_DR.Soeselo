<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\pemberianIzin;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\TemplateProcessor;

class PemberianIzinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PemberianIzin::with(['pegawai', 'pemberiIzin']);

        // pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%$search%")
                  ->orWhere('tentang', 'like', "%$search%")
                  ->orWhere('dasar_hukum', 'like', "%$search%")
                  ->orWhere('tujuan_izin', 'like', "%$search%")
                  ->orWhere('ditetapkan_di', 'like', "%$search%")
                  ->orWhereHas('pegawai', function ($qq) use ($search) {
                    $qq->where('nama', 'like', "%$search%")
                       ->orWhere('nip', 'like', "%$search%");
                })
                  ->orWhereHas('pemberiIzin', function ($qq) use ($search) {
                    $qq->where('nama', 'like', "%$search%")
                       ->orWhere('nip', 'like', "%$search%");
                });
            });
        }

        $pemberianIzins = $query->latest('tanggal_penetapan')->paginate(10)->appends($request->query());

        return view('surat.pemberian_izin.index', compact('pemberianIzins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::orderBy('nama')->get();
        return view('surat.pemberian_izin.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pegawai_id'        => 'required|exists:pegawais,id',
            'pemberi_izin_id'   => 'required|exists:pegawais,id',
            'nomor_surat'       => 'required|string|max:191|unique:pemberian_izins,nomor_surat',
            'tentang'           => 'required|string|max:191',
            'dasar_hukum'       => 'nullable|string',
            'tujuan_izin'       => 'required|string',
            'ditetapkan_di'     => 'required|string|max:191',
            'tanggal_penetapan' => 'required|date_format:d-m-Y',
            'tembusan'          => 'nullable|string',
        ]);

        // konversi tanggal
        $validated['tanggal_penetapan'] = Carbon::createFromFormat('d-m-Y', $validated['tanggal_penetapan'])->format('Y-m-d');

        PemberianIzin::create($validated);

        return redirect()->route('pemberian_izin.index')->with('success', 'Surat Izin berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(pemberianIzin $pemberianIzin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pemberianIzin $pemberianIzin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pemberianIzin $pemberianIzin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pemberianIzin $pemberianIzin)
    {
        //
    }

    public function export($id)
    {
        $izin = PemberianIzin::with(['pegawai.jabatan', 'pemberiIzin.jabatan'])->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/pemberianIzin_template.docx'));

        // --- detail surat ---
        $template->setValue('nomor_surat', $izin->nomor_surat ?? '-');
        $template->setValue('tentang', $izin->tentang ?? '-');
        $template->setValue('dasar_hukum', str_replace(["\r\n", "\n"], PHP_EOL, (string) ($izin->dasar_hukum ?? '-')));
        $template->setValue('tujuan_izin', str_replace(["\r\n", "\n"], PHP_EOL, (string) ($izin->tujuan_izin ?? '-')));
        $template->setValue('ditetapkan_di', $izin->ditetapkan_di ?? '-');

        $tanggal = $izin->tanggal_penetapan
            ? Carbon::parse($izin->tanggal_penetapan)->translatedFormat('d F Y')
            : '-';
        $template->setValue('tanggal_penetapan', $tanggal);

        // --- data pegawai yang diberi izin ---
        $pgw = $izin->pegawai;
        $template->setValue('nama_pegawai', optional($pgw)->nama_lengkap ?? optional($pgw)->nama ?? '-');
        $template->setValue('nip_pegawai', optional($pgw)->nip ?? '-');
        $template->setValue('jabatan_pegawai', optional(optional($pgw)->jabatan)->nama_jabatan ?? optional(optional($pgw)->jabatan)->nama_jabatan ?? '-');
        $template->setValue('pangkat_pegawai', optional($pgw)->pangkat_golongan ?? '-');
        $template->setValue('alamat_pegawai', optional($pgw)->alamat_lengkap ?? '-');

        // --- data pemberi izin (penandatangan) ---
        $pem = $izin->pemberiIzin;
        $template->setValue('nama_pemberi', optional($pem)->nama_lengkap ?? optional($pem)->nama ?? '-');
        $template->setValue('nip_pemberi', optional($pem)->nip ?? '-');
        $template->setValue('jabatan_pemberi', optional(optional($pem)->jabatan)->nama_jabatan ?? optional(optional($pem)->jabatan)->nama ?? '-');
        $template->setValue('pangkat_pemberi', optional($pem)->pangkat_golongan ?? '-');

        // --- tembusan: support string (dipisah koma/enter) ATAU array/json ---
        $rawTembusan = $izin->tembusan;

        if (is_array($rawTembusan)) {
            $items = array_values(array_filter(array_map('trim', $rawTembusan)));
        } else {
            $items = array_values(array_filter(array_map('trim', preg_split('/,|\r\n|\n/', (string) $rawTembusan))));
        }

        if (count($items)) {
            $tr = new TextRun();
            foreach ($items as $i => $item) {
                if ($i > 0) $tr->addTextBreak();
                $tr->addText(($i + 1) . '. ' . $item);
            }
            // pakai placeholder ${tembusan} di template kalau mau pakai setComplexBlock
            $template->setComplexBlock('tembusan', $tr);
        } else {
            $template->setValue('tembusan', '-');
        }

        // --- nama file ---
        $namaPgw = optional($pgw)->nama_lengkap ?? optional($pgw)->nama ?? 'tanpa_nama';
        $safeNomor = $izin->nomor_surat ? '_' . Str::slug($izin->nomor_surat, '_') : '';
        $filename = 'surat_izin_' . Str::slug($namaPgw, '_') . $safeNomor . '.docx';

        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
