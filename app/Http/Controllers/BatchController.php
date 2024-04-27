<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Obat;
use App\Models\StokObat;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $batch = Batch::join('obat', 'obat.obat_id', 'batch.obat_id')->where(['batch.deleted_at' => null])->get();

        $breadcrumb = [
            [
                'link' => '/',
                'nama' => 'SIPO'
            ],
            [
                'link' => '',
                'nama' => 'Data Batch Obat'
            ]
        ];

        $data = [
            'title' => 'Batch',
            'link' => 'batch',
            'breadcrumb' => $breadcrumb,
            'obat' => Obat::where(['deleted_at' => null])->get(),
            'result' => $batch,
        ];
        return view('batch.index', $data);
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
        $batch = Batch::create([
            'obat_id' => $request->nama_obat,
            'kode_batch' => $request->kode_batch,
            'expired' => $request->expired,
            'jenis' => $request->jenis,
            'stok_batch' => $request->stok,
            'keterangan' => $request->keterangan,
            'tanggal_pengadaan' => $request->tanggal_pengadaan,
            'tahun_pengadaan' => $request->tahun_pengadaan,
        ])->getAttributes();

        StokObat::create([
            'obat_id' => $request->nama_obat,
            'batch_id' => $batch['batch_id'],
            'stok' => $request->stok,
            'detail' => "+",
            'ket' => "Penambahan batch obat",
        ]);

        $obat = Obat::find($request->input('nama_obat'));
        $stok_terkini = $obat->stok_terkini ?? 0;

        Obat::find($request->input('nama_obat'))->update([
            'stok_terkini' => $stok_terkini + $request->stok
        ]);

        return redirect('/batch')->with('success', 'Berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $batch = Batch::where(['deleted_at' => null, 'batch_id' => $id])->first();
        return json_encode($batch);
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
        Batch::where(['batch_id' => $id])->update([
            'obat_id' => $request->nama_obat,
            'kode_batch' => $request->kode_batch,
            'expired' => $request->expired,
            'jenis' => $request->jenis,
            'keterangan' => $request->keterangan,
            'tanggal_pengadaan' => $request->tanggal_pengadaan,
            'tahun_pengadaan' => $request->tahun_pengadaan,
        ]);

        return redirect('/batch')->with('success', 'Berhasil diedit');
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

    public function delete($id)
    {
        Batch::destroy($id);
        return true;
    }
}
