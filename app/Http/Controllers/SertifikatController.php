<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Sertifikat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class SertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $sertifikat = Sertifikat::with(['penerima', 'penandatangan.jabatan'])
            ->when($search, function ($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                    ->orWhere('nama_kegiatan', 'like', "%{$search}%")
                    ->orWhere('penyelenggara', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhereHas('penerima', function ($qq) use ($search) {
                        $qq->where('nama', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%");
                    })
                    ->orWhereHas('penandatangan', function ($qq) use ($search) {
                        $qq->where('nama', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('tanggal_terbit')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('surat.sertifikat.index', compact('sertifikat', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.sertifikat.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor'             => 'required|string|max:191|unique:sertifikats,nomor',
            'penerima_id'       => 'required|exists:pegawais,id',
            'instansi'          => 'nullable|string|max:191',

            'nama_kegiatan'     => 'required|string',
            'penyelenggara'     => 'required|string',
            'tanggal_mulai'     => 'required|date_format:d-m-Y',
            'tanggal_selesai'   => 'required|date_format:d-m-Y|after_or_equal:tanggal_mulai',
            'lokasi'            => 'required|string',

            'tempat_terbit'     => 'required|string',
            'tanggal_terbit'    => 'required|date_format:d-m-Y',

            'penandatangan_id'  => 'required|exists:pegawais,id',
        ]);

        // Convert tanggal (dd-mm-YYYY -> YYYY-mm-dd)
        $validated['tanggal_mulai']   = Carbon::createFromFormat('d-m-Y', $validated['tanggal_mulai'])->format('Y-m-d');
        $validated['tanggal_selesai'] = Carbon::createFromFormat('d-m-Y', $validated['tanggal_selesai'])->format('Y-m-d');
        $validated['tanggal_terbit']  = Carbon::createFromFormat('d-m-Y', $validated['tanggal_terbit'])->format('Y-m-d');

        Sertifikat::create($validated);

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sertifikat $sertifikat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sertifikat $sertifikat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sertifikat $sertifikat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sertifikat $sertifikat)
    {
        //
    }

    public function export($id)
    {
        $sertifikat = Sertifikat::with(['penerima.jabatan', 'penandatangan.jabatan'])->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/sertifikat_template.docx'));

        // helper tanggal lokal (null-safe)
        $fmt = function ($date) {
            if (!$date) return '-';
            $d = $date instanceof Carbon ? $date : Carbon::parse($date);
            return $d->translatedFormat('d F Y');
        };

        // Header
        $template->setValue('nomor', $sertifikat->nomor ?? '-');

        // Penerima (pakai accessor nama_lengkap & pangkat_golongan dari Pegawai)
        $template->setValue('nama', optional($sertifikat->penerima)->nama_lengkap ?? optional($sertifikat->penerima)->nama ?? '-');
        $template->setValue('nip',  optional($sertifikat->penerima)->nip ?? '-');
        $template->setValue('instansi', $sertifikat->instansi ?: '-');

        // Kegiatan
        $template->setValue('nama_kegiatan', $sertifikat->nama_kegiatan ?? '-');
        $template->setValue('penyelenggara', $sertifikat->penyelenggara ?? '-');
        $template->setValue('tanggal_mulai', $fmt($sertifikat->tanggal_mulai));
        $template->setValue('tanggal_selesai', $fmt($sertifikat->tanggal_selesai));
        $template->setValue('lokasi', $sertifikat->lokasi ?? '-');

        // Penerbitan / tanda tangan (ambil dari relasi penandatangan langsung)
        $template->setValue('tempat_terbit', $sertifikat->tempat_terbit ?? '-');
        $template->setValue('tanggal_terbit', $fmt($sertifikat->tanggal_terbit));

        $template->setValue('jabatan_penandatangan', optional($sertifikat->penandatangan->jabatan)->nama_jabatan ?? '-');
        $template->setValue('nama_penandatangan', optional($sertifikat->penandatangan)->nama_lengkap ?? optional($sertifikat->penandatangan)->nama ?? '-');
        $template->setValue('pangkat_penandatangan', optional($sertifikat->penandatangan)->pangkat_golongan ?? '-');
        $template->setValue('nip_penandatangan', optional($sertifikat->penandatangan)->nip ?? '-');

        // Save & download
        $filename = 'sertifikat_' . Str::slug($sertifikat->nomor ?: 'non_nomor', '_') . '.docx';
        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
