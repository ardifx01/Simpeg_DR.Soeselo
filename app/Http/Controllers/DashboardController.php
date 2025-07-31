<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\Pendidikan;
use App\Models\Penghargaan;
use App\Models\Diklatteknik;
use Illuminate\Http\Request;
use App\Models\Diklatjabatan;
use App\Models\Diklatfungsional;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahPegawai = Pegawai::count();// jumlah Pegawai
        $jumlahPenghargaan = Penghargaan::count();// jumlah Penghargaan
        $jumlahdiklat = Diklatfungsional::count() + Diklatjabatan::count() + Diklatteknik::count();// jumlah Diklat

        // Rekapitulasi Data Pegawai
        $rekapGolongan = Jabatan::select('golongan_ruang', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('golongan_ruang')
            ->get();

        $rekapJabatan = Jabatan::select('nama_jabatan', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('nama_jabatan')
            ->get();

        $rekapEselon = Jabatan::select('eselon', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('eselon')
            ->get();

        $rekapKepegawaian = Jabatan::select('jenis_kepegawaian', DB::raw("COUNT(*) as jumlah"))
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

        return view('dashboard.index', compact(
            'jumlahPegawai', 'jumlahPenghargaan', 'jumlahdiklat', 'rekapGolongan', 
            'rekapJabatan', 'rekapEselon', 'rekapKepegawaian', 'rekapAgama', 'rekapJenisKelamin', 
            'rekapStatusNikah', 'rekapPendidikan'
        ));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $pegawais = Pegawai::where('nama', 'like', "%$search%")->get();

        return view('dashboard.result', compact('pegawais', 'search'));
    }

    public function headerNotification()
    {
        $now = Carbon::now();
        $pegawais = Pegawai::with('jabatan')->get();

        $notifications = [];

        foreach ($pegawais as $pegawai) {
            $tmt = $pegawai->tmt_golongan_ruang ?? $pegawai->tmt_golongan_ruang_cpns;
            $golongan = $pegawai->golongan_ruang ?? $pegawai->golongan_ruang_cpns;

            if (!$tmt || !$golongan) continue;

            $mk = Carbon::parse($tmt)->diffInYears($now);
            $kgbKe = floor($mk / 2);
            $tmtKgbTerakhir = Carbon::parse($tmt)->addYears($kgbKe * 2);

            if ($tmtKgbTerakhir->lte($now)) {
                $notifications[] = [
                    'nama' => $pegawai->nama,
                    'type' => 'KGB',
                    'message' => "KGB untuk {$pegawai->nama} sudah bisa diproses.",
                ];
            }

            if ($mk >= 4) {
                $notifications[] = [
                    'nama' => $pegawai->nama,
                    'type' => 'PANGKAT',
                    'message' => "Pangkat untuk {$pegawai->nama} sudah bisa diusulkan.",
                ];
            }
        }

        return $notifications;
    }
}