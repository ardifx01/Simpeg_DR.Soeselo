<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Diklatfungsional;
use App\Http\Controllers\Controller;

class DiklatfungsionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Diklatfungsional::query();

        // Cek apakah ada pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%$search%")
                ->orWhere('penyelenggara', 'like', "%$search%");
        }

        // Ambil jumlah data per halaman dari request (default 10)
        $perPage = $request->input('per_page', 10);
        $diklatfungsionals = $query->paginate($perPage)->appends($request->query());

        // Jika request, kembalikan seluruh view index tetapi hanya refresh bagian yang dibutuhkan
        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard.diklatfungsional.index', compact('diklatfungsionals'))->render()
            ]);
        }

        $diklatfungsionals = Diklatfungsional::with('pegawai')->paginate($perPage);
        return view('dashboard.diklatfungsional.index', compact('diklatfungsionals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('dashboard.diklatfungsional.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // melakukan validasi data
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'nama'=>'required',
            'penyelenggara'=>'required',
            'jumlah_jam'=>'required',
            'tanggal_selesai'=>'required|date_format:d-m-Y',
        ]);
        // Format tanggal
        $validatedData['tanggal_selesai'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal_selesai'])->format('Y-m-d');

        Diklatfungsional::create($validatedData);
        return redirect()->back()->with('success', 'Diklat Fungsional Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Diklatfungsional $diklatfungsional)
    {
        return redirect()->route('pegawai.show', $diklatfungsional->pegawai_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diklatfungsional $diklatfungsional)
    {
        $pegawais = Pegawai::all();
        return view('dashboard.diklatfungsional.edit', compact('diklatfungsional', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diklatfungsional $diklatfungsional)
    {
        // melakukan validasi data
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'nama'=>'required',
            'penyelenggara'=>'required',
            'jumlah_jam'=>'required',
            'tanggal_selesai'=>'required|date_format:d-m-Y',
        ]);
        // Format tanggal
        $validatedData['tanggal_selesai'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal_selesai'])->format('Y-m-d');

        $diklatfungsional->update($validatedData);
        return redirect()->back()->with('success', 'Diklat Fungsional Berhasil Diperbarui');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diklatfungsional $diklatfungsional)
    {
        $diklatfungsional->delete();
        return redirect()->back()->with('success', 'Diklat teknik berhasil dihapus!');
    }
}
