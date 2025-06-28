<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PendapatanAsdosExport;
use App\Models\Absen;
use App\Models\Asdos;
use App\Models\Periode;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function pdfpendapatan()
    {
        $periodeAktif = Periode::where('status', 'aktif')->first();

        if (!$periodeAktif) {
            return redirect()->back()->with('error', 'Tidak ada periode aktif yang ditemukan');
        }

        $asdosList = Asdos::where('periode', $periodeAktif->id)->get();
        $absenList = Absen::where('periode', $periodeAktif->id)->get();

        $asdosWithEarnings = $asdosList->map(function ($asdos) use ($absenList) {
            $jumlahKehadiran = $absenList->where('id_asdos', $asdos->id)->count();
            $pendapatan = ($jumlahKehadiran * 15000) * 0.95;

            $asdos->kehadiran = $jumlahKehadiran;
            $asdos->pendapatan = $pendapatan;

            return $asdos;
        });

        $totalPengeluaran = $asdosWithEarnings->sum('pendapatan');
        $p= strtoupper($periodeAktif->semester) .' '. $periodeAktif->tahun;
        $safeP = str_replace(['/', '\\'], '-', $p);

        $pdf = Pdf::loadView('admin.financial.cetak', [
            'asdos' => $asdosWithEarnings,
            'pengeluaran' => $totalPengeluaran,
            'absen' => $absenList,
            'periode' => $p,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('rekap-financial-periode-' . $safeP . '.pdf');
    }

}
