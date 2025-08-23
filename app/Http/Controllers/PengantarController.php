<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Pengantar;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class PengantarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pengantars = Pengantar::with(['penerima', 'pengirim'])
            ->when($search, function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                ->orWhere('tujuan', 'like', "%{$search}%")
                ->orWhere('alamat_tujuan', 'like', "%{$search}%")
                ->orWhereHas('penerima', function ($qq) use ($search) {
                    $qq->where('nama', 'like', "%{$search}%")
                        ->orWhere('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nip', 'like', "%{$search}%");
                })
                ->orWhereHas('pengirim', function ($qq) use ($search) {
                    $qq->where('nama', 'like', "%{$search}%")
                        ->orWhere('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nip', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('tanggal_surat')
            ->paginate(10)
            ->appends($request->query());

        return view('surat.pengantar.index', compact('pengantars', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.pengantar.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi awal
        $validated = $request->validate([
            'nomor_surat'     => 'required|string|max:191|unique:pengantars,nomor_surat',
            'tanggal_surat'   => 'required|date_format:d-m-Y',
            'tujuan'          => 'nullable|string|max:191',
            'alamat_tujuan'   => 'nullable|string|max:255',
            'penerima_id'     => 'required|exists:pegawais,id',
            'pengirim_id'     => 'required|exists:pegawais,id',

            'daftar_item'                  => 'required|array|min:1',
            'daftar_item.*.naskah'         => 'nullable|string|max:255',
            'daftar_item.*.banyaknya'      => 'nullable|string|max:50',
            'daftar_item.*.keterangan'     => 'nullable|string|max:255',
        ]);

        // Normalisasi & filter baris item (buang baris kosong)
        $items = collect($request->input('daftar_item', []))
            ->map(fn($r) => [
                'naskah'     => trim($r['naskah'] ?? ''),
                'banyaknya'  => trim($r['banyaknya'] ?? ''),
                'keterangan' => trim($r['keterangan'] ?? ''),
            ])
            ->filter(fn($r) => $r['naskah'] !== '' || $r['banyaknya'] !== '' || $r['keterangan'] !== '')
            ->values()
            ->all();

        // Kalau habis difilter jadi kosong, balikin error
        if (empty($items)) {
            return back()
                ->withErrors(['daftar_item' => 'Minimal isi 1 baris item.'])
                ->withInput();
        }

        // Convert tanggal ke Y-m-d
        $validated['tanggal_surat'] = \Carbon\Carbon::createFromFormat('d-m-Y', $validated['tanggal_surat'])->format('Y-m-d');

        // Assign items yang udah dibersihin
        $validated['daftar_item'] = $items;

        // Simpan (biarkan Eloquent yang encode JSON; jangan json_encode sendiri)
        Pengantar::create($validated);

        return redirect()->route('pengantar.index')->with('success', 'Surat pengantar berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengantar $pengantar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengantar $pengantar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengantar $pengantar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengantar $pengantar)
    {
        //
    }

    public function export($id)
    {
        $p = Pengantar::with(['penerima.jabatan', 'pengirim.jabatan'])->findOrFail($id);
        $template = new TemplateProcessor(storage_path('app/templates/pengantar_template.docx'));

        // Header
        $template->setValue('nomor_surat', $p->nomor_surat ?? '-');
        $template->setValue('tanggal_surat', optional($p->tanggal_surat)->locale('id')->translatedFormat('d F Y') ?? '-');
        $template->setValue('tujuan', $p->tujuan ?? '-');
        $template->setValue('alamat_tujuan', $p->alamat_tujuan ?? '-');

        // Helper
        $namaLengkap = fn($x) => $x?->nama_lengkap ?? $x?->nama ?? '-';
        $pangkat     = fn($x) => $x?->pangkat_golongan ?? '-';
        $telepon     = fn($x) => $x?->telepon ?? $x?->no_hp ?? '-';

        // Penerima (tambah telepon & ganti jabatan -> pangkat_golongan)
        $template->setValue('nama_penerima', $namaLengkap($p->penerima));
        $template->setValue('nip_penerima',  $p->penerima->nip ?? '-');
        $template->setValue('pangkat_penerima', $pangkat($p->penerima));
        $template->setValue('telepon_penerima', $telepon($p->penerima));

        // Pengirim (ganti jabatan -> pangkat_golongan)
        $template->setValue('nama_pengirim', $namaLengkap($p->pengirim));
        $template->setValue('nip_pengirim',  $p->pengirim->nip ?? '-');
        $template->setValue('pangkat_pengirim', $pangkat($p->pengirim));

        // Tabel item (tetep)
        $items = $p->daftar_item;
        if (is_string($items)) {
            $decoded = json_decode($items, true);
            $items = is_array($decoded) ? $decoded : [];
        } elseif (!is_array($items)) {
            $items = [];
        }
        $items = array_values(array_filter($items, fn($r) =>
            is_array($r) && (!empty($r['naskah']) || !empty($r['banyaknya']) || !empty($r['keterangan']))
        ));

        $count = max(count($items), 1);
        $template->cloneRow('no', $count);

        if (!empty($items)) {
            foreach ($items as $i => $row) {
                $idx = $i + 1;
                $template->setValue("no#{$idx}", (string)$idx);
                $template->setValue("naskah#{$idx}", $row['naskah'] ?? '-');
                $template->setValue("banyaknya#{$idx}", $row['banyaknya'] ?? '-');
                $template->setValue("keterangan#{$idx}", $row['keterangan'] ?? '-');
            }
        } else {
            $template->setValue("no#1", '1');
            $template->setValue("naskah#1", '-');
            $template->setValue("banyaknya#1", '-');
            $template->setValue("keterangan#1", '-');
        }

        $filename = 'surat_pengantar_' . Str::slug($p->nomor_surat ?? 'tanpa_nomor', '_') . '.docx';
        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

}
