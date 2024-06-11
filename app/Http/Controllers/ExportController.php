<?php

namespace App\Http\Controllers;

use App\Exports\DauExport;
use App\Exports\LPLPOExport;
use App\Exports\StokOpnameExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class ExportController extends Controller
{
    public function exportStokOpname()
    {
        return Excel::download(new StokOpnameExport, 'Stok Opname ' . date('d M Y') . '.xlsx');
    }
    public function exportDau()
    {
        return Excel::download(new DauExport('DAU'), 'PERBEKALAN OBAT DAU ' . date('d M Y') . '.xlsx');
    }
    public function exportDak()
    {
        return Excel::download(new DauExport('DAK'), 'PERBEKALAN OBAT DAK ' . date('d M Y') . '.xlsx');
    }
    public function exportProgram()
    {
        return Excel::download(new DauExport('PROGRAM'), 'PERBEKALAN OBAT PROGRAM ' . date('d M Y') . '.xlsx');
    }
    public function exportLPLPO()
    {
        return Excel::download(new LPLPOExport, 'LPLPO EXPORT ' . date('d M Y') . '.xlsx');
    }
}
