<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Diklatjabatan;
use App\Http\Controllers\Controller;

class DiklatjabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Diklatjabatan::query();

        // Cek apakah ada pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%$search%")
                ->orWhere('penyelenggara', 'like', "%$search%");
        }

        // Ambil jumlah data per halaman dari request (default 10)
        $perPage = $request->input('per_page', 10);
        $diklatjabatans = $query->paginate($perPage)->appends($request->query());

        // Jika request, kembalikan seluruh view index tetapi hanya refresh bagian yang dibutuhkan
        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard.diklatjabatan.index', compact('diklatjabatans'))->render()
            ]);
        }
        $diklatjabatans = Diklatjabatan::with('pegawai')->paginate($perPage);
        return view('dashboard.diklatjabatan.index', compact('diklatjabatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('dashboard.diklatjabatan.create', compact('pegawais'));
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

        Diklatjabatan::create($validatedData);
        return redirect()->back()->with('success', 'Diklat Jabatan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Diklatjabatan $diklatjabatan)
    {
        return redirect()->route('pegawai.show', $diklatjabatan->pegawai_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diklatjabatan $diklatjabatan)
    {
        $pegawais = Pegawai::all();
        return view('dashboard.diklatjabatan.edit', compact('diklatjabatan', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diklatjabatan $diklatjabatan)
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

        $diklatjabatan->update($validatedData);
        return redirect()->back()->with('success', 'Diklat Jabatan Berhasil Diperbarui');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diklatjabatan $diklatjabatan)
    {
        $diklatjabatan->delete();
        return redirect()->back()->with('success', 'Diklat teknik berhasil dihapus!');
    }
}
