<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getBatchByID($id)
    {
        // $id = $request->get('id');

        $batch = Batch::join('obat', 'obat.obat_id', 'batch.obat_id')->where(['batch.deleted_at' => null, 'batch.batch_id' => $id])->first();

        return json_encode($batch);
    }
}
