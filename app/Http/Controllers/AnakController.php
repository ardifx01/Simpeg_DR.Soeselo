<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Anak::query();

        // Cek apakah ada pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%$search%");
        }

        // Ambil jumlah data per halaman dari request (default 10)
        $perPage = $request->input('per_page', 10);
        $anaks = $query->paginate($perPage)->appends($request->query());

        // Jika request, kembalikan seluruh view index tetapi hanya refresh bagian yang dibutuhkan
        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard.anak.index', compact('anaks'))->render()
            ]);
        }
        
        $anaks = Anak::with('pegawai')->paginate($perPage);
        return view('dashboard.anak.index', compact('anaks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $pegawais = Pegawai::all();
        return view('dashboard.anak.create', compact('pegawais'));
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
            'tanggal_lahir'=>'required',
            'tempat_lahir'=>'required',
            'status_keluarga'=>'required',
            'status_tunjangan'=>'required',
            'jenis_kelamin'=>'required'
        ]);

        Anak::create($request->all());
        return redirect()->route('anak.index', $request->pegawai_id)->with('success', 'Anak Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Anak $anak)
    {
        return redirect()->route('pegawai.show', $anak->pegawai_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anak $anak)
    {
        $pegawais = Pegawai::all();
        return view('dashboard.anak.edit', compact('anak', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anak $anak)
    {
        // melakukan validasi data
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'nama'=>'required',
            'tanggal_lahir'=>'required',
            'tempat_lahir'=>'required',
            'status_keluarga'=>'required',
            'status_tunjangan'=>'required',
            'jenis_kelamin'=>'required'
        ]);

        $anak->update($request->all());
        return redirect()->route('pegawai.show', $request->pegawai_id)->with('success', 'Anak Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $anak = Anak::find($id);

        if (!$anak) {
            return redirect()->back()->with('error', 'Anak tidak ditemukan!');
        }

        $anak->delete();
        return redirect()->back()->with('success', 'Anak berhasil dihapus!');
    }
}
