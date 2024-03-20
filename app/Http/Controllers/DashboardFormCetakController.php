<?php

namespace App\Http\Controllers;

use App\Models\Kebun;
use App\Models\Produksi;
use App\Models\Rekap;
use Illuminate\Http\Request;

class DashboardFormCetakController extends Controller
{
    public function formCetakRekap()
    {
        $a = Rekap::all();
        return view('backend.cetak-data.rekap.form-cetak', [
            'items' => $a,
        ]);
    }
}
