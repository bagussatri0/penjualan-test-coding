<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\JenisBarang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('main.barang', [
            "title" => "Data Barang",
            "barangs" => Barang::join('jenis_barangs', 'barangs.idJenis', '=', 'jenis_barangs.id')->get(['barangs.*', 'jenis_barangs.jenisBarang']),
            "dataJenis" => JenisBarang::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'stok' => 'required',
            'idJenis' => 'required',
            ]
        );
        Barang::create($validateData);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'stok' => 'required',
            'idJenis' => 'required',
            ]
        );
        $idFile = $request['idBarang'];
        Barang::where('id',$idFile)->update($validateData);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        Barang::destroy($barang->id);
        return back()->with('pesan', 'Data berhasil dihapus');
    }
}
