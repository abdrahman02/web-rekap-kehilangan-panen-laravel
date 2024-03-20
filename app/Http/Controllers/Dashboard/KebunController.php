<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Kebun;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class KebunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kebuns = Kebun::latest()->paginate(15);
        return view('backend.kebun.index', compact('kebuns'));
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
            'nama_rayon' => 'required',
            'nama_kebun' => 'required|unique:kebuns,nama_kebun'
        ]);

        Kebun::create([
            'nama_rayon' => $request->nama_rayon,
            'nama_kebun' => $request->nama_kebun,
        ]);

        return redirect()->route('kebun.index')->with('success', 'Sukses, 1 Data berhasil ditambahkan!');
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
            'nama_rayon' => 'required',
            'nama_kebun' => 'required|unique:kebuns,nama_kebun,' . $id
        ]);

        $item = Kebun::findOrFail($id);

        $item->update([
            'nama_rayon' => $request->nama_rayon,
            'nama_kebun' => $request->nama_kebun
        ]);

        return redirect()->route('kebun.index')->with('success', 'Sukses, 1 Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $item = Kebun::findorFail($id);
            $item->delete();
            return redirect()->route('kebun.index')->with('success', 'Sukses, 1 Data berhasil dihapus!');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus data karena terdapat keterkaitan dengan data lain.');
            } else {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
            }
        }
    }
}
