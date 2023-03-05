<?php

namespace App\Http\Controllers;

use Redirect;
use App\Produk;
use App\Member;
use App\Penjualan;
use App\Pembelian;
use App\PenjualanDetail;
use Illuminate\Http\Request;

class PenjualanDealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $awal = date('Y-m-d', mktime(0,0,0, date('m'), 1, date('Y')));
        $akhir = date('Y-m-d');
        // $last = date('Y-m-d', strtotime("+1 day", strtotime($akhir)));
        // dd($last);  
        return view('penjualan.index', compact('awal', 'akhir'));
    }

    public function listData($awal, $akhir)
    {
    
        $penjualan = Penjualan::leftJoin('users', 'users.id', '=', 'penjualan.id_user')
        ->select('users.*', 'penjualan.*', 'penjualan.created_at as tanggal')
        ->orderBy('penjualan.id_penjualan', 'asc')
        ->get();
        $no = 0;
        $data = array();
        
        while(strtotime($awal) <= strtotime($akhir)){
        $date = $awal;
        $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));
            foreach($penjualan as $list){
        $tang = substr($list->tanggal, 0, 10);
                if ($date == $tang){
                    $no ++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $list->notransaksi;
                    $row[] = tanggal_indonesia(substr($list->tanggal, 0, 10), false);
                    $row[] = $list->kode_member;
                    $row[] = $list->telp;
                    // $row[] = $list->total_item;
                    // $row[] = "Rp. ".format_uang($list->total_harga);
                    // $row[] = $list->diskon."%";
                    $row[] = "Rp. ".format_uang($list->bayar);
                    $row[] = $list->name;
                    $row[] = '<div class="btn-group">
                            <a onclick="showDetail('.$list->id_penjualan.')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                            <a onclick="deleteData('.$list->id_penjualan.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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

            $bayar = Penjualan::where('created_at', 'LIKE', "$date%")->sum('bayar');
            // $jumlah = Penjualan::where('created_at', 'LIKE', "$date%")->sum('total_item');
            $penjualan = Penjualan::where('created_at', 'LIKE', "$date%")->get();
            foreach($penjualan as $list){
                $jumlah++;
            }
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = tanggal_indonesia(substr($date, 0, 10), false);
            $row[] = $jumlah;
            $row[] = "Rp. ".format_uang($bayar);
            $data[] = $row;
            $jumlah = 0;
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
        $produk = Produk::where('id_kategori','not like','102')->get();
        while(strtotime($awal) <= strtotime($akhir)){
            $date = $awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));
            foreach($produk as $list){
                $jumlah = PenjualanDetail::where('kode_produk', "$list->kode_produk")->where('created_at', 'LIKE', "$date%")->sum('jumlah');
                if($jumlah > 0){
                    $no ++;
                    $row = array();
                    $row[] = $no;
                    $row[] = "<b>".tanggal_indonesia(substr($date, 0, 10), false)."</b>";
                    $row[] = $list->nama_produk;
                    $row[] = $jumlah;
                    $data[] = $row;
                };
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
                $bayar = Penjualan::where('created_at', 'LIKE', "$date%")->sum('bayar');
                // $jumlah = Penjualan::where('created_at', 'LIKE', "$date%")->sum('total_item');
                $penjualan = Penjualan::where('created_at', 'LIKE', "$date%")->get();
                foreach($penjualan as $list){
                    $jumlah++;
                }
                $total_bayar = $total_bayar + $bayar;
                // $total_jumlah = $total_jumlah + $jumlah;
                $count ++;
            }
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = "Minggu ke-".$week;
            $row[] = $jumlah;
            $row[] = "Rp. ".format_uang($total_bayar);
            $data[] = $row;
            $week ++;
            $count = 1;
            $total_bayar = 0;
            $jumlah = 0;
            $total_bayar = $total_bayar + $bayar;
            $total_jumlah = $total_jumlah + $jumlah;
            $awal = date('Y-m-d', strtotime("+8 day", strtotime($awal)));
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
        $produk = Produk::where('id_kategori','not like','102')->get();
        while(strtotime($awal) <= strtotime($akhir)){
            foreach($produk as $list){
                while($count <= "7"){
                    $date = $hari;
                    $hari = date('Y-m-d', strtotime("+1 day", strtotime($hari)));
                    $jumlah = PenjualanDetail::where('kode_produk', "$list->kode_produk")->where('created_at', 'LIKE', "$date%")->sum('jumlah');
                    $sum = $sum + $jumlah;
                    $count ++;
                }
                if($sum >= 1){
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
                }else{
                    $count = 1;
                    $hari = $awal;
                    $sum = 0;
                };
            }
            $week ++;
            $awal = date('Y-m-d', strtotime("+8 day", strtotime($awal)));
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

            $bayar = Penjualan::where('created_at', 'LIKE', "$date%")->sum('bayar');
            // $jumlah = Penjualan::where('created_at', 'LIKE', "$date%")->sum('total_item');
            $penjualan = Penjualan::where('created_at', 'LIKE', "$date%")->get();
            foreach($penjualan as $list){
                $jumlah++;
            }
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = tanggal_indonesia(substr($date, 0, 7), false);
            $row[] = $jumlah;
            $row[] = "Rp. ".format_uang($bayar);
            $data[] = $row;
            $jumlah = 0;
            
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
        $produk = Produk::where('id_kategori','not like','102')->get();
        while(strtotime($awal) <= strtotime($akhir)){
            $date = substr($awal, 0, 7);
            $awal = date('Y-m-d', strtotime("+1 month", strtotime($awal)));
            foreach($produk as $list){
                $jumlah = PenjualanDetail::where('kode_produk', "$list->kode_produk")->where('created_at', 'LIKE', "$date%")->sum('jumlah');
                if($jumlah > 0){
                $no ++;
                $row = array();
                $row[] = $no;
                $row[] = tanggal_indonesia(substr($date, 0, 7), false);
                $row[] = $list->nama_produk;
                $row[] = $jumlah;
                $data[] = $row;
                };
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
            $date = substr($awal, 0, 5);
            $awal = date('Y-m-d', strtotime("+1 year", strtotime($awal)));

            $bayar = Penjualan::where('created_at', 'LIKE', "$date%")->sum('bayar');
            // $jumlah = Penjualan::where('created_at', 'LIKE', "$date%")->sum('total_item');
            $penjualan = Penjualan::where('created_at', 'LIKE', "$date%")->get();
            foreach($penjualan as $list){
                $jumlah++;
            }
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = substr($date, 0, 4);
            $row[] = $jumlah;
            $row[] = "Rp. ".format_uang($bayar);
            $data[] = $row;
            $jumlah = 0;
            
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
        $produk = Produk::where('id_kategori','not like','102')->get();
        while(strtotime($awal) <= strtotime($akhir)){
            $date = substr($awal, 0, 4);
            $awal = date('Y-m-d', strtotime("+1 year", strtotime($awal)));
            foreach($produk as $list){
                $jumlah = PenjualanDetail::where('kode_produk', "$list->kode_produk")->where('created_at', 'LIKE', "$date%")->sum('jumlah');
                if($jumlah > 0){
                $no ++;
                $row = array();
                $row[] = $no;
                $row[] = substr($date, 0, 4);
                $row[] = $list->nama_produk;
                $row[] = $jumlah;
                $data[] = $row;
                };
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
        // dd($last);  
        if(strtotime($awal) <= strtotime($akhir)){
            return view('penjualan.index', compact('awal', 'akhir')); 
        }else{
            return Redirect::back()->withErrors(['msg' => 'Periode Salah !!!']);
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = PenjualanDetail::leftJoin('produk', 'produk.kode_produk', '=', 'penjualan_detail.kode_produk')
        ->where('id_penjualan', '=', $id)
        ->get();
        $no = 0;
        $data = array();
        foreach($detail as $list){
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = $list->kode_produk;
            $row[] = $list->nama_produk;
            $row[] = "Rp. ".format_uang($list->harga_jual);
            $row[] = $list->jumlah;
            $row[] = "Rp. ".format_uang($list->sub_total);
            $data[] = $row;
        }
    
        $output = array("data" => $data);
        return response()->json($output);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        $penjualan->delete();

        $detail = PenjualanDetail::where('id_penjualan', '=', $id)->get();
        foreach($detail as $data){
            $produk = Produk::where('kode_produk', '=', $data->kode_produk)->first();
            $produk->stok += $data->jumlah;
            $produk->update();
            $data->delete();
        }
    }
}
