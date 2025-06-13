<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Jabatan;

class EpersonalController extends Controller
{
    public function index()
    {
        $jumlahPegawai = Pegawai::count();// jumlah Pegawai
        $jumlahPNS = Jabatan::where('jenis_kepegawaian', 'PNS')->count();
        $jumlahPPPK = Jabatan::where('jenis_kepegawaian', 'PPPK')->count();
        $jumlahCPNS = Jabatan::where('jenis_kepegawaian', 'CPNS')->count();
        $jumlahBLUD = Jabatan::where('jenis_kepegawaian', 'BLUD')->count();
        

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
