<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $satuan = Satuan::where(['deleted_at' => null])->get();

        $breadcrumb = [
            [
                'link' => '/',
                'nama' => 'SIPO'
            ],
            [
                'link' => '',
                'nama' => 'Data Satuan'
            ]
        ];

        $data = [
            'title' => 'Satuan',
            'link' => 'satuan',
            'breadcrumb' => $breadcrumb,
            'satuan' => Satuan::where(['deleted_at' => null])->get(),
            'result' => $satuan,
        ];
        return view('satuan.index', $data);
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
        Satuan::create([
            'nama_satuan' => $request->nama_satuan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect('/satuan')->with('success', 'Berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $satuan = Satuan::where(['deleted_at' => null, 'satuan_id' => $id])->first();
        return json_encode($satuan);
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
        Satuan::where(['satuan_id' => $id])->update([
            'nama_satuan' => $request->nama_satuan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect('/satuan')->with('success', 'Berhasil diedit');
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
        Satuan::destroy($id);
        return true;
    }
}
