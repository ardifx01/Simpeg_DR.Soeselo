<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Http\Controllers\Controller;

class SuratController extends Controller
{
    public function index()
    {
        return view('surat.index');
    }
    
    public function cuti()
    {
        $pegawais = Pegawai::all();
        return view('surat.cuti', compact('pegawais'));
    }
}
