<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pendidikan::query();

        // Cek apakah ada pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('tingkat', 'like', "%$search%")
                ->orWhere('jurusan', 'like', "%$search%")
                ->orWhere('nama', 'like', "%$search%");
        }

        // Ambil jumlah data per halaman dari request (default 10)
        $perPage = $request->input('per_page', 10);
        $pendidikans = $query->paginate($perPage)->appends($request->query());

        // Jika request, kembalikan seluruh view index tetapi hanya refresh bagian yang dibutuhkan
        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard.pendidikan.index', compact('pendidikans'))->render()
            ]);
        }

        $pendidikans = Pendidikan::with('pegawai')->paginate($perPage);
        return view('dashboard.pendidikan.index', compact('pendidikans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('dashboard.pendidikan.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // melakukan validasi data
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'tingkat'=>'required',
            'jurusan'=>'required',
            'nama'=>'required',
            'tahun_lulus'=>'required',
            'no_ijazah'=>'required',
            'tanggal_ijazah'=>'required'
        ]);

        Pendidikan::create($request->all());
        return redirect()->route('pendidikan.index', $request->pegawai_id)->with('success', 'Pendidikan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pendidikan $pendidikan)
    {
        return redirect()->route('pegawai.show', $pendidikan->pegawai_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pendidikan $pendidikan)
    {
        $pegawais = Pegawai::all();
        return view('dashboard.pendidikan.edit', compact('pendidikan', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pendidikan $pendidikan)
    {
        // melakukan validasi data
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'tingkat'=>'required',
            'jurusan'=>'required',
            'nama'=>'required',
            'tahun_lulus'=>'required',
            'no_ijazah'=>'required',
            'tanggal_ijazah'=>'required'
        ]);
        $pendidikan->update($request->all());
        return redirect()->route('pegawai.show', $pendidikan->pegawai_id)->with('success', 'Pendidikan Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pendidikan = Pendidikan::find($id);

        if (!$pendidikan) {
            return redirect()->back()->with('error', 'Pendidikan tidak ditemukan!');
        }

        $pendidikan->delete();
        return redirect()->back()->with('success', 'Pendidikan berhasil dihapus!');
    }

    public function rekapPendidikanAkhir()
    {
        // Ambil jumlah pegawai berdasarkan pendidikan
        $rekap = Pendidikan::select('tingkat', DB::raw('count(*) as jumlah'))
                        ->whereNotNull('tingkat')
                        ->groupBy('tingkat')
                        ->orderBy('tingkat', 'desc')
                        ->get();

        // Hitung jumlah pegawai tanpa pendidikan
        $pegawaiTanpaPendidikan = Pendidikan::whereNull('tingkat')->count();

        // Ambil detail pegawai tanpa pendidikan
        $dataPegawaiTanpaPendidikan = Pendidikan::whereNull('tingkat')->get();

        return view('dashboard.rekapitulasi.pendidikan', compact('rekap', 'pegawaiTanpaPendidikan', 'dataPegawaiTanpaPendidikan'));
    }
}
