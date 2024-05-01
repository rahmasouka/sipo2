<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Obat;
use App\Models\StokObat;
use App\Models\StokOpname;
use App\Models\StokOpnameDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokOpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obat = DB::select("SELECT stok_opname.*, (SELECT count(stok_opname_detail_id) FROM stok_opname_detail WHERE stok_opname.stok_opname_id = stok_opname_detail.stok_opname_id) as jumlah_selisih FROM stok_opname");
        $breadcrumb = [
            [
                'link' => '/',
                'nama' => 'SIPO'
            ],
            [
                'link' => '',
                'nama' => 'Stok Opname'
            ]
        ];

        $data = [
            'title' => 'Stok Opname',
            'link' => 'stok-opname',
            'breadcrumb' => $breadcrumb,
            'satuan' => StokOpname::where(['deleted_at' => null])->get(),
            'result' => $obat,
            'batch' => Batch::join('obat', 'obat.obat_id', 'batch.obat_id')->where(['batch.deleted_at' => null])->get(),
        ];
        return view('stok-opname.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $stokOpname = StokOpname::create([
            'tgl_stok_opname' => date('Y-m-d H:i:s')
        ])->getAttributes();
        foreach ($request->input('stok_setelah') as $i => $v) {
            StokOpnameDetail::create([
                'batch_id' => $request->input('batch_id')[$i],
                'stok_awal' => $request->input('stok_awal')[$i],
                'stok_setelah' => $request->input('stok_setelah')[$i],
                'stok_opname_id' => $stokOpname['stok_opname_id'],
                'keterangan' => "Perubahan stok opname dari " . $request->input('stok_awal')[$i] . " ke " . $request->input('stok_setelah')[$i],
            ]);

            $selisihBatch = $request->input('stok_setelah')[$i] -  $request->input('stok_awal')[$i];
            $stokBatch = $request->input('stok_awal')[$i] + $selisihBatch;

            $batch = Batch::find($request->input('batch_id'));
            $obat = Obat::find($batch->first()->obat_id);
            $selisihObat = $obat->first()->stok_terkini + $selisihBatch;

            Obat::find($batch->first()->obat_id)->update([
                'stok_terkini' => $selisihObat
            ]);

            Batch::find($request->input('batch_id')[$i])->update([
                'stok_batch' => $stokBatch
            ]);

            $detail = '';

            if ($selisihBatch > 0) {
                $detail = '+';
            } elseif ($selisihBatch  == 0) {
                $detail = '*';
            } else {
                $detail = '-';
            }

            StokObat::create([
                'batch_id' => $request->input('batch_id')[$i],
                'obat_id' => $batch->first()->obat_id,
                'stok' => $selisihBatch,
                'detail' => $detail,
                'keterangan' => "Perubahan stok dari proses stok opname pada tanggal " . date('d-m-Y H:i'),
            ]);
        }

        return redirect('/stok-opname')->with('success', 'Berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $obat = StokOpnameDetail::join('batch', 'batch.batch_id', 'stok_opname_detail.batch_id')
            ->join('obat', 'obat.obat_id', 'batch.obat_id')
            ->where(['stok_opname_id' => $id])->get();

        $stok = StokOpname::find($id)->first();
        $breadcrumb = [
            [
                'link' => '/',
                'nama' => 'SIPO'
            ],
            [
                'link' => '/stok-opname',
                'nama' => 'Stok Opname'
            ],
            [
                'link' => '',
                'nama' => 'Detail'
            ]
        ];

        $data = [
            'title' => 'Stok Opname Detail',
            'link' => 'stok-opname',
            'breadcrumb' => $breadcrumb,
            'satuan' => StokOpname::where(['deleted_at' => null])->get(),
            'result' => $obat,
            'batch' => Batch::join('obat', 'obat.obat_id', 'batch.obat_id')->where(['batch.deleted_at' => null])->get(),
            'detailOpname' => $stok,
        ];
        return view('stok-opname.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
