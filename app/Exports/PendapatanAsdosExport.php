<?php

namespace App\Exports;

use App\Models\{Asdos, Absen, Periode, Setting};
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithEvents,
    WithDrawings,
    WithCustomStartCell
};
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\{Alignment, Border, Fill, NumberFormat};

class PendapatanAsdosExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithCustomStartCell,
    WithStyles,
    WithEvents,
    WithDrawings
{
    private int   $totalKehadiran = 0;
    private float $totalPendapatan = 0;

    public function __construct(private int $periodeId) {}

    /* ------------------- data ------------------- */
    public function collection(): Collection
    {
        $asdos = Asdos::where('periode', $this->periodeId)->get();
        $absen = Absen::where('periode', $this->periodeId)->get();
        $datapajak = Setting::first();
        $pajak = $datapajak->pajak / 100;

        return $asdos->map(function ($a) use ($absen, $pajak) {
            $hadir      = $absen->where('id_asdos', $a->id)->count();
            $pendapatan = ($hadir * 15_000) * (1 - $pajak);

            $this->totalKehadiran  += $hadir;
            $this->totalPendapatan += $pendapatan;

            return [
                'nama'       => $a->nama . ' (' . $a->stb . ')',
                'pendapatan' => $pendapatan,
            ];
        });
    }

    /* tabel mulai di baris 5  */
    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        return [
            ['NO.', 'NAMA ASISTEN PRAKTIKUM', 'Rp', 'Jumlah', 'Tanda Tangan'],
        ];
    }

    public function map($row): array
    {
        static $no = 1;
        $duit = (string) ($row['pendapatan'] ?? 0);
        return [
            $no++,
            $row['nama'],
            'Rp',
            $duit,
            '',
        ];
    }

    /* ------------------- logo ------------------- */
    public function drawings()
    {
        $img          = new Drawing();
        $img->setName('Logo UNDIPA')
            ->setPath(public_path('home/assets/img/undipaa.png'))
            ->setHeight(70)
            ->setCoordinates('A1');

        return [$img];
    }

    /* ------------------- basic styles ------------------- */
    public function styles(Worksheet $sheet)
    {
        // font default
        $sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

        // header sub-table (row 5 = A5:E5)
        $sheet->getStyle('A5:E5')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);

        // kolom width
        $widths = ['A' => 5, 'B' => 46, 'C' => 5, 'D' => 18, 'E' => 26];
        foreach ($widths as $col => $w) {
            $sheet->getColumnDimension($col)->setWidth($w);
        }

        return [];
    }

    /* ------------------- after sheet ------------------- */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $e) {

                $s       = $e->sheet;
                $rowData = 6;                                 // data mulai baris-6
                $last    = $s->getHighestRow();
                $periode = Periode::where('status', 'aktif')->first();            // setelah mapping

                // judul 3 baris
                $titles = [
                    1 => ['txt' => 'UNIVERSITAS DIPA (UNDIPA) MAKASSAR', 'size' => 14],
                    2 => ['txt' => 'DAFTAR PENGAMBILAN HONOR ASISTEN DOSEN LABORATORIUM', 'size' => 12],
                    3 => ['txt' => 'SEMESTER ' . strtoupper($periode->semester) . ' T.A. ' . $periode->tahun, 'size' => 12],
                ];
                foreach ($titles as $r => $v) {
                    $s->mergeCells("B{$r}:E{$r}")
                        ->setCellValue("B{$r}", $v['txt']);
                    $s->getStyle("B{$r}")->applyFromArray([
                        'font' => ['bold' => true, 'size' => $v['size']],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                }
                // row-height judul
                $s->getRowDimension(1)->setRowHeight(22);
                $s->getRowDimension(2)->setRowHeight(22);
                $s->getRowDimension(3)->setRowHeight(22);

                // format angka rupiah di kolom D (Jumlah)
                $s->getStyle("D{$rowData}:D{$last}")
                    ->getNumberFormat()
                    ->setFormatCode('#,##0');

                // border + row height data
                for ($r = $rowData; $r <= $last; $r++) {
                    $s->getStyle("A{$r}:E{$r}")
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN);
                    $s->getStyle("A{$r}:E{$r}")
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                        ->setVertical(Alignment::VERTICAL_CENTER);
                    $s->getRowDimension($r)->setRowHeight(30);
                }

                /* -------- total -------- */
                $totalRow = $last + 1;

                $s->mergeCells("A{$totalRow}:B{$totalRow}");
                $s->setCellValue("A{$totalRow}", 'TOTAL');
                $s->setCellValue("C{$totalRow}", 'Rp');
                $s->setCellValue("D{$totalRow}", $this->totalPendapatan);

                $s->getStyle("A{$totalRow}:E{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E1F2']],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);
                $s->getRowDimension($totalRow)->setRowHeight(18);
            },
        ];
    }
}
