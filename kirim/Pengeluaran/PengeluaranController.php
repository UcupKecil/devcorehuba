<?php

namespace App\Http\Controllers;

use Datatables;
use App\Supplier;
use App\Pengeluaran;
use App\KategoriPengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = KategoriPengeluaran::where('id','not like','1')->get();      
        return view('pengeluaran.index', compact('kategori'));
    }
    public function pembelian(){
        $supplier = Supplier::all();
        return view('pembelian.pembelian', compact('supplier'));
    }

    public function Data(){
        $pengeluaran = Pengeluaran::where('id_kategori','like','1')->orderBy('id_pengeluaran', 'desc')->get();
        $no = 0;
        $data = array();
        foreach($pengeluaran as $list){
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = tanggal_indonesia(substr($list->tanggal, 0, 10), false);
            $row[] = $list->jenis_pengeluaran;
            $row[] = $list->nokuitansi;
            $row[] = "Rp. ".format_uang($list->nominal);
            $row[] = '<div class="btn-group">
                        <a onclick="editForm('.$list->id_pengeluaran.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                        <a onclick="deleteData('.$list->id_pengeluaran.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';
            $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    public function listData()
    {
        $pengeluaran = Pengeluaran::where('id_kategori','not like','1')->orderBy('id_pengeluaran', 'desc')->get();
        $kategori = KategoriPengeluaran::get();
        $no = 0;
        $data = array();
        foreach($pengeluaran as $list){
            foreach($kategori as $kat){
                if ($list->id_kategori == $kat->id){
                    $nama = $kat->nama;
                }
            }
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = tanggal_indonesia(substr($list->tanggal, 0, 10), false);
            $row[] = $nama;
            $row[] = $list->jenis_pengeluaran;
            $row[] = $list->nokuitansi;
            $row[] = "Rp. ".format_uang($list->nominal);
            $row[] = '<div class="btn-group">
                        <a onclick="editForm('.$list->id_pengeluaran.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                        <a onclick="deleteData('.$list->id_pengeluaran.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';
            $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);  
        // return Datatables::of($data)->escapeColumns([])->make(true);
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
        $pengeluaran = new Pengeluaran;
        $pengeluaran->jenis_pengeluaran   = $request['jenis'];
        $pengeluaran->id_kategori = $request['kategori'];
        $pengeluaran->suplier = $request['suplier'];
        $pengeluaran->nokuitansi = $request['kuitansi'];
        $pengeluaran->nominal = $request['nominal'];
        $pengeluaran->tanggal = $request['awal'];
        $pengeluaran->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        echo json_encode($pengeluaran);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->jenis_pengeluaran   = $request['jenis'];
        $pengeluaran->nominal = $request['nominal'];
        $pengeluaran->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->delete();
    }
}
