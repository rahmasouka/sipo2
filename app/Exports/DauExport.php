<?php

namespace App\Exports;

use App\Models\Obat;
use App\Models\StokOpname;
use Illuminate\Support\Collection;
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

class DauExport implements FromCollection, WithHeadings, WithStyles, WithEvents
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
            'STOK OPNAME',
            'INSTALASI FARMASI DINAS KESEHATAN KOTA KUPANG',
            'PER ' . date('d F Y'),
        ];

        // Data query
        $query = StokOpname::join('stok_opname_detail', 'stok_opname_detail.stok_opname_id', 'stok_opname.stok_opname_id')
            ->join('batch', 'batch.batch_id', 'stok_opname_detail.batch_id')
            ->join('obat', 'obat.obat_id', 'batch.obat_id');

        // $query = Obat::join('satuan', 'satuan.satuan_id', 'obat.satuan_id')
        //     ->select(['obat.*', 'satuan.nama_satuan']);
        if ($this->param != null && $this->param != '') {
            $query->where('batch.jenis', $this->param);
        }

        $data = $query->get();

        $data->transform(function ($item, $key) {
            $item->No = $key + 1;
            return $item;
        });

        // Map data to Excel columns
        $data = $data->map(function ($item) {
            return [
                'No' => $item->No,
                'Nama Obat' => $item->nama_obat,
                'SAT' => $item->nama_satuan,
                'Jumlah' => $item->stok_terkini,
                'Batch' => $item->kode_batch,
                'ED' => "",
                'Harga Satuan' => $item->harga_jual,
                'Total Harga' => "-",
                'Ket.' => '',
            ];
        });

        // Add title row at the beginning of the data
        $data->prepend($titleRow);

        return $data;
    }

    public function headings(): array
    {
        return ['No', 'Nama Obat', 'SAT', 'Jumlah', 'Batch', 'ED', 'Harga Satuan', 'Total Harga', 'KET.'];
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

                // Shift existing rows down
                $event->sheet->getDelegate()->insertNewRowBefore(1, 3);

                // Add title row
                $event->sheet->setCellValue('A1', 'LAPORAN PENERIMAAN OBAT SUMBER ' . $this->param);
                $event->sheet->setCellValue('A2', 'INSTALASI FARMASI DINAS KESEHATAN KOTA KUPANG');
                $event->sheet->setCellValue('A3', 'PER ' . date('d F Y'));

                // Merge cells for the title row
                $event->sheet->mergeCells('A1:I1');
                $event->sheet->mergeCells('A2:I2');
                $event->sheet->mergeCells('A3:I3');

                // Apply styles to title row
                $event->sheet->getStyle('A1:I3')->applyFromArray([
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

                // Set headings manually
                $headings = $this->headings();
                foreach ($headings as $index => $heading) {
                    $event->sheet->setCellValueByColumnAndRow($index + 1, 5, $heading);
                }

                // Clear row 4
                $event->sheet->setCellValue('A4', '');
                $event->sheet->setCellValue('B4', '');
                $event->sheet->setCellValue('C4', '');
                $event->sheet->setCellValue('D4', '');
                $event->sheet->setCellValue('E4', '');
                $event->sheet->setCellValue('F4', '');
                $event->sheet->setCellValue('G4', '');
                $event->sheet->setCellValue('H4', '');
                $event->sheet->setCellValue('I4', '');
                $event->sheet->setCellValue('J4', '');
                $event->sheet->setCellValue('K4', '');
                $event->sheet->setCellValue('L4', '');
                // Apply styles to headings
                $event->sheet->getStyle('A5:I5')->applyFromArray([
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

                $highestRow = $event->sheet->getDelegate()->getHighestRow();

                // Add "Kupang, 31 Desember 2022" after every record
                $event->sheet->setCellValue('A' . ($highestRow + 3), 'Kupang, ' . date('d M Y'));
                $event->sheet->mergeCells('A' . ($highestRow + 3) . ':I' . ($highestRow + 3));
                $event->sheet->setCellValue('A' . ($highestRow + 4), 'Petugas Pengelola Obat dan Perbekkes Instalasi Farmasi Dinkes Kota Kupang');
                $event->sheet->mergeCells('A' . ($highestRow + 4) . ':I' . ($highestRow + 4));

                for ($row = 6; $row <= $highestRow; $row++) {
                    $event->sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0.00;-#,##0.00');
                }
            },
        ];
    }
}
