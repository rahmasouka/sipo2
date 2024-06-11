<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\ListObatPelaku;
use App\Models\Obat;
use App\Models\Permintaan;
use App\Models\PermintaanDetail;
use App\Models\StokObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermintaanController extends Controller
{
    public function index()
    {
        $pelaku = Permintaan::join('pelaku', 'pelaku.pelaku_id', 'permintaan.pelaku_id')
            ->where(['permintaan.deleted_at' => null, 'permintaan.pelaku_id' => Auth::guard('pelaku')->user()->pelaku_id])->orderBy('permintaan.created_at', 'DESC')->get(['pelaku.nama_pelaku', 'permintaan.*']);

        $breadcrumb = [
            [
                'link' => '/',
                'nama' => 'SIPO'
            ],
            [
                'link' => '',
                'nama' => 'Permintaan Obat'
            ]
        ];

        $data = [
            'title' => 'Lakukan Permintaan Obat',
            'link' => 'lakukan-permintaan',
            'breadcrumb' => $breadcrumb,
            'result' => $pelaku,
            'batch' => Batch::join('obat', 'obat.obat_id', 'batch.obat_id')->where(['batch.deleted_at' => null])->get(),
        ];
        return view('permintaan.index', $data);
    }
    public function store(Request $request)
    {

        if ($request->file('surat_permintaan')) {
            $doc_name = 'uploads/lampiran/' . 'lampiran-' . date('Y-m-d_H-i-s') . rand(0, 100000) . '.' . $request->file('surat_permintaan')->getClientOriginalExtension();
            $data['surat_permintaan'] = $doc_name;
            $request->file('surat_permintaan')->move(public_path('uploads/lampiran'), $doc_name);
        }

        $data['pelaku_id'] = $request->pelaku_id;
        $data['detail'] = $request->detail;
        $data['status_permintaan'] = "Pending";

        //Pemindahan file

        $permintaan = Permintaan::create($data)->getAttributes();


        foreach ($request->input('jumlah_permintaan') as $i => $v) {
            PermintaanDetail::create([
                'permintaan_id' => $permintaan['permintaan_id'],
                'batch_id' => $request->input('batch_id')[$i],
                'jumlah_permintaan' => $request->input('jumlah_permintaan')[$i],
                'status' => "Pending",
                'keterangan' => $request->input('keterangan')[$i],
            ]);
        }
        return redirect('/lakukan-permintaan')->with('success', 'Berhasil melakukan permintaan');
    }

    public function detail($id)
    {
        $pelaku = PermintaanDetail::join('batch', 'batch.batch_id', 'permintaan_detail.batch_id')
            ->join('obat', 'obat.obat_id', 'batch.obat_id')
            ->join('satuan', 'obat.satuan_id', 'satuan.satuan_id')
            ->where('permintaan_detail.deleted_at', null)
            ->where('permintaan_detail.permintaan_id', $id)
            ->get(['permintaan_detail.*', 'obat.kode_obat', 'obat.nama_obat', 'batch.kode_batch', 'satuan.nama_satuan']);

        $breadcrumb = [
            [
                'link' => '/',
                'nama' => 'SIPO'
            ],
            [
                'link' => '',
                'nama' => 'Permintaan Obat'
            ]
        ];

        $data = [
            'title' => 'Detail Permintaan Obat',
            'link' => 'lakukan-permintaan',
            'breadcrumb' => $breadcrumb,
            'result' => $pelaku,
            'ditel' => Permintaan::join('pelaku', 'permintaan.pelaku_id', 'pelaku.pelaku_id')->where('permintaan_id', $id)->first(),
        ];
        return view('permintaan.detail', $data);
    }

    //Sisi admin
    public function permintaanObat()
    {
        $pelaku = Permintaan::join('pelaku', 'pelaku.pelaku_id', 'permintaan.pelaku_id')
            ->where(['permintaan.deleted_at' => null])->orderBy('permintaan.created_at', 'DESC')->get();

        $breadcrumb = [
            [
                'link' => '/',
                'nama' => 'SIPO'
            ],
            [
                'link' => '',
                'nama' => 'Permintaan Obat'
            ]
        ];

        $data = [
            'title' => 'Lakukan Permintaan Obat',
            'link' => 'lakukan-permintaan',
            'breadcrumb' => $breadcrumb,
            'result' => $pelaku,
            'batch' => Batch::join('obat', 'obat.obat_id', 'batch.obat_id')->where(['batch.deleted_at' => null])->get(),
        ];
        return view('permintaan.index', $data);
    }

    public function tindakLanjut(Request $request)
    {
        $id = $request->input('permintaan_id');
        Permintaan::find($id)->update([
            'status_permintaan' => $request->status_permintaan,
            'keterangan_admin' => $request->keterangan_admin,
        ]);

        $whotfasked = Permintaan::find($id);

        if ($request->status_permintaan == 'Diterima') {
            $d = PermintaanDetail::where('permintaan_detail.permintaan_id', $id)->get();

            foreach ($d as $q => $v) {
                $batch = Batch::where('batch_id', $v->batch_id);
                $batch->update([
                    'stok_batch' => $batch->first()->stok_batch - $v->jumlah_permintaan,
                ]);

                $obat = Obat::where('obat_id', $batch->first()->obat_id);
                $obat->update([
                    'stok_terkini' => $obat->first()->stok_terkini - $v->jumlah_permintaan,
                ]);

                ListObatPelaku::create([
                    'batch_id' => $v->batch_id,
                    'pelaku_id' => $whotfasked->pelaku_id,
                    'stok' => $v->jumlah_permintaan
                ]);
            }

            StokObat::create([
                'batch_id' => $batch->first()->batch_id,
                'obat_id' => $obat->first()->obat_id,
                'stok' => $v->jumlah_permintaan,
                'detail' => '-',
                'ket' => 'Permintaan obat sebesar ' . $v->jumlah_permintaan,
            ]);
        }
        return redirect('/permintaan-obat')->with('success', 'Berhasil menindaklanjuti permintaan obat');
    }
}
