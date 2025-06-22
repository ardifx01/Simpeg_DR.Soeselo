<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {            
        $query = Pegawai::with('jabatan'); // eager load relasi jabatans

        // Filter berdasarkan jenis kepegawaian
        if ($request->filled('jenis_kepegawaian')) {
            $query->whereHas('jabatan', function ($q) use ($request) {
                $q->where('jenis_kepegawaian', $request->jenis_kepegawaian);
            });
        }

        // Filter berdasarkan unit kerja dari relasi jabatan
        if ($request->filled('unit_kerja')) {
            $query->whereHas('jabatan', function ($q) use ($request) {
                $q->where('unit_kerja', $request->unit_kerja);
            });
        }

        // Pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                ->orWhere('nip', 'like', "%$search%")
                ->orWhere('jenis_kelamin', 'like', "%$search%");
            });
        }

        // pagination
        $perPage = $request->input('per_page', 10);
        $pegawais = $query->paginate($perPage)->appends($request->query());

        // Data untuk filter
        $jeniskepegawaianList = \App\Models\Jabatan::distinct()->pluck('jenis_kepegawaian');
        $unitkerjaList = \App\Models\Jabatan::distinct()->pluck('unit_kerja');

        // Jika request berupa AJAX
        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard.pegawai.index', compact('pegawais'))->render()
            ]);
        }

        // Return view dengan semua data
        return view('dashboard.pegawai.index', compact(
            'pegawais',
            'unitkerjaList',
            'jeniskepegawaianList'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('dashboard.pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // melakukan validasi data
        $validatedData = $request->validate([
            'image' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,gif,bmp',
            'nip' => 'required',
            'nip_lama' => 'nullable',
            'no_karpeg' => 'nullable',
            'no_kpe' => 'nullable',
            'no_ktp' => 'required',
            'no_npwp' => 'nullable',
            'nama' => 'required',
            'gelar_depan' => 'nullable|max:5',
            'gelar_belakang' => 'nullable|max:5',
            'tempat_lahir' => 'required|max:45',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'status_nikah' => 'required',
            'alamat' => 'nullable',
            'rt' => 'nullable',
            'rw' => 'nullable',
            'desa' => 'nullable',
            'kecamatan' => 'nullable',
            'kabupaten' => 'nullable',
            'provinsi' => 'nullable',
            'pos' => 'nullable',
            'telepon' => 'required',
            'golongan_ruang' => 'nullable',
            'tmt_golongan_ruang' => 'nullable',
            'golongan_ruang_cpns' => 'nullable',
            'tmt_golongan_ruang_cpns' => 'nullable',
            'tmt_pns' => 'nullable'
        ]);

        //upload image
        if ($request->file('image')) {
            // Simpan gambar baru di direktori 'foto-profile' pada disk 'public'
            $validatedData['image'] = $request->file('image')->store('foto-profile', 'public');
        }


        Pegawai::create($validatedData);
                
        return redirect('/dashboard/pegawai')->with('success', 'Berhasil Menambahkan Pegawai');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        return view('dashboard.partials.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        return view('dashboard.pegawai.edit', compact('pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // melakukan validasi data
        $validatedData = $request->validate([
            'image' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,gif,bmp',
            'nip' => 'required',
            'nip_lama' => 'required',
            'no_karpeg' => 'nullable',
            'no_kpe' => 'nullable',
            'no_ktp' => 'required',
            'no_npwp' => 'nullable',
            'nama' => 'required',
            'gelar_depan' => 'nullable|max:5',
            'gelar_belakang' => 'nullable|max:5',
            'tempat_lahir' => 'required|max:45',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'status_nikah' => 'required',
            'alamat' => 'nullable',
            'rt' => 'nullable',
            'rw' => 'nullable',
            'desa' => 'nullable',
            'kecamatan' => 'nullable',
            'kabupaten' => 'nullable',
            'provinsi' => 'nullable',
            'pos' => 'nullable',
            'telepon' => 'required',
            'golongan_ruang' => 'nullable',
            'tmt_golongan_ruang' => 'nullable',
            'golongan_ruang_cpns' => 'nullable',
            'tmt_golongan_ruang_cpns' => 'nullable',
            'tmt_pns' => 'nullable'   
            ]);
        
        $pegawai = Pegawai::findOrFail($id);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada dan file-nya benar-benar ada di storage
            if ($pegawai->image && Storage::disk('public')->exists($pegawai->image)) {
                Storage::disk('public')->delete($pegawai->image);
            }

            // Simpan gambar baru di direktori 'foto-profile' pada disk 'public'
            $pegawai->image = $request->file('image')->store('foto-profile', 'public');
        }

        
        $pegawai->update($validatedData);

        return redirect('/dashboard/pegawai')->with('success', 'Berhasil Mengubah Data Pegawai');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        if ( $pegawai->image ) {
            Storage::delete($pegawai->image);
        }
        $pegawai->delete();

        return redirect('/dashboard/pegawai')->with('success','Data Pegawai Berhasil Dihapus' );
    }

    public function updateImage(Request $request, $id)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,bmp|max:2048',
        ]);

        $pegawai = Pegawai::findOrFail($id);

        // Hapus gambar lama jika ada
        if ($pegawai->image && Storage::disk('public')->exists($pegawai->image)) {
            Storage::disk('public')->delete($pegawai->image);
        }

        // Simpan gambar baru
        $path = $request->file('image')->store('foto-profile', 'public');
        $pegawai->image = $path;
        $pegawai->save();

        return redirect()->back()->with('success', 'Foto pegawai berhasil diperbarui.');
    }

    public function rekapGolongan()
    {
        // Ambil jumlah pegawai berdasarkan golongan
        $rekap = Pegawai::select('golongan_ruang', DB::raw('count(*) as jumlah'))
        ->whereNotNull('golongan_ruang')
        ->groupBy('golongan_ruang')
        ->orderBy('golongan_ruang', 'desc')
        ->get();

    // Hitung jumlah pegawai tanpa golongan
    $pegawaiTanpaGolongan = Pegawai::whereNull('golongan_ruang')->count();

    // Ambil detail pegawai tanpa golongan
    $dataPegawaiTanpaGolongan = Pegawai::whereNull('golongan_ruang')->get();

    return view('dashboard.rekapitulasi.golongan', compact('rekap', 'pegawaiTanpaGolongan', 'dataPegawaiTanpaGolongan'));
    }
    
    public function rekapAgama()
    {
        // Ambil jumlah pegawai berdasarkan agama
        $rekap = Pegawai::select('agama', DB::raw('count(*) as jumlah'))
                        ->whereNotNull('agama')
                        ->groupBy('agama')
                        ->orderBy('agama', 'desc')
                        ->get();

        // Hitung jumlah pegawai tanpa Agama
        $pegawaiTanpaAgama = Pegawai::whereNull('agama')->count();

        // Ambil detail pegawai tanpa agama
        $dataPegawaiTanpaAgama = Pegawai::whereNull('agama')->get();

        return view('dashboard.rekapitulasi.agama', compact('rekap', 'pegawaiTanpaAgama' ,'dataPegawaiTanpaAgama'));
    }
    
    public function rekapJenisKelamin()
    {
        // Ambil jumlah pegawai berdasarkan jenis kelamin
        $rekap = Pegawai::select('jenis_kelamin', DB::raw('count(*) as jumlah'))
                        ->whereNotNull('jenis_kelamin')
                        ->groupBy('jenis_kelamin')
                        ->orderBy('jenis_kelamin', 'desc')
                        ->get();

        // Hitung jumlah pegawai tanpa jenis kelamin
        $pegawaiTanpaJenisKelamin = Pegawai::whereNull('jenis_kelamin')->count();

        // Ambil detail pegawai tanpa kelamin
        $dataPegawaiTanpaKelamin = Pegawai::whereNull('jenis_kelamin')->get();
        
        return view('dashboard.rekapitulasi.jenis-kelamin', compact('rekap', 'pegawaiTanpaJenisKelamin' ,'dataPegawaiTanpaKelamin'));
    }
    
    public function rekapStatusNikah()
    {
        // Ambil jumlah pegawai berdasarkan jenis kelamin
        $rekap = Pegawai::select('status_nikah', DB::raw('count(*) as jumlah'))
                        ->whereNotNull('status_nikah')
                        ->groupBy('status_nikah')
                        ->orderBy('status_nikah', 'desc')
                        ->get();

        // Hitung jumlah pegawai tanpa status nikah
        $pegawaiTanpaStatusNikah = Pegawai::whereNull('status_nikah')->count();
        
        // Ambil detail pegawai tanpa status nikah
        $dataPegawaiTanpaStatusNikah = Pegawai::whereNull('status_nikah')->get();

        return view('dashboard.rekapitulasi.status-nikah', compact('rekap', 'pegawaiTanpaStatusNikah' ,'dataPegawaiTanpaStatusNikah'));
    }
    
    public function getData($id)
    {
        $pegawai = Pegawai::with('jabatan', 'pendidikans')->findOrFail($id);

        return response()->json([
            'nip' => $pegawai->nip ?? '-',
            'tempat_lahir' =>$pegawai->tempat_lahir ?? '-',
            'tanggal_lahir' =>$pegawai->tanggal_lahir ?? '-',
            'telepon' =>$pegawai->telepon ?? '-',
            'agama' =>$pegawai->agama ?? '-',
            'alamat' =>$pegawai->alamat ?? '-',
            'golongan_ruang' =>$pegawai->golongan_ruang?? '-',
            'tingkat' =>optional($pegawai->pendidikans)->tingkat ?? '-',
            'jabatan' => optional($pegawai->jabatan)->unit_kerja ?? '-',
            'pangkat' => optional($pegawai->jabatan)->nama ?? '-',
            'unit_kerja' => optional($pegawai->jabatan)->skpd ?? '-',
        ]);
    }

    public function rekapKGBPangkat(Request $request)
    {
        $now = Carbon::now();
        $pegawais = Pegawai::all();

        $dataKGB = collect();
        $dataPangkat = collect();

        foreach ($pegawais as $pegawai) {
            $tmt = $pegawai->tmt_golongan_ruang ?? $pegawai->tmt_golongan_ruang_cpns;
            if (!$tmt) continue;

            $mk = Carbon::parse($tmt)->diffInYears($now);
            $kgbKe = floor($mk / 2);
            $tmtKgbTerakhir = Carbon::parse($tmt)->addYears($kgbKe * 2);

            if ($tmtKgbTerakhir->lte($now)) {
                $dataKGB->push($pegawai);
            }

            if ($mk >= 4) {
                $dataPangkat->push($pegawai);
            }
        }

        $perPage = 10;
        $currentPageKgb = LengthAwarePaginator::resolveCurrentPage('kgb_page');
        $currentPagePangkat = LengthAwarePaginator::resolveCurrentPage('pangkat_page');

        $kgbPaginated = new LengthAwarePaginator(
            $dataKGB->forPage($currentPageKgb, $perPage),
            $dataKGB->count(),
            $perPage,
            $currentPageKgb,
            ['path' => url()->current(), 'pageName' => 'kgb_page']
        );

        $pangkatPaginated = new LengthAwarePaginator(
            $dataPangkat->forPage($currentPagePangkat, $perPage),
            $dataPangkat->count(),
            $perPage,
            $currentPagePangkat,
            ['path' => url()->current(), 'pageName' => 'pangkat_page']
        );

        return view('dashboard.pegawai.rekap-kgb-pangkat', [
            'dataKGB' => $kgbPaginated,
            'dataPangkat' => $pangkatPaginated,
        ]);
    }
}
