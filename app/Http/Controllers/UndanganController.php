<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Undangan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class UndanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $undangan = Undangan::with(['penandatangan.jabatan'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('nomor', 'like', "%{$search}%")
                        ->orWhere('sifat', 'like', "%{$search}%")
                        ->orWhere('hal', 'like', "%{$search}%")
                        ->orWhere('yth', 'like', "%{$search}%")
                        ->orWhere('alamat', 'like', "%{$search}%")
                        ->orWhere('tempat', 'like', "%{$search}%")
                        ->orWhere('acara', 'like', "%{$search}%")
                        ->orWhereRaw("CAST(tembusan AS CHAR) LIKE ?", ["%{$search}%"]);
                });
            })
            ->orderByDesc('tanggal_surat')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('surat.undangan.index', compact('undangan', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.undangan.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tempat_surat'  => 'required|string|max:191',
            'tanggal_surat' => 'required|date_format:d-m-Y',
            'nomor'         => 'required|string|max:191|unique:undangans,nomor',
            'sifat'         => 'nullable|string|max:191',
            'lampiran'      => 'nullable|string|max:191',
            'hal'           => 'required|string',
            'yth'           => 'required|string|max:191',
            'alamat'        => 'nullable|string|max:191',
            'pembuka_surat' => 'nullable|string',
            'penutup_surat' => 'nullable|string',
            'tanggal_acara' => 'required|date_format:d-m-Y',
            'hari'          => 'nullable|string|max:50',
            'waktu'         => 'required|string|max:191',
            'tempat'        => 'required|string|max:191',
            'acara'         => 'required|string',
            'penandatangan_id' => 'required|exists:pegawais,id',
            'tembusan'      => 'nullable|string',
        ]);

        $validated['tanggal_surat'] = Carbon::createFromFormat('d-m-Y', $validated['tanggal_surat'])->format('Y-m-d');
        $validated['tanggal_acara'] = Carbon::createFromFormat('d-m-Y', $validated['tanggal_acara'])->format('Y-m-d');

        $validated['tembusan'] = !empty($validated['tembusan'])
            ? array_values(array_filter(array_map('trim', explode(',', $validated['tembusan']))))
            : [];

        Undangan::create($validated);

        return redirect()->route('undangan.index')->with('success', 'Surat undangan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Undangan $undangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Undangan $undangan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Undangan $undangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Undangan $undangan)
    {
        $undangan->delete();
        return back()->with('success', 'Surat undangan dipindahkan ke tong sampah.');
    }

    public function trash(Request $request)
    {
        $search = $request->input('search');

        $undangans = Undangan::onlyTrashed()
            ->when($search, function ($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                    ->orWhere('sifat', 'like', "%{$search}%")
                    ->orWhere('hal', 'like', "%{$search}%")
                    ->orWhere('yth', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('tempat', 'like', "%{$search}%")
                    ->orWhere('acara', 'like', "%{$search}%")
                    ->orWhere('tanggal_surat', 'like', "%{$search}%")
                    ->orWhere('tanggal_acara', 'like', "%{$search}%")
                    ->orWhereHas('penandatangan', fn ($qp) =>
                            $qp->where('nama', 'like', "%{$search}%")
                            ->orWhere('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%")
                    );
            })
            ->orderByDesc('deleted_at')
            ->paginate(10)
            ->withQueryString();

        return view('undangan.trash', compact('undangans', 'search'));
    }

    public function restore($id)
    {
        $undangan = Undangan::onlyTrashed()->findOrFail($id);
        $undangan->restore();

        return back()->with('success', 'Surat undangan berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $undangan = Undangan::onlyTrashed()->findOrFail($id);
        $undangan->forceDelete();

        return back()->with('success', 'Surat undangan dihapus permanen.');
    }

    public function export($id)
    {
        $undangan = Undangan::with(['penandatangan.jabatan'])->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/undangan_template.docx'));

        $fmt = fn($d) => $d ? Carbon::parse($d)->translatedFormat('d F Y') : '-';

        // helper: Trix HTML → plain text (biar aman untuk setValue)
        $htmlToText = function (?string $html) {
            if (!$html) return '-';
            // ganti <br> & </p> jadi newline
            $text = preg_replace('/<\s*br\s*\/?>/i', "\n", $html);
            $text = preg_replace('/<\/p>/i', "\n", $text);
            // hapus semua tag
            $text = strip_tags($text);
            // normalisasi whitespace
            $text = preg_replace("/\r\n|\r|\n/", "\n", $text);
            $text = trim($text);
            return $text === '' ? '-' : $text;
        };

        // header
        $template->setValue('nomor', $undangan->nomor ?? '-');
        $template->setValue('sifat', $undangan->sifat ?: '-');
        $template->setValue('lampiran', $undangan->lampiran ?: '-');
        $template->setValue('hal', $undangan->hal ?? '-');

        $template->setValue('tempat_tanggal', ($undangan->tempat_surat ?? '-') . ', ' . $fmt($undangan->tanggal_surat));

        // tujuan
        $template->setValue('yth', $undangan->yth ?? '-');
        $template->setValue('alamat', $undangan->alamat ?: '-');

        // isi bebas
        $template->setValue('pembuka_surat', $htmlToText($undangan->pembuka_surat));
        $template->setValue('penutup_surat', $htmlToText($undangan->penutup_surat));

        // acara
        $template->setValue('hari', $undangan->hari ?: '-');
        $template->setValue('tanggal', $fmt($undangan->tanggal_acara));
        $template->setValue('waktu', $undangan->waktu ?? '-');
        $template->setValue('tempat', $undangan->tempat ?? '-');
        $template->setValue('acara', $undangan->acara ?? '-');

        // penandatangan
        $pegawai = $undangan->penandatangan;
        $template->setValue('jabatan_penandatangan', optional($pegawai->jabatan)->nama_jabatan ?? '-');
        $template->setValue('nama_penandatangan', $pegawai->nama_lengkap ?? $pegawai->nama ?? '-');
        $template->setValue('pangkat_penandatangan', $pegawai->pangkat_golongan ?? '-');
        $template->setValue('nip_penandatangan', $pegawai->nip ?? '-');

        // tembusan
        $tembusan = is_array($undangan->tembusan) ? $undangan->tembusan : [];
        if (count($tembusan)) {
            $lines = [];
            foreach ($tembusan as $i => $tembusan) {
                $tembusan = trim((string)$tembusan);
                if ($tembusan !== '') {
                    $lines[] = ($i + 1) . '. ' . $tembusan;
                }
            }
            $template->setValue('tembusan', $lines ? implode("\n", $lines) : '-');
        } else {
            $template->setValue('tembusan', '-');
        }

        $filename = 'surat_undangan_' . Str::slug($undangan->nomor ?: 'non_nomor', '_') . '.docx';
        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
