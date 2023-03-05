<?php

namespace App\Http\Controllers;

use App\Kategori;
use Datatables;
use PDF;
use Carbon;
use Auth;
use App\Produk;
use App\Ambil;
use App\Tambah;
use Illuminate\Http\Request;

 
use App\Exports\ProdukExport;
use Maatwebsite\Excel\Facades\Excel;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::where('id_kategori','not like','1000')->where('id_kategori','not like','1003')->get();      
        return view('produk.index', compact('kategori'));
    }
    public function ambilindex(){
        $ambil = Ambil::get();
        return view('produk.ambilindex',compact('ambil'));
    }
    public function stock(){
        return view('liststock.index');
    }

    public function stockdata(){
        $produk = Produk::where('jenis_produk', '=','Mentah')
        ->orderBy('produk.id_produk', 'desc')
        ->get();
    // dd($produk);
            $no = 0;
            $data = array();
            foreach($produk as $list){
                
                    $no ++;
                    $row = array();
                    $row[] = "<input type='checkbox' name='id[]'' value='".$list->id_produk."'>";
                    $row[] = $no;
                    $row[] = $list->kode_produk;
                    $row[] = $list->nama_produk;
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
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
        ->where('jenis_produk', '=', 'Produksi')
        ->orderBy('produk.id_produk', 'desc')
        ->get();
            $no = 0;
            $data = array();
            foreach($produk as $list){
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
        $jml = Produk::where('kode_produk', '=', $request['kode'])->count();
        $table_no = Produk::max('id_produk');
        $tgl = substr(str_replace( '-', '', Carbon\carbon::now()), 0,8);
        
        $no= $tgl.$table_no;
        $auto=substr($no,8);
        $auto=intval($auto)+1;
        $auto_number=substr($no,0,8).str_repeat(0,(4-strlen($auto))).$auto;
        if($jml < 1){
            $produk = new Produk;
            $produk->kode_produk     = $auto_number;
            $produk->nama_produk    = $request['nama'];
            $produk->id_kategori    = $request['kategori'];
            $produk->merk          = $request['merk'];
            $produk->harga_beli      = $request['harga_beli'];
            $produk->diskon       = $request['diskon'];
            $produk->harga_jual    = $request['harga_jual'];
            $produk->stok          = $request['stok'];
            $produk->jenis_produk    = $request['jenis'];
            $produk->save();
            echo json_encode(array('msg'=>'success'));
        }else{
            echo json_encode(array('msg'=>'error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produk = Produk::find($id);
        echo json_encode($produk);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        $produk->nama_produk    = $request['nama'];
        $produk->id_kategori    = $request['kategori'];
        $produk->merk          = $request['merk'];
        $produk->harga_beli      = $request['harga_beli'];
        $produk->diskon       = $request['diskon'];
        $produk->harga_jual    = $request['harga_jual'];
        $produk->stok          = $request['stok'];
        $produk->jenis_produk          = $request['jenis'];
        $produk->update();
        echo json_encode(array('msg'=>'success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();
    }

    public function ambil(Request $request){
        $produk = Produk::where('kode_produk', '=', $request['kode_produk'])->first();
        // dd($produk);
        $produk->stok = $produk->stok - $request['ambil'];
        $produk->update();

        $ambil = new Ambil;
        $ambil->tanggal = $request['tanggal'];
        $ambil->kode_produk = $request['kode_produk'];
        $ambil->ambil = $request['ambil'];
        $ambil->keterangan = $request['keterangan'];
        $ambil->user = Auth::user()->id; 
        $ambil->save();

        return redirect()->route('produk.index');
    }

    public function tambah(Request $request){
        $produk = Produk::where('kode_produk', '=', $request['kode_produk'])->first();
        // dd($produk);
        $produk->stok = $produk->stok + $request['tambah'];
        $produk->update();

        $tambah = new Tambah;
        $tambah->tanggal = $request['tanggal_tambah'];
        $tambah->kode_produk = $request['kode_produk'];
        $tambah->tambah = $request['tambah'];
        $tambah->keterangan = $request['keterangan'];
        $tambah->user = Auth::user()->id; 
        $tambah->save();

        return redirect()->route('produk.index');
    }

    public function deleteSelected(Request $request)
    {
        foreach($request['id'] as $id){
            $produk = Produk::find($id);
            $produk->delete();
        }
    }

    public function printBarcode(Request $request)
    {
        $dataproduk = array();
        foreach($request['id'] as $id){
            $produk = Produk::find($id);
            $dataproduk[] = $produk;
        }
        $no = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4', 'potrait');      
        return $pdf->stream();
    }

    public function export_excel()
	{
		return Excel::download(new ProdukExport, 'siswa.xlsx');
	}
}
