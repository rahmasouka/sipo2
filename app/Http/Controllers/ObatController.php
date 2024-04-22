<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Satuan;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obat = Obat::join("satuan", "satuan.satuan_id", "obat.satuan_id")
            ->where(['obat.deleted_at' => null])->get();

        $breadcrumb = [
            [
                'link' => '/',
                'nama' => 'SIPO'
            ],
            [
                'link' => '',
                'nama' => 'Data Obat'
            ]
        ];

        $data = [
            'title' => 'Obat',
            'link' => 'obat',
            'breadcrumb' => $breadcrumb,
            'satuan' => Satuan::where(['deleted_at' => null])->get(),
            'result' => $obat,
        ];
        return view('obat.index', $data);
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
        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kode_obat' => $request->kode_obat,
            'jenis_obat' => $request->jenis_obat ?? '',
            'kategori_obat' => $request->kategori_obat,
            'satuan_id' => $request->satuan_obat,
            'merk' => $request->merk,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $request->harga_beli,
        ]);

        return redirect('/obat')->with('success', 'Berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $obat = Obat::where(['deleted_at' => null, 'obat_id' => $id])->first();
        return json_encode($obat);
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
        Obat::where(['obat_id' => $id])->update([
            'nama_obat' => $request->nama_obat,
            'kode_obat' => $request->kode_obat,
            'jenis_obat' => $request->jenis_obat ?? '',
            'kategori_obat' => $request->kategori_obat,
            'satuan_id' => $request->satuan_obat,
            'merk' => $request->merk,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $request->harga_beli,
        ]);

        return redirect('/obat')->with('success', 'Berhasil diedit');
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
        Obat::destroy($id);
        return true;
    }
}
