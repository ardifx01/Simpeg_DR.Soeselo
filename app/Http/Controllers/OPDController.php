<?php

namespace App\Http\Controllers;

use App\Models\OPD;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OPDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OPD::query();

        // Cek apakah ada pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_opd', 'like', "%$search%");
        }

        // Ambil jumlah data per halaman dari request (default 10)
        $perPage = $request->input('per_page', 10);
        $opds = $query->paginate($perPage)->appends($request->query());

        // Jika request, kembalikan seluruh view index tetapi hanya refresh bagian yang dibutuhkan
        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard.opd.index', compact('opds'))->render()
            ]);
        }
        $opds = OPD::with('pegawai')->paginate($perPage);
        $pegawais = Pegawai::all();
        return view('dashboard.opd.index', compact('opds', 'pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_opd' => 'required|string|max:255',
            'alamat' => 'required|string',
            'pegawai_id' => 'required|exists:pegawais,id',
        ]);

        OPD::create($request->all());

        return redirect()->route('opd.index', $request->pegawai_id)->with('success', 'OPD Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(OPD $opd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OPD $opd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OPD $opd)
    {
        $request->validate([
            'nama_opd' => 'required|string|max:255',
            'alamat' => 'required|string',
            'pegawai_id' => 'required|exists:pegawais,id',
        ]);

        $opd->update($request->all());

        return redirect()->route('opd.index', $request->pegawai_id)->with('success', 'OPD Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OPD $opd)
    {
        $opd->delete();

        return redirect()->route('opd.index')->with('success', 'OPD Berhasil Dihapus');
    }

    public function rekapopd()
    {
        // Ambil jumlah pegawai berdasarkan jenis kelamin
        $rekap = OPD::select('nama_opd', DB::raw('count(*) as jumlah'))
                        ->whereNotNull('nama_opd')
                        ->groupBy('nama_opd')
                        ->orderBy('nama_opd', 'desc')
                        ->get();

        // Hitung jumlah pegawai tanpa jenis kelamin
        $pegawaiTanpaopd = OPD::whereNull('nama_opd')->count();

        return view('dashboard.rekapitulasi.opd', compact('rekap', 'pegawaiTanpaopd'));
    }
}
