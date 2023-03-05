<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Auth;
use PDF;
use App\Penjualan;
use App\Produk;
use App\Member;
use App\Setting;
use App\PenjualanDetail;
use App\StockDetail;
use App\Stock;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::where('id_kategori','102')->get();
        $member = Member::all();
        $setting = Setting::first();
        if(!empty(session('idstock'))){
            $idstock = session('idstock');
            return view('stock.index', compact('produk', 'member', 'setting', 'idstock'));
        }else{            
            return Redirect::route('home');  
        }
        
    }

    public function newSession()
    {
        $stock = new Stock; 
        $stock->jumlah = 0;      
        $stock->id_user = Auth::user()->id;    
        $stock->save();
        
        session(['idstock' => $stock->id]);
        // $idstock = session('idstock');
        // dd($idstock);
        return Redirect::route('stock.index');    
    }

    public function listData($id)
    {
        $detail = StockDetail::leftJoin('produk', 'produk.kode_produk', '=', 'stock_details.kode_produk')
            ->where('id_stock', '=', $id)
            ->get();
        $no = 0;
        $data = array();
        $total = 0;
        $total_item = 0;
        foreach($detail as $list){
            $no ++;
            $row = array();
            $row[] = $list->id;
            $row[] = $no;
            $row[] = $list->kode_produk;
            $row[] = $list->nama_produk;
            // $row[] = "Rp. ".format_uang($list->harga_jual);
            $row[] = "<input type='number' class='form-control' name='jumlah_$list->id' value='$list->jumlah' onChange='changeCount($list->id)'>";
            // $row[] = $list->diskon."%";
            // $row[] = "Rp. ".format_uang($list->sub_total);
            $row[] = '<div class="btn-group">
                    <a onclick="deleteItem('.$list->id.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            $data[] = $row;

            $total += $list->harga_jual * $list->jumlah;
            $total_item += $list->jumlah;
        }

        $data[] = array("<span class='hide total'>$total</span><span class='hide totalitem'>$total_item</span>", "", "", "", "", "", "", "");
        
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

        $detail = new StockDetail;
        $detail->id_stock = $request['idstock'];
        $detail->kode_produk = $request['kode'];
        $detail->jumlah = 1;
        $detail->id_user = Auth::user()->id;  
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
        // $nama_input = "jumlah_".$id;
        // $detail = StockDetail::find($id);

        // $detail->jumlah = $request[$nama_input];
        // $detail->update();
        // dd($nama_input);
        return Redirect::route('home'); 
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
        $detail = StockDetail::find($id);
        
        $detail->jumlah = $request[$nama_input];
        $detail->update();
        // return Redirect::route('home'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = StockDetail::find($id);
        $detail->delete();
    }

    public function saveData(Request $request)
    {
        $total = 0;
        $stock = Stock::find($request['idstock']);
        $status = "Lebih";

        $detail = StockDetail::where('id_stock', '=', $request['idstock'])->get();
        foreach($detail as $list){
            $produk = Produk::where('kode_produk', '=', $list->kode_produk)->first();
            if ($produk->stok <= $list->jumlah){
                $status = "Kurang";
            }
        }
        if($status == "Lebih"){
            foreach($detail as $data){
                $produk = Produk::where('kode_produk', '=', $data->kode_produk)->first();
                $produk->stok -= $data->jumlah;
                $total = $total + $data->jumlah;
                $produk->update();
            }
            $stock->jumlah = $total;
            $stock->update();
            return Redirect::route('home');
        }else{
            return Redirect::back()->withErrors(['msg' => 'Yang diambil melebihi stok !!!']);
        }
    }
    public function laporan(){
        $awal = date('Y-m-d', mktime(0,0,0, date('m'), 1, date('Y')));
        $akhir = date('Y-m-d');

        return view('stock.laporan', compact('awal','akhir'));
    }
    public function listDatalaporan($awal, $akhir)
    {
    
        $stock = Stock::leftJoin('users', 'users.id', '=', 'stocks.id_user')
        ->select('users.*', 'stocks.*', 'stocks.created_at as tanggal')
        ->orderBy('stocks.id', 'desc')
        ->get();
        $no = 0;
        $data = array();
        
        while(strtotime($awal) <= strtotime($akhir)){
        $date = $awal;
        $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));
            foreach($stock as $list){
        $tang = substr($list->tanggal, 0, 10);
                if ($date == $tang){
                    $no ++;
                    $row = array();
                    $row[] = $no;
                    $row[] = tanggal_indonesia(substr($list->tanggal, 0, 10), false);
                    $row[] = $list->jumlah;
                    $row[] = $list->name;
                    $row[] = '<div class="btn-group">
                            <a onclick="deleteData('.$list->id.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                            </div>';
                    $data[] = $row;
                }
            }
        }

        $output = array("data" => $data);
        return response()->json($output);
    }
    public function listDataday($awal, $akhir)
    {
        $no = 0;
        $data = array();
        $jumlah = 0;
        $bayar = 0;
        $tanggal = 0;
        while(strtotime($awal) <= strtotime($akhir)){
            $date = $awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

            $jumlah = Stock::where('created_at', 'LIKE', "$date%")->sum('jumlah');
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = tanggal_indonesia(substr($date, 0, 10), false);
            $row[] = $jumlah;
            $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }
    public function listProdukday($awal, $akhir){
        $no = 0;
        $data = array();
        $jumlah = 0;
        $bayar = 0;
        $tanggal = 0;
        $produk = Produk::where('id_kategori','like','102')->get();
        while(strtotime($awal) <= strtotime($akhir)){
            $date = $awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));
            foreach($produk as $list){
                $jumlah = StockDetail::where('kode_produk', "$list->kode_produk")->where('created_at', 'LIKE', "$date%")->sum('jumlah');
                $no ++;
                $row = array();
                $row[] = $no;
                $row[] = "<b>".tanggal_indonesia(substr($date, 0, 10), false)."</b>";
                $row[] = $list->nama_produk;
                $row[] = $jumlah;
                $data[] = $row;
            }

            
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
    public function listDataweek($awal, $akhir)
    {
        $no = 0;
        $data = array();
        $jumlah = 0;
        $bayar = 0;
        $tanggal = 0;
        $count = 1;
        $week = 1;
        $total_bayar = 0;
        $total_jumlah = 0;
        while(strtotime($awal) <= strtotime($akhir)){
            $hari = $awal;
            while($count <=7){
                $date = $hari;
                $hari = date('Y-m-d', strtotime("+1 day", strtotime($hari)));
                $jumlah = Stock::where('created_at', 'LIKE', "$date%")->sum('jumlah');
                $total_bayar = $total_bayar + $bayar;
                $total_jumlah = $total_jumlah + $jumlah;
                $count ++;
            }
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = "Minggu ke-".$week;
            $row[] = $total_jumlah;
            $row[] = "Rp. ".format_uang($total_bayar);
            $data[] = $row;
            $week ++;
            $count = 1;
            $total_bayar = 0;
            $total_jumlah = 0;
            $total_jumlah = $total_jumlah + $jumlah;
            $awal = date('Y-m-d', strtotime("+7 day", strtotime($awal)));
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    public function listProdukweek($awal, $akhir)
    {
        $no = 0;
        $data = array();
        $count = 1;
        $week = 1;
        $sum = 0;
        $hari = $awal;
        $produk = Produk::where('id_kategori','like','102')->get();
        while(strtotime($awal) <= strtotime($akhir)){
            foreach($produk as $list){
                while($count <= "7"){
                    $date = $hari;
                    $hari = date('Y-m-d', strtotime("+1 day", strtotime($hari)));
                    $jumlah = StockDetail::where('kode_produk', "$list->kode_produk")->where('created_at', 'LIKE', "$date%")->sum('jumlah');
                    $sum = $sum + $jumlah;
                    $count ++;
                }
                $count = 1;
                $hari = $awal;
                $no ++;
                $row = array();
                $row[] = $no;
                $row[] = "<b>Minggu ke - ".$week."</b>";
                $row[] = $list->nama_produk;
                $row[] = $sum;
                $data[] = $row;
                $sum = 0;
            }
            $week ++;
            $awal = date('Y-m-d', strtotime("+7 day", strtotime($awal)));
        }

        $output = array("data" => $data);
        return response()->json($output);
    }
    public function listDatamonth($awal, $akhir)
    {
        $no = 0;
        $data = array();
        $jumlah = 0;
        $bayar = 0;
        while(strtotime($awal) <= strtotime($akhir)){
            $date = substr($awal, 0, 7);
            $awal = date('Y-m-d', strtotime("+1 month", strtotime($awal)));
            $jumlah = Stock::where('created_at', 'LIKE', "$date%")->sum('jumlah');
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = tanggal_indonesia(substr($date, 0, 7), false);
            $row[] = $jumlah;
            $row[] = "Rp. ".format_uang($bayar);
            $data[] = $row;
                
            
        }

        $output = array("data" => $data);
        return response()->json($output);
    }
    public function listProdukmonth($awal, $akhir)
    {
        $no = 0;
        $data = array();
        $jumlah = 0;
        $bayar = 0;
        $produk = Produk::where('id_kategori','like','102')->get();
        while(strtotime($awal) <= strtotime($akhir)){
            $date = substr($awal, 0, 7);
            $awal = date('Y-m-d', strtotime("+1 month", strtotime($awal)));
            foreach($produk as $list){
                $jumlah = StockDetail::where('kode_produk', "$list->kode_produk")->where('created_at', 'LIKE', "$date%")->sum('jumlah');
                $no ++;
                $row = array();
                $row[] = $no;
                $row[] = tanggal_indonesia(substr($date, 0, 7), false);
                $row[] = $list->nama_produk;
                $row[] = $jumlah;
                $data[] = $row;
            }              
            
        }

        $output = array("data" => $data);
        return response()->json($output);
    }
    public function listDatayear($awal, $akhir)
    {
        $no = 0;
        $data = array();
        $jumlah = 0;
        $bayar = 0;
        while(strtotime($awal) <= strtotime($akhir)){
            $date = substr($awal, 0, 4);
            $awal = date('Y-m-d', strtotime("+1 year", strtotime($awal)));
            $jumlah = Stock::where('created_at', 'LIKE', "$date%")->sum('jumlah');
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = substr($date, 0, 4);
            $row[] = $jumlah;
            $row[] = "Rp. ".format_uang($bayar);
            $data[] = $row;
                
            
        }

        $output = array("data" => $data);
        return response()->json($output);
    }
    public function listProdukyear($awal, $akhir)
    {
        $no = 0;
        $data = array();
        $jumlah = 0;
        $bayar = 0;
        $produk = Produk::where('id_kategori','like','102')->get();
        while(strtotime($awal) <= strtotime($akhir)){
            $date = substr($awal, 0, 4);
            $awal = date('Y-m-d', strtotime("+1 year", strtotime($awal)));
            foreach($produk as $list){
                $jumlah = StockDetail::where('kode_produk', "$list->kode_produk")->where('created_at', 'LIKE', "$date%")->sum('jumlah');
                $no ++;
                $row = array();
                $row[] = $no;
                $row[] = substr($date, 0, 4);
                $row[] = $list->nama_produk;
                $row[] = $jumlah;
                $data[] = $row;
            }              
            
        }

        $output = array("data" => $data);
        return response()->json($output);
    }
    public function refresh(Request $request)
    {
        $awal = $request['awal'];
        $akhir = $request['akhir'];
        // $last = date('Y-m-d', strtotime("+1 day", strtotime($akhir)));
        // dd($awal);  
        return view('stock.laporan', compact('awal', 'akhir')); 
    }

}
