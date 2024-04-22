<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function websiteSetting()
    {

        $breadcrumb = [
            [
                'link' => '/',
                'nama' => 'SIPO'
            ],
            [
                'link' => '',
                'nama' => 'Website Setting'
            ]
        ];

        $data = [
            'title' => 'Website Setting',
            'link' => 'website-setting',
            'breadcrumb' => $breadcrumb,
            'result' => Setting::first(),
        ];
        return view('master.setting', $data);
    }

    public function simpansetting(Request $request)
    {
        Setting::where('setting_id', $request->input('setting_id'))
            ->update([
                'cs_nama' => $request->input('cs_nama'),
                'cs_wa' => $request->input('cs_wa'),
                'app_ver' => $request->input('app_ver'),
                'notif_toggle' => $request->input('notif_toggle'),
            ]);

        return redirect()->back()->with('success', 'Setting website berasil disimpan');
    }
}
