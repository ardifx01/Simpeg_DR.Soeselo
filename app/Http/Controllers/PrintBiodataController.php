<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Pendidikan;
use App\Models\Penghargaan;
use App\Models\Organisasi;
use App\Models\DiklatFungsional;
use App\Models\DiklatJabatan;
use App\Models\Diklatteknik;
use App\Models\Istri;
use App\Models\Anak;
use Barryvdh\DomPDF\Facade\Pdf;

class PrintBiodataController extends Controller
{
    public function index($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.print-options', compact('pegawai'));
    }

    public function generatePDF(Request $request, $id)
    {
        // Validate request
        $request->validate([
            'sections' => 'required|array',
            'sections.*' => 'in:biodata,jabatan,pendidikan,penghargaan,organisasi,diklat_fungsional,diklat_jabatan,diklat_teknis,istri,anak',
        ]);

        $pegawai = Pegawai::findOrFail($id);
        $sections = $request->sections;
        
        $data = [
            'pegawai' => $pegawai,
            'sections' => $sections,
        ];
        
        // Load related data based on selected sections
        if (in_array('jabatan', $sections)) {
            $data['jabatan'] = Jabatan::where('pegawai_id', $id)->orderBy('tmt', 'desc')->get();
        }
        
        if (in_array('pendidikan', $sections)) {
            $data['pendidikan'] = Pendidikan::where('pegawai_id', $id)->orderBy('tahun_lulus', 'desc')->get();
        }
        
        if (in_array('penghargaan', $sections)) {
            $data['penghargaan'] = Penghargaan::where('pegawai_id', $id)->orderBy('tahun', 'desc')->get();
        }
        
        if (in_array('organisasi', $sections)) {
            $data['organisasi'] = Organisasi::where('pegawai_id', $id)->orderBy('tmt', 'desc')->get();
        }
        
        if (in_array('diklat_fungsional', $sections)) {
            $data['diklat_fungsional'] = DiklatFungsional::where('pegawai_id', $id)->orderBy('tanggal_selesai', 'desc')->get();
        }
        
        if (in_array('diklat_jabatan', $sections)) {
            $data['diklat_jabatan'] = DiklatJabatan::where('pegawai_id', $id)->orderBy('tanggal_selesai', 'desc')->get();
        }
        
        if (in_array('diklat_teknis', $sections)) {
            $data['diklat_teknis'] = Diklatteknik::where('pegawai_id', $id)->orderBy('tanggal_selesai', 'desc')->get();
        }
        
        if (in_array('istri', $sections)) {
            $data['istri'] = Istri::where('pegawai_id', $id)->get();
        }
        
        if (in_array('anak', $sections)) {
            $data['anak'] = Anak::where('pegawai_id', $id)->orderBy('tanggal_lahir', 'desc')->get();
        }
        
        $pdf = PDF::loadView('dashboard.partials.print-pdf', $data);
        
        // Set paper to A4
        $pdf->setPaper('a4', 'portrait');
        
        // Generate a filename based on pegawai name
        $filename = 'biodata_' . str_replace(' ', '_', $pegawai->nama) . '_' . date('dmY') . '.pdf';
        
        return $pdf->download($filename);
    }
}