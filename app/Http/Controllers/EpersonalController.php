<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EpersonalController extends Controller
{
    public function index()
    {
        $jumlahPegawai = Pegawai::count();// jumlah Pegawai
        $jumlahPNS = Pegawai::where('jenis_kepegawaian', 'PNS')->count();
        $jumlahPPPK = Pegawai::where('jenis_kepegawaian', 'PPPK')->count();
        $jumlahCPNS = Pegawai::where('jenis_kepegawaian', 'CPNS')->count();
        $jumlahBLUD = Pegawai::where('jenis_kepegawaian', 'BLUD')->count();
        

        return view('dashboard.epersonal', compact(
            'jumlahPegawai', 'jumlahPNS', 'jumlahPPPK', 'jumlahCPNS', 'jumlahBLUD'
        ));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $pegawais = Pegawai::where('nama', 'like', "%$search%")->get();

        return view('dashboard.result', compact('pegawais', 'search'));
    }
}
