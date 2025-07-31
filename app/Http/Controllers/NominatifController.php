<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\NominatifPegawaiExport;
use Maatwebsite\Excel\Facades\Excel;

class NominatifController extends Controller
{
    public function index(Request $request)
    {
        $displayColumns = $this->getDisplayColumns($request);
        $pegawais = collect();
        $isSubmitted = false;

        if ($request->isMethod('post')) {
            $isSubmitted = true;
            $query = Pegawai::with(['jabatan', 'pendidikans']);
            
            // Jika semua filter kosong, tampilkan semua pegawai
            if (!$this->hasRealFilter($request)) {
                $pegawais = $query->get();
            } else {
                $query = $this->applyFilters($request, $query);
                $pegawais = $query->get();
            }

            // Simpan data ke session dan redirect
            session([
                'nominatif_data' => $pegawais,
                'nominatif_filters' => $request->all(),
                'nominatif_columns' => $displayColumns,
                'nominatif_submitted' => true
            ]);

            return redirect()->route('dashboard.nominatif.index')->with('show_results', true);
        }

        // Ambil data dari session jika ada
        if (session('show_results')) {
            $pegawais = session('nominatif_data', collect());
            $displayColumns = session('nominatif_columns', $displayColumns);
            $isSubmitted = session('nominatif_submitted', false);
            
            // Buat request object dari session untuk konsistensi
            $sessionFilters = session('nominatif_filters', []);
            $request->merge($sessionFilters);
        }

        return view('dashboard.nominatif.index', [
            'pegawais' => $pegawais,
            'allPegawais' => Pegawai::all(),
            'displayColumns' => $displayColumns,
            'request' => $request,
            'isSubmitted' => $isSubmitted,
        ]);
    }

    // Tambahkan method untuk clear session
    public function clearResults()
    {
        session()->forget(['nominatif_data', 'nominatif_filters', 'nominatif_columns', 'nominatif_submitted', 'show_results']);
        return redirect()->route('dashboard.nominatif.index');
    }

    private function hasRealFilter(Request $request)
    {
        $filterFields = [
            'unit_kerja', 'nama_jabatan', 'formasi_jabatan', 'formasi_jabatan_tingkat', 'formasi_jabatan_keterangan',
            'jenis_jabatan', 'jenis_kepegawaian', 'eselon', 'status', 'jenis_kelamin', 'agama', 'tingkat',
            'golongan_dari', 'golongan_sampai', 'pegawai_id'
        ];
        foreach ($filterFields as $field) {
            $val = $request->input($field);
            if (!is_null($val) && $val !== '' && $val !== '-- Pilihan --') {
                return true;
            }
        }
        return false;
    }

    private function getDisplayColumns($request)
    {
        $defaultColumns = [
            'no' => 'No',
            'nip' => 'NIP',
            'nama' => 'Nama'
        ];

        $optionalColumns = [
            'tempat_lahir'            => 'Tempat Lahir',
            'tanggal_lahir'           => 'Tanggal Lahir',
            'jenis_kelamin'           => 'Jenis Kelamin',
            'agama'                   => 'Agama',
            'alamat'                  => 'Alamat',
            'telepon'                 => 'Nomor HP',
            'no_ktp'                  => 'Nomor KTP',
            'no_npwp'                 => 'NPWP',
            'status'                  => 'Status Pegawai',
            'tmt_golongan_ruang_cpns' => 'TMT CPNS',
            'tmt_pns'                 => 'TMT PNS',
            'pangkat'                 => 'Pangkat',
            'golongan_ruang'          => 'Gol. Ruang',
            'tmt_golongan_ruang'      => 'TMT Golongan Ruang',
            'eselon'                  => 'Eselon',
            'unit_kerja'              => 'Unit Kerja',
            'nama_jabatan'            => 'Jabatan',
            'jenis_jabatan'           => 'Jenis Jabatan',
            'tingkat'                 => 'Tingkat Pendidikan',
            'jurusan'                 => 'Jurusan',
            'nama_sekolah'            => 'Nama Sekolah',
            'tahun_lulus'             => 'Tahun Lulus',
            'no_ijazah'               => 'No. Ijazah',
            'tanggal_ijazah'          => 'Tanggal Ijazah',
        ];

        $selected = $request->display_columns ?? [];

        // Jika tidak ada kolom terpilih, tampilkan semua
        if (empty($selected)) {
            return array_merge($defaultColumns, $optionalColumns);
        }

        foreach ($optionalColumns as $key => $label) {
            if (in_array($key, $selected)) {
                $defaultColumns[$key] = $label;
            }
        }

        return $defaultColumns;
    }

    private function applyFilters(Request $request, $query)
    {
        foreach (['unit_kerja', 'nama_jabatan', 'formasi_jabatan', 'formasi_jabatan_tingkat', 'formasi_jabatan_keterangan','jenis_jabatan', 'jenis_kepegawaian', 'eselon', 'status'] as $field) {
            $val = $request->input($field);
            if (!is_null($val) && $val !== '' && $val !== '-- Pilihan --') {
                $query->whereHas('jabatan', function ($q) use ($val, $field) {
                    $q->where($field, $val);
                });
            }
        }

        // Field langsung di pegawai
        if ($request->filled('jenis_kelamin') && $request->jenis_kelamin !== '-- Pilihan --') {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('agama') && $request->agama !== '-- Pilihan --') {
            $query->where('agama', $request->agama);
        }

        if ($request->filled('tingkat') && $request->tingkat !== '-- Pilihan --') {
            $query->whereHas('pendidikans', function ($q) use ($request) {
                $q->where('tingkat', $request->tingkat);
            });
        }

        if ($request->filled('golongan_dari')) {
            $arah = $request->get('arah', 'antara');
            if ($arah === 'keatas') {
                $query->where('golongan_ruang', '>=', $request->golongan_dari);
            } elseif ($arah === 'kebawah') {
                $query->where('golongan_ruang', '<=', $request->golongan_dari);
            } elseif ($request->filled('golongan_sampai')) {
                $query->whereBetween('golongan_ruang', [$request->golongan_dari, $request->golongan_sampai]);
            }
        }

        if ($request->filled('pegawai_id')) {
            $query->where('id', $request->pegawai_id);
        }

        // Sorting
        $sortBy = $request->get('urut', 'nama');
        $sortOrder = $request->get('model', 'ascending') === 'ascending' ? 'asc' : 'desc';

        if ($sortBy === 'usia') {
            $query->orderBy('tanggal_lahir', $sortOrder === 'asc' ? 'desc' : 'asc');
        } elseif (in_array($sortBy, ['golongan_ruang', 'nip'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('nama', $sortOrder);
        }

        return $query;
    }

    public function preview(Request $request)
    {
        $query = $this->applyFilters($request, Pegawai::with(['jabatan', 'pendidikans']));
        return view('dashboard.nominatif.cetak_pdf', [
            'pegawais' => $query->get(),
            'displayColumns' => $this->getDisplayColumns($request),
            'allPegawais' => Pegawai::all(),
            'request' => $request
        ]);
    }

    public function cetak(Request $request)
    {
        $query = $this->applyFilters($request, Pegawai::with(['jabatan', 'pendidikans']));

        $pdf = PDF::loadView('dashboard.nominatif.cetak_pdf', [
            'pegawais' => $query->get(),
            'displayColumns' => $this->getDisplayColumns($request),
            'allPegawais' => Pegawai::all(),
            'request' => $request
        ])
            ->setPaper('A4', 'landscape')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'margin-bottom' => 0,
            ]);

        return $pdf->download('nominatif-pegawai.pdf');
    }
    
    public function exportExcel(Request $request)
    {
        // Ambil data sesuai filter (pakai Eloquent, relasi, dsb)
        $query = Pegawai::with(['jabatan', 'pendidikans']);
        $query = $this->applyFilters($request, $query); // Jika ada method filter
        $pegawais = $query->get();

        // Ambil displayColumns dari session/request, atau default
        $displayColumns = $this->getDisplayColumns($request);

        // Download Excel
        return Excel::download(new NominatifPegawaiExport($pegawais, $displayColumns), 'nominatif-pegawai.xlsx');
    }
}