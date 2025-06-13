<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Penghargaan;
use App\Models\Diklatteknik;
use App\Models\Diklatjabatan;
use App\Models\Diklatfungsional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\OPD;
use App\Models\Pendidikan;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahPegawai = Pegawai::count();// jumlah Pegawai
        $jumlahJabatan = Jabatan::count();// jumlah Jabatan
        $jumlahPenghargaan = Penghargaan::count();// jumlah Penghargaan
        $jumlahdiklat = Diklatfungsional::count() + Diklatjabatan::count() + Diklatteknik::count();// jumlah Diklat

        // Rekapitulasi Data Pegawai
        $rekapGolongan = Pegawai::select('golongan_ruang', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('golongan_ruang')
            ->get();

        $rekapJabatan = Jabatan::select('nama', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('nama')
            ->get();

        $rekapEselon = Jabatan::select('eselon', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('eselon')
            ->get();

        $rekapKepegawaian = Pegawai::select('jenis_kepegawaian', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('jenis_kepegawaian')
            ->get();

        $rekapAgama = Pegawai::select('agama', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('agama')
            ->get();

        $rekapJenisKelamin = Pegawai::select('jenis_kelamin', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('jenis_kelamin')
            ->get();

        $rekapStatusNikah = Pegawai::select('status_nikah', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('status_nikah')
            ->get();

        $rekapPendidikan = Pendidikan::select('tingkat', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('tingkat')
            ->get();

        $rekapOpd = OPD::select('nama_opd', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('nama_opd')
            ->get();

        return view('dashboard.index', compact(
            'jumlahPegawai', 'jumlahJabatan', 'jumlahPenghargaan', 'jumlahdiklat', 'rekapGolongan', 
            'rekapJabatan', 'rekapEselon', 'rekapKepegawaian', 'rekapAgama', 'rekapJenisKelamin', 
            'rekapStatusNikah', 'rekapPendidikan', 'rekapOpd'
        ));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $pegawais = Pegawai::where('nama', 'like', "%$search%")->get();

        return view('dashboard.result', compact('pegawais', 'search'));
    }
}