<?php

namespace App\Exports;

use App\Models\ListObatPelaku;
use App\Models\Obat;
use App\Models\PemakaianObat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class LPLPOExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    use Exportable;

    protected $param;

    public function __construct($param = null)
    {
        $this->param = $param;
    }

    public function collection()
    {
        // Title row
        $titleRow = [
            'LAPORAN PEMAKAIAN DAN LEMBARAN PERMINTAAN OBAT',
            'PER ' . date('d F Y'),
        ];

        // Data query
        $query = PemakaianObat::join("batch", "batch.batch_id", "pemakaian_obat.batch_id")
            ->join("obat", "obat.obat_id", "batch.obat_id")
            ->join("satuan", "satuan.satuan_id", "obat.satuan_id")
            ->where(['obat.deleted_at' => null, 'pemakaian_obat.pelaku_id' => Auth::guard('pelaku')->user()->pelaku_id]);


        if ($this->param != null && $this->param != '') {
            $query->where('stok_opname.stok_opname_id', $this->param);
        }

        // Retrieve data
        $data = $query->get();

        // Add row numbers
        $data->transform(function ($item, $key) {
            $item->No = $key + 1;
            return $item;
        });

        // Map data to Excel columns
        $data = $data->map(function ($item) {
            return [
                'No' => $item->No ?? '-',
                'Nama Obat' => $item->nama_obat ?? '-',
                'SAT' => $item->nama_satuan ?? '-',
                'HARGA SATUAN' => $item->harga_jual,
                'STOK AWAL' => $item->stok_terkini ?? '-',
                'PENERIMAAN' => $item->stok ?? '-',
                'PERSEDIAAN' => $item->stok_terkini ?? '-',
                'PEMAKAIAN BULAN INI' => $item->terpakai ?? '-',
                'OBAT RUSAK / KADALUARSA' => "",
                'SISA STOK' => $item->stok_terkini,
                'TOTAL HARGA' => (int) $item->stok_terkini * (int) $item->harga_jual,
                'STOK OPTIMUM' => '-',
                'DAU' => '-',
                'PROG' => '-',
                'BUFFER' => '-',
                'LAIN' => '-',
                'JUMLAH' => '-',
                'TANGGAL ED' => '-',
                'NO BATCH' => '-',
                'KET' => $item->catatan,
            ];
        });

        // Add title row at the beginning of the data

        return $data;
    }

    public function headings(): array
    {
        return ['No', 'Nama Obat', 'SAT', 'HARGA SATUAN', 'STOK AWAL', 'PENERIMAAN', 'PERSEDIAAN', 'PEMAKAIAN BULAN INI', 'OBAT RUSAK/KADALUARSA', 'SISA STOK', 'TOTAL HARGA SISA STOK', 'STOK OPTIMUM', 'DAU', 'PROG', 'BUFFER', 'LAIN', 'JUMLAH', 'TANGGAL ED', 'NO BATCH', 'KET'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0070C0']],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
        ];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('F')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('G')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('H')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('I')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('J')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('K')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('L')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('M')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('N')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('O')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('P')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('Q')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('R')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('S')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('T')->setAutoSize(true);

                // Shift existing rows down
                $event->sheet->getDelegate()->insertNewRowBefore(1, 8);

                // Add title row
                $event->sheet->setCellValue('A1', 'LAPORAN PEMAKAIAN DAN LEMBARAN PERMINTAAN OBAT');
                $event->sheet->setCellValue('A2', 'PER ' . date('d F Y'));
                $event->sheet->setCellValue('A3', 'KODE PUSKESMAS');
                $event->sheet->setCellValue('B3', '-');
                $event->sheet->setCellValue('A4', 'PUSKESMAS:');
                $event->sheet->setCellValue('B4', '-');
                $event->sheet->setCellValue('A5', 'KECAMATAN:');
                $event->sheet->setCellValue('B5', '-');
                $event->sheet->setCellValue('A6', 'KABPATEN/KOTA:');
                $event->sheet->setCellValue('B6', 'KOTA KUPANG');
                $event->sheet->setCellValue('A7', 'PROVINSI:');
                $event->sheet->setCellValue('B7', 'NUSA TENGGARA TIMUR');

                // Merge cells for the title row
                $event->sheet->mergeCells('A1:T1');
                $event->sheet->mergeCells('A2:T2');

                // Apply styles to title row
                $event->sheet->getStyle('A1:T2')->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'BFBFBF']],
                    'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Clear row 4
                $event->sheet->setCellValue('A8', '');
                $event->sheet->setCellValue('B8', '');
                $event->sheet->setCellValue('C8', '');
                $event->sheet->setCellValue('D8', '');
                $event->sheet->setCellValue('E8', '');
                $event->sheet->setCellValue('F8', '');
                $event->sheet->setCellValue('G8', '');
                $event->sheet->setCellValue('H8', '');
                $event->sheet->setCellValue('I8', '');
                $event->sheet->setCellValue('J8', '');
                $event->sheet->setCellValue('K8', '');
                $event->sheet->setCellValue('L8', '');
                // // Apply styles to headings
                // $event->sheet->getStyle('A9 :L9')->applyFromArray([
                //     'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'BFBFBF']],
                //     'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
                //     'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                //     'borders' => [
                //         'allBorders' => [
                //             'borderStyle' => Border::BORDER_THIN,
                //             'color' => ['rgb' => '000000'],
                //         ],
                //     ],
                // ]);

                $highestRow = $event->sheet->getDelegate()->getHighestRow();

                // Add "Kupang, 31 Desember 2022" after every record
                $event->sheet->setCellValue('A' . ($highestRow + 3), 'Kupang, ' . date('d M Y'));
                $event->sheet->mergeCells('A' . ($highestRow + 3) . ':I' . ($highestRow + 3));
                $event->sheet->setCellValue('A' . ($highestRow + 4), 'Petugas Pengelola Obat dan Perbekkes Instalasi Farmasi Dinkes Kota Kupang');
                $event->sheet->mergeCells('A' . ($highestRow + 4) . ':I' . ($highestRow + 4));

                for ($row = 6; $row <= $highestRow; $row++) {
                    $event->sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0.00;-#,##0.00');
                }

                for ($row = 6; $row <= $highestRow; $row++) {
                    $event->sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0.00;-#,##0.00');
                }
            },
        ];
    }
}
