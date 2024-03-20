<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Rekap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kebun;

class RekapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Rekap::with('kebun');

        if ($request->has('start_date') && $request->has('end_date') && $request->has('kebun')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $kebunId = $request->input('kebun');

            $query->whereBetween('tanggal', [$startDate, $endDate])->where('kebun_id', $kebunId);
        }

        $rekaps = $query->get()->groupBy('kebun.nama_kebun');
        $kebuns = Kebun::all();
        return view('backend.rekap.index', compact(['rekaps', 'kebuns']));
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
        $request->validate([
            'tanggal' => 'required',
            'afdeling' => 'required',
            'jumlah_hilang' => 'required|integer',
            'jumlah_selamat' => 'required|integer',
            'ket' => 'required',
            'kebun_id' => 'required',
        ]);

        Rekap::create([
            'tanggal' => $request->tanggal,
            'afdeling' => $request->afdeling,
            'jumlah_hilang' => $request->jumlah_hilang,
            'jumlah_selamat' => $request->jumlah_selamat,
            'ket' => $request->ket,
            'kebun_id' => $request->kebun_id,
        ]);

        return redirect()->route('rekap.index')->with('success', 'Sukses, 1 Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $request->validate([
            'tanggal' => 'required',
            'afdeling' => 'required',
            'jumlah_hilang' => 'required|integer',
            'jumlah_selamat' => 'required|integer',
            'ket' => 'required',
            'kebun_id' => 'required',
        ]);

        $item = Rekap::findOrFail($id);

        $item->update([
            'tanggal' => $request->tanggal,
            'afdeling' => $request->afdeling,
            'jumlah_hilang' => $request->jumlah_hilang,
            'jumlah_selamat' => $request->jumlah_selamat,
            'ket' => $request->ket,
            'kebun_id' => $request->kebun_id,
        ]);

        return redirect()->route('rekap.index')->with('success', 'Sukses, 1 Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Rekap::findorFail($id);
        $item->delete();
        return redirect()->route('rekap.index')->with('success', 'Sukses, 1 Data berhasil dihapus!');
    }
}
