<?php

namespace App\Http\Controllers;

use App\Models\Istri;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IstriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Istri::query();

        // Cek apakah ada pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%$search%");
        }

        // Ambil jumlah data per halaman dari request (default 10)
        $perPage = $request->input('per_page', 10);
        $istris = $query->paginate($perPage)->appends($request->query());

        // Jika request, kembalikan seluruh view index tetapi hanya refresh bagian yang dibutuhkan
        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard.istri.index', compact('istris'))->render()
            ]);
        }
        $istris = Istri::with('pegawai')->paginate($perPage);
        return view('dashboard.istri.index', compact('istris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('dashboard.istri.create', compact('pegawais'));
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
            'tempat_lahir'=>'required',
            'tanggal_lahir'=>'required',
            'profesi'=>'required',
            'tanggal_nikah'=>'required',
            'status_hubungan'=>'required'
        ]);

        Istri::create($request->all());
        return redirect()->route('istri.index', $request->pegawai_id)->with('success', 'Istri Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Istri $istri)
    {
        return redirect()->route('pegawai.show', $istri->pegawai_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Istri $istri)
    {
        $pegawais = Pegawai::all();
        return view('dashboard.istri.edit', compact('istri', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Istri $istri)
    {
        // melakukan validasi data
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'nama'=>'required',
            'tempat_lahir'=>'required',
            'tanggal_lahir'=>'required',
            'profesi'=>'required',
            'tanggal_nikah'=>'required',
        ]);
        $istri->update($request->all());
        return redirect()->route('pegawai.show', $istri->pegawai_id)->with('success', 'Istri Berhasil Diperbarui');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $istri = Istri::find($id);

        if (!$istri) {
            return redirect()->back()->with('error', 'Istri tidak ditemukan!');
        }

        $istri->delete();
        return redirect()->back()->with('success', 'Istri berhasil dihapus!');
    }
}
