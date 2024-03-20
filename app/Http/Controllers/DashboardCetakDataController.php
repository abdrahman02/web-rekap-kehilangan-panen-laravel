<?php

namespace App\Http\Controllers;

use App\Models\Kebun;
use App\Models\Rekap;
use App\Models\Produksi;
use Illuminate\Http\Request;

class DashboardCetakDataController extends Controller
{

    public function cetakKebun()
    {
        $a = Kebun::all();
        return view('backend.cetak-data.kebun.cetak-seluruh', [
            'items' => $a,
        ]);
    }

    public function cetakRekap($start_date, $end_date)
    {
        $query = Rekap::with('kebun')->whereBetween('tanggal', [$start_date, $end_date]);
        $rekaps = $query->get()->groupBy('kebun.nama_kebun');
        $a = $rekaps;
        $kebuns = Kebun::all();
        return view('backend.cetak-data.rekap.cetak-seluruh', [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'items' => $a,
            'kebuns' => $kebuns,
        ]);
    }
}
