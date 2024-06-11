<?php

namespace App\Http\Controllers;

use App\Models\ListObatPelaku;
use App\Models\PemakaianObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obat = ListObatPelaku::join("batch", "batch.batch_id", "list_obat_pelaku.batch_id")
            ->join("obat", "obat.obat_id", "batch.obat_id")
            ->join("satuan", "satuan.satuan_id", "obat.satuan_id")
            ->where(['obat.deleted_at' => null, 'list_obat_pelaku.pelaku_id' => Auth::guard('pelaku')->user()->pelaku_id])->get(['obat.nama_obat', 'obat.kode_obat', 'obat.kategori_obat', 'satuan.nama_satuan', 'list_obat_pelaku.*', 'obat.jenis_obat', 'satuan.nama_satuan', 'batch.kode_batch', 'obat.harga_jual', 'obat.harga_beli']);

        $breadcrumb = [
            [
                'link' => '/',
                'nama' => 'SIPO'
            ],
            [
                'link' => '',
                'nama' => 'List Obat'
            ]
        ];

        $data = [
            'title' => 'List Obat',
            'link' => 'list-obat',
            'breadcrumb' => $breadcrumb,
            'result' => $obat,
        ];
        // dd($data);
        return view('list-pemakaian-obat.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambah()
    {

        $obat = ListObatPelaku::join("batch", "batch.batch_id", "list_obat_pelaku.batch_id")
            ->join("obat", "obat.obat_id", "batch.obat_id")
            ->join("satuan", "satuan.satuan_id", "obat.satuan_id")
            ->where(['obat.deleted_at' => null])->get(['obat.nama_obat', 'obat.kode_obat', 'obat.kategori_obat', 'satuan.nama_satuan', 'list_obat_pelaku.*', 'obat.jenis_obat', 'satuan.nama_satuan', 'batch.kode_batch', 'obat.harga_jual', 'obat.harga_beli']);

        $breadcrumb = [
            [
                'link' => '/',
                'nama' => 'SIPO'
            ],
            [
                'link' => '',
                'nama' => 'List Obat'
            ]
        ];

        $data = [
            'title' => 'List Obat',
            'link' => 'list-obat',
            'breadcrumb' => $breadcrumb,
            'result' => $obat,
        ];
        // dd($data);
        return view('list-pemakaian-obat.tambah', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input());
        $pelaku = $request->pelaku_id;

        foreach ($request->input('jumlah_penggunaan') as $i => $v) {
            PemakaianObat::create([
                'pelaku_id' => $pelaku,
                'batch_id' => $request->input('batch_id')[$i],
                'terpakai' => $v,
                'catatan' => $request->input('catatan')[$i],
            ]);

            $listObat = ListObatPelaku::where('list_obat_pelaku.batch_id', $request->input('batch_id'))->orderBy('list_obat_pelaku.list_obat_pelaku_id', 'DESC');

            $stokTerakhir = $listObat->first()->stok;

            $listObat->update(['stok' => (int) $stokTerakhir - $v]);
        }
        return redirect('/list-obat')->with('success', 'Berhasil menambahkan penggunaan harian');
    }

    public function terpakai()
    {
        $obat = PemakaianObat::join("batch", "batch.batch_id", "pemakaian_obat.batch_id")
            ->join("obat", "obat.obat_id", "batch.obat_id")
            ->join("satuan", "satuan.satuan_id", "obat.satuan_id")
            ->where(['obat.deleted_at' => null, 'pemakaian_obat.pelaku_id' => Auth::guard('pelaku')->user()->pelaku_id])->get(['obat.nama_obat', 'obat.kode_obat', 'obat.kategori_obat', 'satuan.nama_satuan', 'pemakaian_obat.*', 'obat.jenis_obat', 'satuan.nama_satuan', 'batch.kode_batch', 'obat.harga_jual', 'obat.harga_beli']);

        $breadcrumb = [
            [
                'link' => '/',
                'nama' => 'SIPO'
            ],
            [
                'link' => '',
                'nama' => 'List Obat'
            ]
        ];

        $data = [
            'title' => 'List Obat',
            'link' => 'list-obat',
            'breadcrumb' => $breadcrumb,
            'result' => $obat,
        ];
        // dd($data);
        return view('list-pemakaian-obat.list-terpakai', $data);
    }
}
