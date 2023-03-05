<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Auth;
use App\Produk;
use App\Setting;
use App\PaketDetail;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::where('jenis_produk','NOT LIKE','1002')->get();
        $setting = Setting::first();
        // dd($idpaket);
        if(!empty(session('idpaket'))){
            $idpaket = session('idpaket');

            return view('paket.index', compact('produk', 'setting', 'idpaket'));
        }else{            
            return view('home');  
        }
    }

    public function newSession()
    {
        $produk = new Produk; 
        $produk->kode_produk = 0;      
        $produk->id_kategori = '1';  
        $produk->nama_produk = '';
        $produk->merk = 'paket';
        $produk->harga_beli = 0;
        $produk->diskon = 0;
        $produk->harga_jual = 0;
        $produk->stok = 0;
        $produk->jenis_produk = 'Paket';
        $produk->save();
        // dd($produk);
        
        session(['idpaket' => $produk->id_produk]);

        return Redirect::route('paket.index');    
    }

    public function listData($id)
    {
        $detail = PaketDetail::leftJoin('produk', 'produk.kode_produk', '=', 'paket_details.kode_produk')
            ->where('id_paket', '=', $id)
            ->get();
        $no = 0;
        $data = array();
        $total = 0;
        $total_item = 0;
        $beli = 0;
        $harga = 0;
        foreach($detail as $list){
            $no ++;
            $harga = $list->harga_beli * $list->jumlah;
            $beli = $beli + $harga;
            $row = array();
            // $row[] = $list->id;
            $row[] = $no;
            $row[] = $list->kode_produk;
            $row[] = $list->nama_produk;
            // $row[] = "Rp. ".format_uang($list->harga_jual);
            $row[] = "<input type='number' class='form-control' name='jumlah_$list->id' value='$list->jumlah' onChange='changeCount($list->id)'>";
            // $row[] = $list->diskon."%";
            // $row[] = $list->sub_total);
            $row[] = '<div class="btn-group">
                    <a onclick="deleteItem('.$list->id.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            // $row[] = $beli;
            $data[] = $row;

            $total += $list->harga_jual * $list->jumlah;
            $total_item += $list->jumlah;
        }

        $data[] = array("", "","", "<b>Total harga beli</b>", "<b>".format_uang($beli)."</b>" );
        
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
        $produk = Produk::where('kode_produk', '=', $request['kode'])->first();

        $detail = new PaketDetail;
        $detail->id_paket = $request['idpaket'];
        $detail->kode_produk = $request['kode'];
        $detail->jumlah = '1';
        $detail->nama_produk = $produk->nama_produk;
        $detail->harga_beli = $produk->harga_beli;
        $detail->diskon = $produk->diskon;
        $detail->harga_jual = $produk->harga_jual;
        $detail->save();
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
        $nama_input = "jumlah_".$id;
        $detail = PaketDetail::find($id);

        $detail->jumlah = $request[$nama_input];
        $detail->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = PaketDetail::find($id);
        $detail->delete();
    }

    public function saveData(Request $request)
    {
        // dd($request['hargabeli']);
        $paket = PaketDetail::where('id_paket', '=' ,$request['idpaket'])->get() ;
        $beli = 0;
        $harga = 0;
        foreach($paket as $list){
            $harga = $list->harga_beli * $list->jumlah;
            $beli = $beli + $harga;
        }
        // dd($beli);
        $produk = Produk::find($request['idpaket']);
        $produk->nama_produk = $request['nama'];
        $produk->kode_produk = $request['idpaket'];
        $produk->harga_beli = $beli;
        $produk->diskon = $request['diskon'];
        $produk->harga_jual = $request['hargajual'];
        $produk->stok = $request['stock'];
        $produk->update();
        return Redirect::route('home');
    }
}
