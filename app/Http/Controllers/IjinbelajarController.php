<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Ijinbelajar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIjinbelajarRequest;
use App\Http\Requests\UpdateIjinbelajarRequest;

class IjinbelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ijinbelajar::query();

        // Cek apakah ada pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('tingkat', 'like', "%$search%")
                ->orWhere('jenis', 'like', "%$search%")
                ->orWhere('nama', 'like', "%$search%");
        }

        // Ambil jumlah data per halaman dari request (default 10)
        $perPage = $request->input('per_page', 10);
        $ijinbelajars = $query->paginate($perPage)->appends($request->query());

        // Jika request, kembalikan seluruh view index tetapi hanya refresh bagian yang dibutuhkan
        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard.ijinbelajar.index', compact('ijinbelajars'))->render()
            ]);
        }

        $ijinbelajars = Ijinbelajar::with('pegawai')->paginate($perPage);
        return view('dashboard.ijinbelajar.index', compact('ijinbelajars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('dashboard.ijinbelajar.create', compact('pegawais'));
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
            'jenis'=>'required',
            'nama'=>'required',
            'tahun_lulus'=>'required',
            'no_ijazah'=>'required',
            'tanggal_ijazah'=>'required'
        ]);

        Ijinbelajar::create($request->all());
        return redirect()->route('ijinbelajar.index', $request->pegawai_id)->with('success', 'Ijin Belajar Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ijinbelajar $ijinbelajar)
    {
        return redirect()->route('pegawai.show', $ijinbelajar->pegawai_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ijinbelajar $ijinbelajar)
    {
        $pegawais = Pegawai::all();
        return view('dashboard.ijinbelajar.edit', compact('ijinbelajar', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ijinbelajar $ijinbelajar)
    {
        // melakukan validasi data
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'tingkat'=>'required',
            'jenis'=>'required',
            'nama'=>'required',
            'tahun_lulus'=>'required',
            'no_ijazah'=>'required',
            'tanggal_ijazah'=>'required'
        ]);

        $ijinbelajar->update($request->all());
        return redirect()->route('pegawai.show', $request->pegawai_id)->with('success', 'Ijin Belajar Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ijinbelajar = Ijinbelajar::find($id);

        if (!$ijinbelajar) {
            return redirect()->back()->with('error', 'Ijin Belajar tidak ditemukan!');
        }

        $ijinbelajar->delete();
        return redirect()->back()->with('success', 'Ijin Belajar berhasil dihapus!');
    }
}
