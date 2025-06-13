<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class NominatifController extends Controller
{
    public function index()
    {
        $allPegawais = Pegawai::all();
        return view('dashboard.nominatif.index', [
            'allPegawais' => $allPegawais,
        ]);
    }

    public function show(Request $request)
    {
        $allPegawais = Pegawai::all();

        // Nama-nama filter dari form filter kiri
        $filters = [
            'pegawai_id', 'unit_kerja', 'jenis_jabatan', 'golongan_dari', 'golongan_sampai', 'arah',
            'jenis_kepegawaian', 'eselon', 'jenis_kelamin', 'agama', 'tingkat', 'status'
        ];

        // Cek apakah SEMUA filter kosong
        $allFiltersEmpty = true;
        foreach($filters as $f) {
            if ($request->filled($f)) {
                $allFiltersEmpty = false;
                break;
            }
        }

        // Query utama dengan relasi
        $query = Pegawai::with(['jabatan', 'pendidikans']);

        if ($allFiltersEmpty) {
            $pegawais = $query->get();
        } else {
            // Filter
            if ($request->filled('unit_kerja')) {
                $query->whereHas('jabatan', function($q) use ($request) {
                    $q->where('unit_kerja', 'like', '%' . $request->unit_kerja . '%');
                });
            }

            if ($request->filled('jenis_jabatan')) {
                $query->whereHas('jabatan', function($q) use ($request) {
                    $q->where('jenis_jabatan', $request->jenis_jabatan);
                });
            }

            if ($request->filled('jenis_kepegawaian')) {
                $query->whereHas('jabatan', function($q) use ($request) {
                    $q->where('jenis_kepegawaian', $request->jenis_kepegawaian);
                });
            }

            if ($request->filled('eselon')) {
                $query->whereHas('jabatan', function($q) use ($request) {
                    $q->where('eselon', $request->eselon);
                });
            }

            if ($request->filled('jenis_kelamin')) {
                $query->where('jenis_kelamin', $request->jenis_kelamin);
            }

            if ($request->filled('agama')) {
                $query->where('agama', $request->agama);
            }

            if ($request->filled('tingkat')) {
                $query->whereHas('pendidikans', function($q) use ($request) {
                    $q->where('tingkat', $request->tingkat);
                });
            }

            if ($request->filled('status')) {
                $query->whereHas('jabatan', function($q) use ($request) {
                    $q->where('status', $request->status);
                });
            }

            if ($request->filled('golongan_dari') && $request->filled('golongan_sampai')) {
                $arah = $request->get('arah', 'antara');
                if ($arah == 'keatas') {
                    $query->where('golongan_ruang', '>=', $request->golongan_dari);
                } elseif ($arah == 'kebawah') {
                    $query->where('golongan_ruang', '<=', $request->golongan_dari);
                } else { // antara
                    $query->whereBetween('golongan_ruang', [$request->golongan_dari, $request->golongan_sampai]);
                }
            }

            if ($request->filled('pegawai_id')) {
                $query->where('id', $request->pegawai_id);
            }

            // Urutan/sorting
            $sortBy = $request->get('urut', 'nama');
            $sortOrder = $request->get('model', 'ascending') == 'ascending' ? 'asc' : 'desc';

            switch ($sortBy) {
                case 'golongan_ruang':
                    $query->orderBy('golongan_ruang', $sortOrder);
                    break;
                case 'nip':
                    $query->orderBy('nip', $sortOrder);
                    break;
                case 'usia':
                    $query->orderBy('tanggal_lahir', $sortOrder);
                    break;
                default:
                    $query->orderBy('nama', $sortOrder);
                    break;
            }
        }

        $pegawais = $query->get();

        // Kolom tampilan berdasarkan checkbox display_columns[]
        $displayColumns = $this->getDisplayColumns($request);

        return view('dashboard.nominatif.index', [
            'pegawais' => $pegawais,
            'allPegawais' => $allPegawais,
            'displayColumns' => $displayColumns,
            'request' => $request
        ]);
    }

    private function getDisplayColumns($request)
    {
        // Kolom default yang selalu tampil
        $columns = [
            'no' => 'No',
            'nip' => 'NIP',
            'nama' => 'Nama'
        ];

        // Ambil kolom yang dicentang user
        $selected = $request->display_columns ?? [];

        // Daftar kolom yang tersedia untuk dicentang user
        $all = [
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'agama' => 'Agama',
            'jenis_kelamin' => 'Jenis Kelamin',
            'alamat' => 'Alamat',
            'telepon' => 'Nomor HP',
            'no_npwp' => 'NPWP',
            'no_ktp' => 'Nomor KTP',
            'jenis_kepegawaian' => 'Status Pegawai',
            'tmt_golongan_cpns' => 'TMT CPNS',
            'tmt_pns' => 'TMT PNS',
            'golongan_ruang' => 'Gol. Ruang',
            'pangkat' => 'Pangkat',
            'tmt_pangkat' => 'TMT Pangkat',
            'tingkat_pendidikan' => 'Tingkat Pendidikan',
            'jurusan' => 'Jurusan',
            'nama_sekolah' => 'Nama Sekolah',
            'tahun_lulus' => 'Tahun Lulus',
            'unit_kerja' => 'Unit Kerja',
            'sub_unit' => 'Sub Unit',
            'jenis_jabatan' => 'Jenis Jabatan',
            'jabatan' => 'Jabatan',
            'tmt_jabatan' => 'TMT Jabatan',
        ];

        foreach ($all as $key => $label) {
            if (in_array($key, $selected)) {
                $columns[$key] = $label;
            }
        }

        return $columns;
    }

    public function preview(Request $request)
    {
        $allPegawais = Pegawai::all();

        // Nama-nama filter dari form filter kiri
        $filters = [
            'pegawai_id', 'unit_kerja', 'jenis_jabatan', 'golongan_dari', 'golongan_sampai', 'arah',
            'jenis_kepegawaian', 'eselon', 'jenis_kelamin', 'agama', 'tingkat', 'status'
        ];

        // Cek apakah SEMUA filter kosong
        $allFiltersEmpty = true;
        foreach($filters as $f) {
            if ($request->filled($f)) {
                $allFiltersEmpty = false;
                break;
            }
        }

        // Query utama dengan relasi
        $query = Pegawai::with(['jabatan', 'pendidikans']);

        if ($allFiltersEmpty) {
            $pegawais = $query->get();
        } else {
            // Filter sama dengan method show()
            if ($request->filled('unit_kerja')) {
                $query->whereHas('jabatan', function($q) use ($request) {
                    $q->where('unit_kerja', 'like', '%' . $request->unit_kerja . '%');
                });
            }

            if ($request->filled('jenis_jabatan')) {
                $query->whereHas('jabatan', function($q) use ($request) {
                    $q->where('jenis_jabatan', $request->jenis_jabatan);
                });
            }

            if ($request->filled('jenis_kepegawaian')) {
                $query->whereHas('jabatan', function($q) use ($request) {
                    $q->where('jenis_kepegawaian', $request->jenis_kepegawaian);
                });
            }

            if ($request->filled('eselon')) {
                $query->whereHas('jabatan', function($q) use ($request) {
                    $q->where('eselon', $request->eselon);
                });
            }

            if ($request->filled('jenis_kelamin')) {
                $query->where('jenis_kelamin', $request->jenis_kelamin);
            }

            if ($request->filled('agama')) {
                $query->where('agama', $request->agama);
            }

            if ($request->filled('tingkat')) {
                $query->whereHas('pendidikans', function($q) use ($request) {
                    $q->where('tingkat', $request->tingkat);
                });
            }

            if ($request->filled('status')) {
                $query->whereHas('jabatan', function($q) use ($request) {
                    $q->where('status', $request->status);
                });
            }

            if ($request->filled('golongan_dari') && $request->filled('golongan_sampai')) {
                $arah = $request->get('arah', 'antara');
                if ($arah == 'keatas') {
                    $query->where('golongan_ruang', '>=', $request->golongan_dari);
                } elseif ($arah == 'kebawah') {
                    $query->where('golongan_ruang', '<=', $request->golongan_dari);
                } else { // antara
                    $query->whereBetween('golongan_ruang', [$request->golongan_dari, $request->golongan_sampai]);
                }
            }

            if ($request->filled('pegawai_id')) {
                $query->where('id', $request->pegawai_id);
            }

            // Urutan/sorting
            $sortBy = $request->get('urut', 'nama');
            $sortOrder = $request->get('model', 'ascending') == 'ascending' ? 'asc' : 'desc';

            switch ($sortBy) {
                case 'golongan_ruang':
                    $query->orderBy('golongan_ruang', $sortOrder);
                    break;
                case 'nip':
                    $query->orderBy('nip', $sortOrder);
                    break;
                case 'usia':
                    $query->orderBy('tanggal_lahir', $sortOrder);
                    break;
                default:
                    $query->orderBy('nama', $sortOrder);
                    break;
            }
        }

        $pegawais = $query->get();
        $displayColumns = $this->getDisplayColumns($request);

        return view('dashboard.nominatif.cetak_pdf', [
            'pegawais' => $pegawais,
            'displayColumns' => $displayColumns,
            'request' => $request,
            'allPegawais' => $allPegawais
        ]);
    }

    public function cetak(Request $request)
    {
        // Sama dengan preview tapi untuk PDF
        $allPegawais = Pegawai::all();

        $filters = [
            'pegawai_id', 'unit_kerja', 'jenis_jabatan', 'golongan_dari', 'golongan_sampai', 'arah',
            'jenis_kepegawaian', 'eselon', 'jenis_kelamin', 'agama', 'tingkat', 'status'
        ];

        $allFiltersEmpty = true;
        foreach($filters as $f) {
            if ($request->filled($f)) {
                $allFiltersEmpty = false;
                break;
            }
        }

        $query = Pegawai::with(['jabatan', 'pendidikans']);

        if (!$allFiltersEmpty) {
            // Terapkan filter yang sama
            if ($request->filled('unit_kerja')) {
                $query->whereHas('jabatan', function($q) use ($request) {
                    $q->where('unit_kerja', 'like', '%' . $request->unit_kerja . '%');
                });
            }

            if ($request->filled('jenis_jabatan')) {
                $query->whereHas('jabatan', function($q) use ($request) {
                    $q->where('jenis_jabatan', $request->jenis_jabatan);
                });
            }

            if ($request->filled('jenis_kepegawaian')) {
                $query->whereHas('jabatan', function($q) use ($request) {
                    $q->where('jenis_kepegawaian', $request->jenis_kepegawaian);
                });
            }

            if ($request->filled('eselon')) {
                $query->whereHas('jabatan', function($q) use ($request) {
                    $q->where('eselon', $request->eselon);
                });
            }

            if ($request->filled('jenis_kelamin')) {
                $query->where('jenis_kelamin', $request->jenis_kelamin);
            }

            if ($request->filled('agama')) {
                $query->where('agama', $request->agama);
            }

            if ($request->filled('tingkat')) {
                $query->whereHas('pendidikans', function($q) use ($request) {
                    $q->where('tingkat', $request->tingkat);
                });
            }

            if ($request->filled('status')) {
                $query->whereHas('jabatan', function($q) use ($request) {
                    $q->where('status', $request->status);
                });
            }

            if ($request->filled('golongan_dari') && $request->filled('golongan_sampai')) {
                $arah = $request->get('arah', 'antara');
                if ($arah == 'keatas') {
                    $query->where('golongan_ruang', '>=', $request->golongan_dari);
                } elseif ($arah == 'kebawah') {
                    $query->where('golongan_ruang', '<=', $request->golongan_dari);
                } else {
                    $query->whereBetween('golongan_ruang', [$request->golongan_dari, $request->golongan_sampai]);
                }
            }

            if ($request->filled('pegawai_id')) {
                $query->where('id', $request->pegawai_id);
            }

            $sortBy = $request->get('urut', 'nama');
            $sortOrder = $request->get('model', 'ascending') == 'ascending' ? 'asc' : 'desc';

            switch ($sortBy) {
                case 'golongan_ruang':
                    $query->orderBy('golongan_ruang', $sortOrder);
                    break;
                case 'nip':
                    $query->orderBy('nip', $sortOrder);
                    break;
                case 'usia':
                    $query->orderBy('tanggal_lahir', $sortOrder);
                    break;
                default:
                    $query->orderBy('nama', $sortOrder);
                    break;
            }
        }

        $pegawais = $query->get();
        $displayColumns = $this->getDisplayColumns($request);

        $pdf = PDF::loadView('dashboard.nominatif.cetak_pdf', compact('pegawais', 'displayColumns', 'allPegawais'))
            ->setPaper('A4', 'landscape')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'margin-bottom' => 0,
            ]);
        return $pdf->download('nominatif-pegawai.pdf');
    }
}