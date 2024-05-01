<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $batch = Admin::where(['deleted_at' => null])->get();

        $breadcrumb = [
            [
                'link' => '/',
                'nama' => 'SIPO'
            ],
            [
                'link' => '',
                'nama' => 'Data User Admin'
            ]
        ];

        $data = [
            'title' => 'User Admin',
            'link' => 'user-admin',
            'breadcrumb' => $breadcrumb,
            'result' => $batch,
        ];
        return view('admin.index', $data);
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
        Admin::create([
            'nama_admin' => $request->input('nama_admin'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'telp' => $request->input('telp'),
            'role' => $request->input('role'),
        ]);
        return redirect('/user-admin')->with('success', 'Berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $batch = Admin::where(['admin_id' => $id])->first();
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
        Admin::where(['admin_id' => $id])->update([
            'nama_admin' => $request->input('nama_admin'),
            'email' => $request->input('email'),
            'telp' => $request->input('telp'),
            'role' => $request->input('role'),
        ]);

        if ($request->input('password')) {
            Admin::where(['admin_id' => $id])->update([
                'password' => Hash::make($request->input('password')),
            ]);
        }
        return redirect('/user-admin')->with('success', 'Berhasil diedit');
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
        Admin::destroy($id);
        return true;
    }
}
