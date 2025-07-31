<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Carbon\Carbon;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Organisasi::query();

        // Cek apakah ada pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('jenis', 'like', "%$search%")
                ->orWhere('nama', 'like', "%$search%")
                ->orWhere('jataban', 'like', "%$search%");
        }

        // Ambil jumlah data per halaman dari request (default 10)
        $perPage = $request->input('per_page', 10);
        $organisasis = $query->paginate($perPage)->appends($request->query());

        // Jika request, kembalikan seluruh view index tetapi hanya refresh bagian yang dibutuhkan
        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard.organisasi.index', compact('organisasis'))->render()
            ]);
        }

        $organisasis = Organisasi::with('pegawai')->paginate($perPage);
        return view('dashboard.organisasi.index', compact('organisasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('dashboard.organisasi.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'jenis'=>'required',
            'nama'=>'required',
            'jabatan'=>'required',
            'tmt_organisasi'=>'required|date_format:d-m-Y',
        ]);
        // Format tanggal
        $validatedData['tmt_organisasi'] = Carbon::createFromFormat('d-m-Y', $validatedData['tmt_organisasi'])->format('Y-m-d');

        Organisasi::create($validatedData);
        return redirect()->back()->with('success', 'Organisasi Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Organisasi $organisasi)
    {
        return redirect()->route('pegawai.show', $organisasi->pegawai_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organisasi $organisasi)
    {
        $pegawais = Pegawai::all();
        return view('dashboard.organisasi.edit', compact('organisasi', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organisasi $organisasi)
    {
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'jenis'=>'required',
            'nama'=>'required',
            'jabatan'=>'required',
            'tmt_organisasi'=>'required|date_format:d-m-Y',
        ]);
        // Format tanggal
        $validatedData['tmt_organisasi'] = Carbon::createFromFormat('d-m-Y', $validatedData['tmt_organisasi'])->format('Y-m-d');

        $organisasi->update($validatedData);
        return redirect()->back()->with('success', 'Organisasi Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $organisasi = Organisasi::find($id);

        if (!$organisasi) {
            return redirect()->back()->with('error', 'Organisasi tidak ditemukan!');
        }

        $organisasi->delete();
        return redirect()->back()->with('success', 'Organisasi berhasil dihapus!');
    }
}
