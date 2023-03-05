<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KategoriPengeluaran;

class KategoriPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kategori_pengeluaran.index');
    }
    public function listData()
    {
    
        $kategori = KategoriPengeluaran::where('id','not like','1')->orderBy('id', 'desc')->get();
        $no = 0;
        $data = array();
        foreach($kategori as $list){
        $no ++;
        $row = array();
        $row[] = $no;
        $row[] = $list->nama;
        $row[] = '<div class="btn-group">
                <a onclick="editForm('.$list->id.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                <a onclick="deleteData('.$list->id.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';
        $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
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
        $kategori = new KategoriPengeluaran;
        $kategori->nama = $request['nama'];
        $kategori->save();
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
        $kategori = KategoriPengeluaran::find($id);
        echo json_encode($kategori);
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
        $kategori = KategoriPengeluaran::find($id);
        $kategori->nama = $request['nama'];
        $kategori->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
