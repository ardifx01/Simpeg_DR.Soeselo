<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Carbon\Carbon;
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
            $query->where('tingkat_ijin', 'like', "%$search%")
                ->orWhere('jenis_ijin', 'like', "%$search%")
                ->orWhere('nama_ijin', 'like', "%$search%");
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
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'tingkat_ijin'=>'required',
            'jenis_ijin'=>'required',
            'nama_ijin'=>'required',
            'tahun_lulus_ijin'=>'required',
            'no_ijazah_ijin'=>'required',
            'tanggal_ijazah_ijin'=>'required|date_format:d-m-Y',
        ]);

        if (!empty($validatedData['tanggal_ijazah_ijin'])) {
            $validatedData['tanggal_ijazah_ijin'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal_ijazah_ijin'])->format('Y-m-d');
        }

        Ijinbelajar::create($validatedData);
        return redirect()->back()->with('success', 'Izin Belajar Berhasil Ditambahkan');
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
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'tingkat_ijin'=>'required',
            'jenis_ijin'=>'required',
            'nama_ijin'=>'required',
            'tahun_lulus_ijin'=>'required',
            'no_ijazah_ijin'=>'required',
            'tanggal_ijazah_ijin'=>'required|date_format:d-m-Y',
        ]);

        if (!empty($validatedData['tanggal_ijazah_ijin'])) {
            $validatedData['tanggal_ijazah_ijin'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal_ijazah_ijin'])->format('Y-m-d');
        }

        $ijinbelajar->update($validatedData);
        return redirect()->back()->with('success', 'Izin Belajar Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ijinbelajar = Ijinbelajar::find($id);

        if (!$ijinbelajar) {
            return redirect()->back()->with('error', 'Izin Belajar tidak ditemukan!');
        }

        $ijinbelajar->delete();
        return redirect()->back()->with('success', 'Izin Belajar berhasil dihapus!');
    }
}
