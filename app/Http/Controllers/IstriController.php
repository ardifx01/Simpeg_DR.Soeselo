<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        // Validasi apakah pegawai sudah menikah
        $pegawai = Pegawai::findOrFail($request->pegawai_id);

        if ($pegawai->status_nikah === 'Belum') {
            return redirect()->back()->with('error', 'Pegawai belum menikah. Tidak bisa mengisi data Suami/Istri.');
        }
        // melakukan validasi data
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'nama'=>'required',
            'tempat_lahir'=>'required',
            'tanggal_lahir_istri'=>'required',
            'profesi'=>'required',
            'tanggal_nikah'=>'required',
            'status_hubungan'=>'required'
        ]);

        // Ubah format tanggal
        if (!empty($validatedData['tanggal_lahir_istri'])) {
            $validatedData['tanggal_lahir_istri'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal_lahir_istri'])->format('Y-m-d');
        }

        if (!empty($validatedData['tanggal_nikah'])) {
            $validatedData['tanggal_nikah'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal_nikah'])->format('Y-m-d');
        }

        Istri::create($validatedData);

        return redirect()->back()->with('success', 'Istri berhasil ditambahkan!');
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
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'nama'=>'required',
            'tempat_lahir'=>'required',
            'tanggal_lahir_istri'=>'required',
            'profesi'=>'required',
            'tanggal_nikah'=>'required',
        ]);

        // Ubah format tanggal
        if (!empty($validatedData['tanggal_lahir_istri'])) {
            $validatedData['tanggal_lahir_istri'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal_lahir_istri'])->format('Y-m-d');
        }

        if (!empty($validatedData['tanggal_nikah'])) {
            $validatedData['tanggal_nikah'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal_nikah'])->format('Y-m-d');
        }

        // Update data istri
        $istri->update($validatedData);

        return redirect()->back()->with('success', 'Istri berhasil diperbarui!');
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
