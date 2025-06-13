<?php

namespace App\Http\Controllers;

use App\Models\Penghargaan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PenghargaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Penghargaan::query();

        // Cek apakah ada pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%$search%")
                ->orWhere('pemberi', 'like', "%$search%");
        }

        // Ambil jumlah data per halaman dari request (default 10)
        $perPage = $request->input('per_page', 10);
        $penghargaans = $query->paginate($perPage)->appends($request->query());

        // Jika request, kembalikan seluruh view index tetapi hanya refresh bagian yang dibutuhkan
        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard.penghargaan.index', compact('penghargaans'))->render()
            ]);
        }

        $penghargaans = Penghargaan::with('pegawai')->paginate($perPage);
        return view('dashboard.penghargaan.index', compact('penghargaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('dashboard.penghargaan.create', compact('pegawais'));
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
            'pemberi'=>'required',
            'tahun'=>'required'
        ]);

        Penghargaan::create($request->all());
        return redirect()->route('penghargaan.index', $request->pegawai_id)->with('success', 'Penghargaan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penghargaan $penghargaan)
    {
        return redirect()->route('pegawai.show', $penghargaan->pegawai_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penghargaan $penghargaan)
    {
        $pegawais = Pegawai::all();
        return view('dashboard.penghargaan.edit', compact('penghargaan', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penghargaan $penghargaan)
    {
        // melakukan validasi data
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'nama'=>'required',
            'pemberi'=>'required',
            'tahun'=>'required'
        ]);

        $penghargaan->update($request->all());
        return redirect()->route('pegawai.show', $request->pegawai_id)->with('success', 'Penghargaan Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $penghargaan = Penghargaan::find($id);

        if (!$penghargaan) {
            return redirect()->back()->with('error', 'Penghargaan tidak ditemukan!');
        }

        $penghargaan->delete();
        return redirect()->back()->with('success', 'Penghargaan berhasil dihapus!');
    }
}
