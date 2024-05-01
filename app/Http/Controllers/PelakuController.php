<?php

namespace App\Http\Controllers;

use App\Models\Pelaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelakuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pelaku = Pelaku::where(['deleted_at' => null])->get();

        $breadcrumb = [
            [
                'link' => '/',
                'nama' => 'SIPO'
            ],
            [
                'link' => '',
                'nama' => 'Data Pelaku'
            ]
        ];

        $data = [
            'title' => 'Pelaku',
            'link' => 'pelaku',
            'breadcrumb' => $breadcrumb,
            'pelaku' => Pelaku::where(['deleted_at' => null])->get(),
            'result' => $pelaku,
        ];
        return view('pelaku.index', $data);
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
        Pelaku::create([
            'nama_pelaku' => $request->nama_pelaku,
            'kode_pelaku' => $request->kode_pelaku,
            'password' => Hash::make($request->password),
            'hak_akses' => $request->hak_akses ?? '',
            'email' => $request->email,
        ]);

        return redirect('/pelaku')->with('success', 'Berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pelaku = Pelaku::where(['deleted_at' => null, 'pelaku_id' => $id])->first();
        return json_encode($pelaku);
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
        Pelaku::where(['pelaku_id' => $id])->update([
            'nama_pelaku' => $request->nama_pelaku,
            'kode_pelaku' => $request->kode_pelaku,
            'hak_akses' => $request->hak_akses,
            'email' => $request->email,
        ]);

        if ($request->input('password')) {
            Pelaku::where(['pelaku_id' => $id])->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect('/pelaku')->with('success', 'Berhasil diedit');
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
        Pelaku::destroy($id);
        return true;
    }
}
