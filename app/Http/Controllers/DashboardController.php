<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Obat;
use App\Models\Permintaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcrumb = [
            [
                'link' => '',
                'nama' => 'Dashboard'
            ]
        ];
        $sixMonthsFromNow = Carbon::now()->addMonths(6);
        $batch = Batch::whereDate('expired', '<=', $sixMonthsFromNow->toDateString());
        $dataObat = Obat::where('obat.stok_terkini', '<', '20');
        // dd($dataObat->get());
        $data = [
            'title' => 'Dashboard',
            'link' => 'dashboard',
            'breadcrumb' => $breadcrumb,
            'totalObat' => Obat::count(),
            'totalRequest' => Auth::guard('admin')->check() ? Permintaan::count() : Permintaan::where('pelaku_id', Auth::guard('pelaku')->user()->pelaku_id)->count(),
            'totalExpired' => $batch->count(),
            'expired' => $batch->join('obat', 'obat.obat_id', 'batch.obat_id')->get(),
            'totalStokKurang' => $dataObat->count(),
            'stokKurang' => $dataObat->join('satuan', 'satuan.satuan_id', 'obat.satuan_id')->get(),
        ];
        return view('dashboard.index', $data);
    }
}
