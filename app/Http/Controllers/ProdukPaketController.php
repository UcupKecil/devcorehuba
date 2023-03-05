<?php

namespace App\Http\Controllers;

use App\Kategori;
use Datatables;
use PDF;
use Carbon;
use Auth;
use App\ProdukPaket;
use App\Ambil;
use App\Tambah;
use Illuminate\Http\Request;

 
use App\Exports\ProdukPaketExport;
use Maatwebsite\Excel\Facades\Excel;

class ProdukPaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::where('id_kategori','not like','1000')->where('id_kategori','not like','1003')->get();      
        return view('produkpaket.index', compact('kategori'));
    }
    public function ambilindex(){
        $ambil = Ambil::get();
        return view('produkpaket.ambilindex',compact('ambil'));
    }
    public function stock(){
        return view('liststock.index');
    }

    public function stockdata(){
        $produkpaket = ProdukPaket::where('jenis_produk', '=','Mentah')
        ->orderBy('produk.id_produk', 'desc')
        ->get();
    // dd($produkpaket);
            $no = 0;
            $data = array();
            foreach($produkpaket as $list){
                
                    $no ++;
                    $row = array();
                    $row[] = "<input type='checkbox' name='id[]'' value='".$list->id_produk."'>";
                    $row[] = $no;
                    $row[] = $list->kode_produk;
                    $row[] = $list->nama_produkpaket;
                    // $row[] = $list->nama_kategori;
                    $row[] = $list->merk;
                    // $row[] = "Rp. ".format_uang($list->harga_beli);
                    // $row[] = "Rp. ".format_uang($list->harga_jual);
                    // $row[] = $list->diskon."%";
                    $row[] = $list->stok;
                    $row[] = "<div class='btn-group'>
                            <a onclick='editForm(".$list->id_produk.")' class='btn btn-primary btn-sm'><i class='fa fa-pencil'></i></a>
                            <a onclick='deleteData(".$list->id_produk.")' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a></div>";
                    $data[] = $row;
                
            }
            
            $output = array("data" => $data);
            return response()->json($output);
    }

    public function ambildata(){
        $ambil = Ambil::leftJoin('produk', 'produk.kode_produk', '=', 'ambils.kode_produk')
        ->leftJoin('users', 'users.id', '=', 'ambils.user')
        ->orderBy('ambils.id', 'desc')
        ->get();
            $no = 0;
            $data = array();
            foreach($ambil as $list){
                if($list->nama_kategori != 'Stock'){
                    $no ++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $list->nama_produk;
                    $row[] = $list->ambil;
                    $row[] = $list->keterangan;
                    $row[] = $list->name;
                    $data[] = $row;
                }
            }
            
            $output = array("data" => $data);
            return response()->json($output);
    }

    public function listData()
    {
        $produkpaket = ProdukPaket::leftJoin('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
        ->where('jenis_produk', '=', 'Paket')
        ->orderBy('produk.id_produk', 'desc')
        ->get();
            $no = 0;
            $data = array();
            foreach($produkpaket as $list){
                if($list->nama_kategori != 'Stock'){
                    $no ++;
                    $row = array();
                    $row[] = "<input type='checkbox' name='id[]'' value='".$list->id_produk."'>";
                    $row[] = $no;
                    $row[] = $list->kode_produk;
                    $row[] = $list->nama_produk;
                    $row[] = $list->nama_kategori;
                    // $row[] = $list->merk;
                    $row[] = "Rp. ".format_uang($list->harga_beli);
                    $row[] = "Rp. ".format_uang($list->harga_jual);
                    $row[] = $list->diskon."%";
                    $row[] = $list->stok;
                    $row[] = "<div class='btn-group'>
                            <a onclick='editForm(".$list->id_produk.")' class='btn btn-primary btn-sm'><i class='fa fa-pencil'></i></a>
                            <a onclick='deleteData(".$list->id_produk.")' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a></div>";
                    $data[] = $row;
                }
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
        $jml = ProdukPaket::where('kode_produk', '=', $request['kode'])->count();
        $table_no = ProdukPaket::max('id_produk');
        $tgl = substr(str_replace( '-', '', Carbon\carbon::now()), 0,8);
        
        $no= $tgl.$table_no;
        $auto=substr($no,8);
        $auto=intval($auto)+1;
        $auto_number=substr($no,0,8).str_repeat(0,(4-strlen($auto))).$auto;
        if($jml < 1){
            $produkpaket = new ProdukPaket;
            $produkpaket->kode_produk     = $auto_number;
            $produkpaket->nama_produk    = $request['nama'];
            $produkpaket->id_kategori    = $request['kategori'];
            $produkpaket->merk          = $request['merk'];
            $produkpaket->harga_beli      = $request['harga_beli'];
            $produkpaket->diskon       = $request['diskon'];
            $produkpaket->harga_jual    = $request['harga_jual'];
            $produkpaket->stok          = $request['stok'];
            $produkpaket->jenis_produk    = $request['jenis'];
            $produkpaket->save();
            echo json_encode(array('msg'=>'success'));
        }else{
            echo json_encode(array('msg'=>'error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProdukPaket  $produkpaket
     * @return \Illuminate\Http\Response
     */
    public function show(ProdukPaket $produkpaket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProdukPaket  $produkpaket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produkpaket = ProdukPaket::find($id);
        echo json_encode($produkpaket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProdukPaket  $produkpaket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produkpaket = ProdukPaket::find($id);
        $produkpaket->nama_produk    = $request['nama'];
       
        $produkpaket->harga_beli      = $request['harga_beli'];
        $produkpaket->diskon       = $request['diskon'];
        $produkpaket->harga_jual    = $request['harga_jual'];
        $produkpaket->stok          = $request['stok'];
        $produkpaket->jenis_produk          = $request['jenis'];
        $produkpaket->update();
        echo json_encode(array('msg'=>'success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProdukPaket  $produkpaket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produkpaket = ProdukPaket::find($id);
        $produkpaket->delete();
    }

    public function ambil(Request $request){
        $produkpaket = ProdukPaket::where('kode_produk', '=', $request['kode_produk'])->first();
        // dd($produkpaket);
        $produkpaket->stok = $produkpaket->stok - $request['ambil'];
        $produkpaket->update();

        $ambil = new Ambil;
        $ambil->tanggal = $request['tanggal'];
        $ambil->kode_produk = $request['kode_produk'];
        $ambil->ambil = $request['ambil'];
        $ambil->keterangan = $request['keterangan'];
        $ambil->user = Auth::user()->id; 
        $ambil->save();

        return redirect()->route('produkpaket.index');
    }

    public function tambah(Request $request){
        $produkpaket = ProdukPaket::where('kode_produk', '=', $request['kode_produk'])->first();
        // dd($produkpaket);
        $produkpaket->stok = $produkpaket->stok + $request['tambah'];
        $produkpaket->update();

        $tambah = new Tambah;
        $tambah->tanggal = $request['tanggal'];
        $tambah->kode_produk = $request['kode_produk'];
        $tambah->tambah = $request['tambah'];
        $tambah->keterangan = $request['keterangan'];
        $tambah->user = Auth::user()->id; 
        $tambah->save();

        return redirect()->route('produkpaket.index');
    }

    public function deleteSelected(Request $request)
    {
        foreach($request['id'] as $id){
            $produkpaket = ProdukPaket::find($id);
            $produkpaket->delete();
        }
    }

    public function printBarcode(Request $request)
    {
        $dataprodukpaket = array();
        foreach($request['id'] as $id){
            $produkpaket = ProdukPaket::find($id);
            $dataprodukpaket[] = $produkpaket;
        }
        $no = 1;
        $pdf = PDF::loadView('produkpaket.barcode', compact('dataprodukpaket', 'no'));
        $pdf->setPaper('a4', 'potrait');      
        return $pdf->stream();
    }

    public function export_excel()
	{
		return Excel::download(new ProdukPaketExport, 'siswa.xlsx');
	}
}
