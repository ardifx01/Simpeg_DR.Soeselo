<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Telaahan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class TelaahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $telaahans = Telaahan::with(['yth', 'dari', 'penandatangan.jabatan'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('nomor', 'like', "%{$search}%")
                        ->orWhere('hal', 'like', "%{$search}%")
                        ->orWhereHas('yth', function ($q2) use ($search) {
                            $q2->where('nama', 'like', "%{$search}%")
                                ->orWhere('nip', 'like', "%{$search}%");
                    })
                        ->orWhereHas('dari', function ($q2) use ($search) {
                            $q2->where('nama', 'like', "%{$search}%")
                                ->orWhere('nip', 'like', "%{$search}%");
                    })
                        ->orWhereHas('penandatangan', function ($q2) use ($search) {
                            $q2->where('nama', 'like', "%{$search}%")
                                ->orWhere('nip', 'like', "%{$search}%");
                    });
                });
            })
            ->orderByDesc('tanggal')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('surat.telaahan.index', compact('telaahans', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.telaahan.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'yth_id'            => 'required|exists:pegawais,id',
            'dari_id'           => 'required|exists:pegawais,id',
            'penandatangan_id'  => 'required|exists:pegawais,id',
            'nomor'     => 'required|string|max:191|unique:telaahans,nomor',
            'tanggal'   => 'required|date_format:d-m-Y',
            'lampiran'  => 'nullable|string|max:191',
            'hal'       => 'required|string|max:191',
            'persoalan'   => 'nullable|string',
            'praanggapan' => 'nullable|string',
            'fakta'       => 'nullable|string',
            'analisis'    => 'nullable|string',
            'kesimpulan'  => 'nullable|string',
            'saran'       => 'nullable|string',
        ]);

        // convert tanggal
        $validated['tanggal'] = Carbon::createFromFormat('d-m-Y', $validated['tanggal'])->format('Y-m-d');

        Telaahan::create($validated);

        return redirect()->route('telaahan.index')->with('success', 'Telaahan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Telaahan $telaahan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Telaahan $telaahan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Telaahan $telaahan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Telaahan $telaahan)
    {
        $telaahan->delete();
        return back()->with('success', 'Telaahan dipindahkan ke tong sampah.');
    }

    public function trash(Request $request)
    {
        $search = $request->input('search');

        $telaahans = Telaahan::onlyTrashed()
            ->when($search, function ($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                    ->orWhere('hal', 'like', "%{$search}%")
                    ->orWhere('persoalan', 'like', "%{$search}%")
                    ->orWhere('analisis', 'like', "%{$search}%")
                    ->orWhere('kesimpulan', 'like', "%{$search}%")
                    ->orWhere('saran', 'like', "%{$search}%")
                    ->orWhereHas('yth', fn($qy) =>
                            $qy->where('nama', 'like', "%{$search}%")
                            ->orWhere('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%")
                    )
                    ->orWhereHas('dari', fn($qd) =>
                            $qd->where('nama', 'like', "%{$search}%")
                            ->orWhere('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%")
                    )
                    ->orWhereHas('penandatangan', fn($qp) =>
                            $qp->where('nama', 'like', "%{$search}%")
                            ->orWhere('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%")
                    );
            })
            ->orderByDesc('deleted_at')
            ->paginate(10)
            ->withQueryString();

        return view('telaahan.trash', compact('telaahans', 'search'));
    }

    public function restore($id)
    {
        $telaahan = Telaahan::onlyTrashed()->findOrFail($id);
        $telaahan->restore();

        return back()->with('success', 'Telaahan berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $telaahan = Telaahan::onlyTrashed()->findOrFail($id);
        $telaahan->forceDelete();

        return back()->with('success', 'Telaahan dihapus permanen.');
    }

    public function export($id)
    {
        $telaahan = Telaahan::with(['yth.jabatan', 'dari.jabatan', 'penandatangan.jabatan'])->findOrFail($id);

        $template = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/templates/telaahan_template.docx'));

        $formatDate = fn($date) => $date ? \Carbon\Carbon::parse($date)->translatedFormat('d F Y') : '-';

        $htmlToText = function (?string $html): string {
            if (!$html) return '-';

            // Normalisasi newline
            $text = $html;

            // Ganti <li> dalam <ol> jadi list bernomor
            // Kasus sederhana: treat semua <li> sama; kalau butuh angka real, butuh parser DOM. Ini versi bullet universal:
            $text = preg_replace('#<\s*li[^>]*>\s*#i', "• ", $text);
            $text = preg_replace('#</\s*li\s*>#i', "\n", $text);

            // Breaks paragraf
            $text = preg_replace('#<\s*br\s*/?>#i', "\n", $text);
            $text = preg_replace('#</\s*(p|div)\s*>#i', "\n\n", $text);

            // Hapus sisa tag HTML
            $text = strip_tags($text);

            // Decode HTML entities
            $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

            // Rapikan multiple newlines/spaces
            $text = preg_replace("/[ \t]+/", ' ', $text);
            $text = preg_replace("/\n{3,}/", "\n\n", $text);

            $text = trim($text);
            return $text === '' ? '-' : $text;
        };

        // Header
        $template->setValue('yth', optional($telaahan->yth)->nama_lengkap ?? '-');
        $template->setValue('dari', optional($telaahan->dari)->nama_lengkap ?? '-');
        $template->setValue('tanggal', $formatDate($telaahan->tanggal));
        $template->setValue('nomor', $telaahan->nomor ?? '-');
        $template->setValue('lampiran', $telaahan->lampiran ?: '-');
        $template->setValue('hal', $telaahan->hal ?? '-');

        // Isi telaahan
        $template->setValue('persoalan',   $htmlToText($telaahan->persoalan));
        $template->setValue('praanggapan', $htmlToText($telaahan->praanggapan));
        $template->setValue('fakta',       $htmlToText($telaahan->fakta));
        $template->setValue('analisis',    $htmlToText($telaahan->analisis));
        $template->setValue('kesimpulan',  $htmlToText($telaahan->kesimpulan));
        $template->setValue('saran',       $htmlToText($telaahan->saran));

        // Penandatangan
        $pen = $telaahan->penandatangan;
        $template->setValue('jabatan', optional($pen->jabatan)->nama_jabatan ?? '-');
        $template->setValue('nama',    $pen->nama_lengkap ?? $pen->nama ?? '-');
        $template->setValue('pangkat', $pen->pangkat_golongan ?? '-');
        $template->setValue('nip',     $pen->nip ?? '-');

        $filename = 'telaahan_' . \Illuminate\Support\Str::slug($telaahan->nomor ?: 'non_nomor', '_') . '.docx';
        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
