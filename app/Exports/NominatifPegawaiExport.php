<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NominatifPegawaiExport implements FromView
{
    protected $pegawais;
    protected $displayColumns;

    public function __construct($pegawais, $displayColumns)
    {
        $this->pegawais = $pegawais;
        $this->displayColumns = $displayColumns;
    }

    public function view(): View
    {
        return view('dashboard.nominatif.cetak_excel', [
            'pegawais' => $this->pegawais,
            'displayColumns' => $this->displayColumns
        ]);
    }
}
