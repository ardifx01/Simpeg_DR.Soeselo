<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Diklatteknik;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiklatteknikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Diklatteknik::query();

        // Cek apakah ada pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%$search%")
                ->orWhere('penyelenggara', 'like', "%$search%");
        }

        // Ambil jumlah data per halaman dari request (default 10)
        $perPage = $request->input('per_page', 10);
        $diklattekniks = $query->paginate($perPage)->appends($request->query());

        // Jika request, kembalikan seluruh view index tetapi hanya refresh bagian yang dibutuhkan
        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard.diklatteknik.index', compact('diklattekniks'))->render()
            ]);
        }
        $diklattekniks = Diklatteknik::with('pegawai')->paginate($perPage);
        return view('dashboard.diklatteknik.index', compact('diklattekniks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('dashboard.diklatteknik.create', compact('pegawais'));
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
            'penyelenggara'=>'required',
            'jumlah_jam'=>'required',
            'tanggal_selesai'=>'required'
        ]);

        Diklatteknik::create($request->all());
        return redirect()->route('diklatteknik.index', $request->pegawai_id)->with('success', 'Diklat teknik Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Diklatteknik $diklatteknik)
    {
        return redirect()->route('pegawai.show', $diklatteknik->pegawai_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diklatteknik $diklatteknik)
    {
        $pegawais = Pegawai::all();
        return view('dashboard.diklatteknik.edit', compact('diklatteknik', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diklatteknik $diklatteknik)
    {
        // melakukan validasi data
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'nama'=>'required',
            'penyelenggara'=>'required',
            'jumlah_jam'=>'required',
            'tanggal_selesai'=>'required',
        ]);
        $diklatteknik->update($request->all());
        return redirect()->route('pegawai.show', $diklatteknik->pegawai_id)->with('success', 'Diklat teknik Berhasil Diperbarui');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $diklatteknik = Diklatteknik::find($id);

        if (!$diklatteknik) {
            return redirect()->back()->with('error', 'Diklat teknik tidak ditemukan!');
        }

        $diklatteknik->delete();
        return redirect()->back()->with('success', 'Diklat teknik berhasil dihapus!');
    }
}
