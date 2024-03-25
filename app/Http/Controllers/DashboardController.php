<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
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
            'title' => 'Dashboard',
            'link' => 'dashboard',
            'breadcrumb' => $breadcrumb
        ];
        return view('dashboard.index', $data);
    }
}
