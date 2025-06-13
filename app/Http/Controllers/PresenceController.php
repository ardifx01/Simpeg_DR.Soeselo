<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Presence;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presences = Presence::with('pegawai')->latest()->get();
        return view('dashboard.presences.index', compact('presences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            // 'latitude' => 'required|numeric',
            // 'longitude' => 'required|numeric',
        ]
        // , [
        //     'latitude.required' => 'Lokasi wajib diisi sebelum Check In.',
        //     'longitude.required' => 'Lokasi wajib diisi sebelum Check In.',
        // ]
    );
    
        if (Presence::hasCheckedInToday($request->pegawai_id)) {
            return redirect()->back()->with('error', 'Anda sudah melakukan Check In hari ini.');
        }
    
        Presence::create([
            'pegawai_id' => $request->pegawai_id,
            'check_in' => now()->format('Y-m-d H:i:s'),
            // 'latitude' => $request->latitude,
            // 'longitude' => $request->longitude,
        ]);
    
        return redirect()->back()->with('success', 'Check In berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presence $presence)
    {
        // $request->validate([
        //     'latitude' => 'required',
        //     'longitude' => 'required',
        // ]);
    
        if (Presence::hasCheckedOutToday($presence->pegawai_id)) {
            return redirect()->back()->with('error', 'Anda Sudah Melakukan Check Out Hari Ini.');
        }
    
        $presence->update([
            'check_out' => Carbon::now()->format('Y-m-d H:i:s'),
            // 'latitude' => $request->latitude,
            // 'longitude' => $request->longitude,
        ]);
    
        return redirect()->back()->with('success', 'Check Out Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
