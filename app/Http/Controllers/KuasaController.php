<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kuasa;
use App\Models\Pegawai;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\TemplateProcessor;

class KuasaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kuasa::with(['pemberi', 'penerima']);

        // Pencarian: nomor, keperluan, nama pemberi/penerima
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'like', "%{$search}%")
                    ->orWhereHas('pemberi', function ($sub) use ($search) {
                        $sub->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('penerima', function ($sub) use ($search) {
                        $sub->where('nama', 'like', "%{$search}%");
                });
            });
        }

        // Eksekusi + paginate
        $kuasas = $query->latest()->paginate(10)->withQueryString();

        return view('surat.kuasa.index', compact('kuasas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.kuasa.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi (polanya mirip Keterangan)
        $validated = $request->validate([
            'nomor'        => 'nullable|string|max:255|unique:kuasas,nomor',
            'tempat'       => 'nullable|string|max:255',
            'tanggal'      => 'required|date_format:d-m-Y',
            'pemberi_id'   => 'required|exists:pegawais,id|different:penerima_id',
            'penerima_id'  => 'required|exists:pegawais,id',
            'keperluan'    => 'required|string',
            'tembusan'     => 'nullable|string',
        ]);

        // Konversi tanggal ke Y-m-d
        $validated['tanggal'] = Carbon::createFromFormat('d-m-Y', $validated['tanggal'])->format('Y-m-d');

        // Ubah tembusan string -> array (model cast ke array/json)
        $validated['tembusan'] = !empty($validated['tembusan'])
            ? array_map('trim', explode(',', $validated['tembusan']))
            : [];

        Kuasa::create($validated);

        return redirect()->route('kuasa.index')->with('success', 'Surat Kuasa berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kuasa $kuasa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kuasa $kuasa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kuasa $kuasa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kuasa $kuasa)
    {
        //
    }

    public function export($id)
    {
        $kuasa = Kuasa::with(['pemberi.jabatan', 'penerima.jabatan'])->findOrFail($id);

        $templatePath = storage_path('app/templates/kuasa_template.docx');

        if (!file_exists($templatePath)) {
            throw new \Exception('File template kuasa_template.docx tidak ditemukan!');
        }

        $template = new TemplateProcessor($templatePath);

        // --- Data Utama ---
        $template->setValue('nomor', $kuasa->nomor ?? '...');
        $template->setValue('tempat', $kuasa->tempat ?? '-');
        $template->setValue('tanggal', $kuasa->tanggal
            ? Carbon::parse($kuasa->tanggal)->translatedFormat('d F Y')
            : '-'
        );

        // --- Pemberi Kuasa ---
        $pemberi = $kuasa->pemberi;
        $template->setValue('nama_pemberi', optional($pemberi)->nama ?? '-');
        $template->setValue('nip_pemberi', optional($pemberi)->nip ?? '-');
        $template->setValue('pangkat_pemberi', optional($pemberi)->pangkat_golongan ?? '-');
        $template->setValue('jabatan_pemberi', optional(optional($pemberi)->jabatan)->nama_jabatan ?? '-');
        $template->setValue('alamat_pemberi', optional($pemberi)->alamat_lengkap ?? '-');
        
        // --- Penerima Kuasa ---
        $penerima = $kuasa->penerima;
        $template->setValue('nama_penerima', optional($penerima)->nama ?? '-');
        $template->setValue('nip_penerima', optional($penerima)->nip ?? '-');
        $template->setValue('pangkat_penerima', optional($penerima)->pangkat_golongan ?? '-');
        $template->setValue('jabatan_penerima', optional(optional($penerima)->jabatan)->nama_jabatan ?? '-');
        $template->setValue('alamat_penerima', optional($pemberi)->alamat_lengkap ?? '-');
        
        // --- Isi Kuasa ---
        $template->setValue('keperluan', strip_tags($kuasa->keperluan ?? '-'));

        // --- Mengisi Tembusan ---
        $tembusanArr = is_array($kuasa->tembusan) ? $kuasa->tembusan : [];
        if (count($tembusanArr)) {
            $tr = new TextRun();
            foreach ($tembusanArr as $i => $item) {
                if ($i > 0) $tr->addTextBreak();
                $tr->addText(($i + 1) . '. ' . trim($item));
            }
            try {
                $template->setComplexBlock('tembusan', $tr);
            } catch (\Throwable $e) {
                $template->setValue('tembusan', implode(", ", array_map('trim', $tembusanArr)));
            }
        } else {
            $template->setValue('tembusan', '-');
        }

        // --- Simpan & unduh ---
        $fileName = 'surat_kuasa_' . Str::slug(optional($penerima)->nama ?? 'penerima', '_') . '.docx';
        $tmp = tempnam(sys_get_temp_dir(), $fileName);
        $template->saveAs($tmp);

        return response()->download($tmp, $fileName)->deleteFileAfterSend(true);
    }
}
