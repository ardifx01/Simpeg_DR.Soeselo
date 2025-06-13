<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class PegawaiPrintController extends Controller
{
    /**
     * Print the biodata of a pegawai.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function cetak(Request $request, $id)
    {
        $sectionRelations = [
            'biodata' => [],
            'jabatan' => ['jabatan'],
            'pendidikan' => ['pendidikans'],
            'penghargaan' => ['penghargaans'],
            'organisasi' => ['organisasis'],
            'diklat_fungsional' => ['diklat_fungsionals'],
            'diklat_jabatan' => ['diklat_jabatans'],
            'diklat_teknik' => ['diklat_tekniks'],
            'istri' => ['istris'],
            'anak' => ['anaks']
        ];

        $sections = $request->input('sections', []);
        if (!in_array('biodata', $sections)) {
            $sections[] = 'biodata';
        }

        $relations = [];
        foreach ($sections as $section) {
            if (isset($sectionRelations[$section])) {
                $relations = array_merge($relations, $sectionRelations[$section]);
            }
        }
        $relations = array_unique($relations);

        $pegawaiQuery = Pegawai::query();
        if (!empty($relations)) {
            $pegawaiQuery->with($relations);
        }
        $pegawai = $pegawaiQuery->findOrFail($id);

        $data = [
            'pegawai' => $pegawai,
            'sections' => $sections
        ];

        $pdf = Pdf::loadView('dashboard.partials.print_pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

        $filename = 'biodata_' . str_replace(' ', '_', strtolower($pegawai->nama)) . '_' . now()->format('dmY_His') . '.pdf';

        return $pdf->download($filename);
    }
    /**
     * Preview the biodata of a pegawai.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function preview(Request $request, $id)
    {
        // Mapping antara section dan relasi
        $sectionRelations = [
            'biodata' => [],
            'jabatan' => ['jabatan'],
            'pendidikan' => ['pendidikans'],
            'penghargaan' => ['penghargaans'],
            'organisasi' => ['organisasis'],
            'diklat_fungsional' => ['diklat_fungsionals'],
            'diklat_jabatan' => ['diklat_jabatans'],
            'diklat_teknik' => ['diklat_tekniks'],
            'istri' => ['istris'],
            'anak' => ['anaks']
        ];

        $sections = $request->input('sections', []);
        if (!in_array('biodata', $sections)) {
            $sections[] = 'biodata';
        }
        
        // Kumpulkan relasi yang diperlukan saja
        $relations = [];
        foreach ($sections as $section) {
            if (isset($sectionRelations[$section])) {
                $relations = array_merge($relations, $sectionRelations[$section]);
            }
        }
        $relations = array_unique($relations);

        // Load hanya relasi yang diperlukan
        $pegawaiQuery = Pegawai::query();
        if (!empty($relations)) {
            $pegawaiQuery->with($relations);
        }
        $pegawai = $pegawaiQuery->findOrFail($id);

        $data = [
            'pegawai' => $pegawai,
            'sections' => $sections
        ];

        $pdf = Pdf::loadView('dashboard.partials.print_pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

        return $pdf->stream('preview_biodata_' . $pegawai->nama . '.pdf');
    }
}
