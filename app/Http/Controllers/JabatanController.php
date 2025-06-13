<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Jabatan::query();

        // Cek apakah ada pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%$search%")
                ->orWhere('skpd', 'like', "%$search%")
                ->orWhere('eselon', 'like', "%$search%");
        }

        // Ambil jumlah data per halaman dari request (default 10)
        $perPage = $request->input('per_page', 10);
        $jabatans = $query->paginate($perPage)->appends($request->query());

        // Jika request, kembalikan seluruh view index tetapi hanya refresh bagian yang dibutuhkan
        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard.jabatan.index', compact('jabatans'))->render()
            ]);
        }

        $jabatans = Jabatan::with('pegawai')->paginate($perPage);
        return view('dashboard.jabatan.index', compact('jabatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('dashboard.jabatan.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // melakukan validasi data
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'nama'=>'required',
            'skpd'=>'required',
            'tmt'=>'required',
            'eselon'=>'required'
        ]);

        Jabatan::create($request->all());
        return redirect()->route('jabatan.index', $request->pegawai_id)->with('success', 'Jabatan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        return redirect()->route('pegawai.show', $jabatan->pegawai_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan)
    {
        $pegawais = Pegawai::all();
        return view('dashboard.jabatan.edit', compact('jabatan', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        // melakukan validasi data
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'nama'=>'required',
            'skpd'=>'required',
            'tmt'=>'required',
            'eselon'=>'required'
        ]);

        $jabatan->update($request->all());
        return redirect()->route('jabatan.index', $request->pegawai_id)->with('success', 'Jabatan Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jabatan = Jabatan::find($id);

        if (!$jabatan) {
            return redirect()->back()->with('error', 'jabatan tidak ditemukan!');
        }

        $jabatan->delete();
        return redirect()->back()->with('success', 'jabatan berhasil dihapus!');
    }

    public function rekapJabatan()
    {
        // Ambil jumlah pegawai berdasarkan jabatan
        $rekap = Jabatan::select('nama', DB::raw('count(*) as jumlah'))
                        ->whereNotNull('nama')
                        ->groupBy('nama')
                        ->orderBy('nama', 'desc')
                        ->get();

        // Hitung jumlah pegawai tanpa jabatan
        $pegawaiTanpaJabatan = Jabatan::whereNull('nama')->count();

        // Ambil detail pegawai tanpa jabatan
        $dataPegawaiTanpaJabatan = Jabatan::whereNull('nama')->get();

        return view('dashboard.rekapitulasi.jabatan', compact('rekap', 'pegawaiTanpaJabatan', 'dataPegawaiTanpaJabatan'));
    }

    public function rekapEselon()
    {
        // Ambil jumlah pegawai berdasarkan eselon
        $rekap = Jabatan::select('eselon', DB::raw('count(*) as jumlah'))
                        ->whereNotNull('eselon')
                        ->groupBy('eselon')
                        ->orderBy('eselon', 'desc')
                        ->get();

        // Hitung jumlah pegawai tanpa eselon
        $pegawaiTanpaEselon = Jabatan::whereNull('eselon')->count();

        // Ambil detail pegawai tanpa eselom
        $dataPegawaiTanpaEselon = Jabatan::whereNull('eselon')->get();

        return view('dashboard.rekapitulasi.eselon', compact('rekap', 'pegawaiTanpaEselon', 'dataPegawaiTanpaEselon'));
    }
}
