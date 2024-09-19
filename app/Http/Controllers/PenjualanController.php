<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Barang;
use App\Models\JenisBarang;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('main.penjualan', [
            "title" => "Data Penjualan",
            "penjualans" =>  Penjualan::join('barangs', 'penjualans.idBarang', '=', 'barangs.id')
            ->join('jenis_barangs', 'barangs.idJenis', '=', 'jenis_barangs.id')
            ->get(['penjualans.*', 'barangs.*', 'jenis_barangs.jenisBarang']),
            "dataBarangs" => Barang::join('jenis_barangs', 'barangs.idJenis', '=', 'jenis_barangs.id')->get(['barangs.*', 'jenis_barangs.jenisBarang']),
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
            'idBarang' => 'required',
            'jumlahTerjual' => 'required',
            'tanggal' => 'required',
            ]
        );
        Penjualan::create($validateData);

        
        $idBarang = $request['idBarang'];
        $barang = Barang::where('id', $idBarang)->first();

        $jumlahTerjual = $request->input('jumlahTerjual');
        $stokTerbaru = $barang->stok - $jumlahTerjual;
        Barang::where('id', $idBarang)->update(['stok' => $stokTerbaru]);
        

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        $validateData = $request->validate([
            'idBarang' => 'required',
            'jumlahTerjual' => 'required',
            'tanggal' => 'required',
            ]
        );
        $idPenjualan = $request['idPenjualan'];
        Penjualan::where('id',$idPenjualan)->update($validateData);

        
        $idBarang = $request['idBarang'];
        $barang = Barang::where('id', $idBarang)->first();

        $jumlahTerjual = $request->input('jumlahTerjual');
        $stokTerbaru = $barang->stok - $jumlahTerjual;
        Barang::where('id', $idBarang)->update(['stok' => $stokTerbaru]);
        

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        Penjualan::destroy($penjualan->id);
        return back()->with('pesan', 'Data berhasil dihapus');
    }
}
