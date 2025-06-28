<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PendapatanAsdosExport;
use App\Models\Periode;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    // Export Excel Pendapatan
    public function excelpendapatan()
    {
        $periodeAktif = Periode::where('status', 'aktif')->firstOrFail();
        $fileName = 'laporan_asdos_' . $periodeAktif->kode . '.xlsx';

        return Excel::download(
            new PendapatanAsdosExport($periodeAktif->id),
            $fileName
        );
    }
}
