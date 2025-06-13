<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {            
        $query = Pegawai::query();

        // Filter berdasarkan jenis kepegawaian
        if ($request->filled('jenis_kepegawaian')) {
            $query->where('jenis_kepegawaian', $request->jenis_kepegawaian);
        }
        
        // Filter berdasarkan jabatan fungsional
        if ($request->filled('jabatan_fungsional')) {
            $query->where('jabatan_fungsional', $request->jabatan_fungsional);
        }

        // Pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                ->orWhere('nip', 'like', "%$search%")
                ->orWhere('jenis_kelamin', 'like', "%$search%")
                ->orWhere('golongan_ruang', 'like', "%$search%")
                ->orWhere('jenis_kepegawaian', 'like', "%$search%");
            });
        }

        // pagination
        $perPage = $request->input('per_page', 10);
        $pegawais = $query->paginate($perPage)->appends($request->query());

        // Ambil daftar jabatan fungsional dari pegawai
        $jabatanFungsionalList = Pegawai::select('jabatan_fungsional')
            ->distinct() // Menghapus duplikat, sehingga hanya nilai-nilai unik dari jabatan fungsional yang diambil
            ->orderBy('jabatan_fungsional')
            ->pluck('jabatan_fungsional') // Mengambil kolom jabatan fungsional sebagai Collection 1 dimensi
            ->filter()
            ->values();

        // jika request berupa ajax 
        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard.pegawai.index', compact('pegawais'))->render()
            ]);
        }

        return view('dashboard.pegawai.index', compact('pegawais', 'jabatanFungsionalList'));
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
            'alamat' => 'required',
            'telepon' => 'required',
            'tingkat_pendidikan' => 'nullable',
            'nama_pendidikan' => 'nullable',
            'nama_sekolah' => 'nullable',
            'tahun_lulus' => 'nullable',
            'pangkat' => 'nullable',
            'golongan_ruang' => 'nullable',
            'tmt_golongan_ruang' => 'nullable',
            'golongan_ruang_cpns' => 'nullable',
            'tmt_golongan_ruang_cpns' => 'nullable',
            'tmt_pns' => 'nullable',     
            'jenis_kepegawaian' => 'required',
            'status_hukum' => 'nullable',
            'skpd' => 'nullable',
            'jenis_jabatan' => 'nullable',
            'jabatan_fungsional' => 'nullable',
            'tmt_jabatan' => 'nullable',
            'diklat_pimpinan' => 'nullable',
            'tahun_diklat_pimpinan' => 'nullable'
        ]);

        //upload image
        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('foto-profile');
        };

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
            'alamat' => '',
            'telepon' => 'required',
            'tingkat_pendidikan' => 'nullable',
            'nama_pendidikan' => 'nullable',
            'nama_sekolah' => 'nullable',
            'tahun_lulus' => 'nullable',
            'pangkat' => 'nullable',
            'golongan_ruang' => 'nullable',
            'tmt_golongan_ruang' => 'nullable',
            'golongan_ruang_cpns' => 'nullable',
            'tmt_golongan_ruang_cpns' => 'nullable',
            'tmt_pns' => 'nullable',     
            'jenis_kepegawaian' => 'required',
            'status_hukum' => 'nullable',
            'skpd' => 'nullable',
            'jenis_jabatan' => 'nullable',
            'jabatan_fungsional' => 'nullable',
            'tmt_jabatan' => 'nullable',
            'diklat_pimpinan' => 'nullable',
            'tahun_diklat_pimpinan' => 'nullable'
        ]);
        
        $pegawai = Pegawai::findOrFail($id);
        if($request->file('image')) {
            if ( $pegawai->image ) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('foto-profile');
        };
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
    
    public function rekapkepegawaian()
    {
        // Ambil jumlah pegawai berdasarkan kepegawaian
        $rekap = Pegawai::select('jenis_kepegawaian', DB::raw('count(*) as jumlah'))
                        ->whereNotNull('jenis_kepegawaian')
                        ->groupBy('jenis_kepegawaian')
                        ->orderBy('jenis_kepegawaian', 'desc')
                        ->get();

        // Hitung jumlah pegawai tanpa kepegawaian
        $pegawaiTanpaKepegawaian = Pegawai::whereNull('jenis_kepegawaian')->count();

        // Ambil detail pegawai tanpa kepegawaian
        $dataPegawaiTanpaKepegawaian = Pegawai::whereNull('jenis_kepegawaian')->get();

        return view('dashboard.rekapitulasi.kepegawaian', compact('rekap', 'pegawaiTanpaKepegawaian', 'dataPegawaiTanpaKepegawaian'));
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
}
