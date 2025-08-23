<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Pengumuman;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));

        $pengumumen = Pengumuman::with('pegawai')
            ->when($search, function ($q) use ($search) {
                // group biar OR nggak liar
                $q->where(function ($qq) use ($search) {
                    $qq->where('nomor_surat', 'like', "%{$search}%")
                        ->orWhere('tentang', 'like', "%{$search}%")
                        ->orWhere('dikeluarkan_di', 'like', "%{$search}%")
                        ->orWhereHas('pegawai', function ($q2) use ($search) {
                            $q2->where('nama', 'like', "%{$search}%")
                                ->orWhere('nip', 'like', "%{$search}%")
                                ->orWhere('gelar_depan', 'like', "%{$search}%")
                                ->orWhere('gelar_belakang', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('tanggal_dikeluarkan')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('surat.pengumuman.index', compact('pengumumen', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.pengumuman.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Normalisasi text biar rapi
        $normalizeText = fn ($v) => is_string($v) ? trim(preg_replace("/\r\n|\r|\n/", PHP_EOL, $v)) : $v;

        $request->merge([
            'isi_pengumuman'     => $normalizeText($request->input('isi_pengumuman')),
            'dikeluarkan_di'     => $normalizeText($request->input('dikeluarkan_di')),
            'tentang'            => $normalizeText($request->input('tentang')),
        ]);

        $validated = $request->validate([
            'pegawai_id'          => ['required', 'exists:pegawais,id'],
            'nomor_surat'         => ['required', 'string', 'max:191', 'unique:pengumumen,nomor_surat'],
            'tentang'             => ['required', 'string'],
            'isi_pengumuman'      => ['required', 'string'],
            'dikeluarkan_di'      => ['required', 'string', 'max:191'],
            // input form pakai d-m-Y biar konsisten sama controller lain
            'tanggal_dikeluarkan' => ['required', 'date_format:d-m-Y'],
        ]);

        // convert tanggal ke Y-m-d buat DB
        $validated['tanggal_dikeluarkan'] = Carbon::createFromFormat('d-m-Y', $validated['tanggal_dikeluarkan'])->format('Y-m-d');

        Pengumuman::create($validated);

        return redirect()->route('pengumuman.index')->with('success', 'Surat pengumuman berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pegawais   = Pegawai::all();

        // biar value form tampil d-m-Y
        $pengumuman->tanggal_dikeluarkan_form = Carbon::parse($pengumuman->tanggal_dikeluarkan)->format('d-m-Y');

        return view('surat.pengumuman.edit', compact('pengumuman', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $normalizeText = fn ($v) => is_string($v) ? trim(preg_replace("/\r\n|\r|\n/", PHP_EOL, $v)) : $v;

        $request->merge([
            'isi_pengumuman'     => $normalizeText($request->input('isi_pengumuman')),
            'dikeluarkan_di'     => $normalizeText($request->input('dikeluarkan_di')),
            'tentang'            => $normalizeText($request->input('tentang')),
        ]);

        $validated = $request->validate([
            'pegawai_id'          => ['required', 'exists:pegawais,id'],
            'nomor_surat'         => [
                'required', 'string', 'max:191',
                Rule::unique('pengumumen', 'nomor_surat')->ignore($pengumuman->id)
            ],
            'tentang'             => ['required', 'string'],
            'isi_pengumuman'      => ['required', 'string'],
            'dikeluarkan_di'      => ['required', 'string', 'max:191'],
            'tanggal_dikeluarkan' => ['required', 'date_format:d-m-Y'],
        ]);

        $validated['tanggal_dikeluarkan'] = Carbon::createFromFormat('d-m-Y', $validated['tanggal_dikeluarkan'])->format('Y-m-d');

        $pengumuman->update($validated);

        return redirect()->route('pengumuman.index')->with('success', 'Surat pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Surat pengumuman berhasil dihapus.');
    }

    public function export($id)
    {
        $pm = Pengumuman::with('pegawai.jabatan')->findOrFail($id);

        // siapkan template (ganti path sesuai file kamu)
        $template = new TemplateProcessor(storage_path('app/templates/pengumuman_template.docx'));

        // Detail surat
        $template->setValue('nomor', $pm->nomor_surat);
        $template->setValue('tentang', $pm->tentang);
        $template->setValue('di', $pm->dikeluarkan_di);
        $template->setValue('tanggal', Carbon::parse($pm->tanggal_dikeluarkan)->translatedFormat('d F Y'));

        // Isi pengumuman (biar line break kebaca di docx)
        $template->setValue('isi', $pm->isi_pengumuman ?? '-');

        $template->setValue('nama_pegawai', optional($pm->pegawai)->nama_lengkap ?? optional($pm->pegawai)->nama ?? '-');
        $template->setValue('nip_pegawai', optional($pm->pegawai)->nip ?? '-');
        $template->setValue('jabatan_pegawai', optional(optional($pm->pegawai)->jabatan)->nama_jabatan ?? '-');
        $template->setValue('pangkat_pegawai', optional($pm->pegawai)->pangkat_golongan ?? '-');

        $filename = 'surat_pengumuman_' . Str::slug($pm->nomor_surat, '_') . '.docx';
        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
