<?php

namespace App\Http\Controllers;

use Redirect;
use App\Exports\PenjualanExport;
use App\Exports\PenjualanResellerExport;
use App\Exports\PenjualanDistributorExport;
use App\Exports\PenjualanMarketingExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Produk;
use App\PaketDetail;
use App\Member;
use App\Penjualan;
use App\Pembelian;
use App\PenjualanDetail;
use App\Setting;
use PDF;
use Illuminate\Http\Request;

class ReturController extends Controller
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
        return view('retur.index', compact('awal', 'akhir'));
    }

    public function listData($awal, $akhir)
    {
    
        $penjualan = Penjualan::leftJoin('users', 'users.id', '=', 'penjualan.id_user')
        ->leftJoin('member', 'member.kode_member', '=', 'penjualan.kode_member')
        
        ->select('users.*','member.*', 'penjualan.*', 'penjualan.tanggal as tanggal')
        //->orderBy('penjualan.tanggal', 'desc')
        ->orderBy('penjualan.id_penjualan', 'desc')
        ->get();
        //dd($penjualan);
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
                    $row[] = $list->nama;
                    $row[] = $list->telpon;
                    $row[] = $list->alamat_kirim;
                    $row[] = $list->kurir;
                
                   
                    $row[] = "Rp. ".format_uang($list->bayar);
                    $row[] = $list->name;
                  
                    if($list->ket_bayar== 'LUNAS'){
                        $row[] =' 
                        <td><span class="label label-success">'.$list->ket_bayar.'</span></td>
                        ';
                    }

                    else {
                        $row[] =' 
                        <td><span class="label label-danger">'.$list->ket_bayar.'</span></td>      
                        <a onclick="bayar('.$list->id_penjualan.')" class="btn btn-warning btn-sm">Bayar<i class="fa fa-money"></i></a>
                        ';
                    }
                    
                    $row[] = '<div class="btn-group">
                            <a onclick="showDetail('.$list->id_penjualan.')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                            
                            <a onclick="tampilInvoice('.$list->id_penjualan.')" class="btn btn-default btn-sm"><i class="fa fa-print"></i></a>
         
                            <a onclick="deleteData('.$list->id_penjualan.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                            </div>';
                    $data[] = $row;
                }
            }
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    

    

   

    public function listMarketingData($awal, $akhir)
    {
    
        $penjualan = Penjualan::leftJoin('users', 'users.id', '=', 'penjualan.id_user')
        ->leftJoin('member', 'member.kode_member', '=', 'penjualan.kode_member')
        ->leftJoin('penjualan_detail', 'penjualan_detail.id_penjualan', '=', 'penjualan.id_penjualan')
        ->leftJoin('produk', 'penjualan_detail.kode_produk', '=', 'produk.kode_produk')
        
        ->select('users.*','member.*', 'penjualan.*', 'penjualan.tanggal as tanggal','produk.nama_produk',
        'penjualan_detail.qty_retur','penjualan_detail.jumlah_awal','penjualan_detail.jumlah')
        ->where('member.jenis_member', '=', 'partner')
        ->orderBy('penjualan.tanggal', 'desc')
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
                    $row[] = tanggal_indonesia(substr($list->tanggal, 0, 10), false);
                    $row[] = $list->nama;
                    $row[] = $list->alamat_kirim;
                    $row[] = $list->kurir;
                    $row[] = $list->nama_produk;
                    $row[] = $list->jumlah_awal;
                    $row[] = $list->qty_retur ;
                    $row[] = $list->jumlah ;
                 
                    $row[] = "Rp. ".format_uang($list->bayar);
                    $row[] = $list->name;

                    $row[] =' 
            
                    <a onclick="retur('.$list->id_penjualan.')" class="btn btn-danger btn-sm">Retur</a>
                        ';
                  
                    

                   
                    
                    
                    
                    
                    $data[] = $row;
                }
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
            return view('retur.index', compact('awal', 'akhir')); 
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
    public function edit($id)
    {
        $penjualan = Penjualan::find($id);
        echo json_encode($penjualan);
    }

    public function bayar($id)
    {
        $penjualan = Penjualan::leftJoin('member', 'member.kode_member', '=', 'penjualan.kode_member')
        
        ->select('member.*', 'penjualan.*', 'penjualan.tanggal as tanggal')
        ->where('penjualan.id_penjualan', '=', $id)
        ->orderBy('penjualan.tanggal', 'desc')
        ->first();
        //$penjualan = Penjualan::find($id);
        //dd($penjualan);
        echo json_encode($penjualan);
    }

    public function retur($id)
    {
        $penjualan = Penjualan::leftJoin('member', 'member.kode_member', '=', 'penjualan.kode_member')
        ->leftJoin('penjualan_detail', 'penjualan_detail.id_penjualan', '=', 'penjualan.id_penjualan')
        ->leftJoin('produk', 'produk.kode_produk', '=', 'penjualan_detail.kode_produk')
        ->select('member.*', 'penjualan.*', 'penjualan.tanggal as tanggal', 'produk.nama_produk',
        'penjualan_detail.sub_total_awal','penjualan_detail.jumlah_awal', 'penjualan_detail.sub_total_retur',
        'penjualan_detail.sub_total','penjualan_detail.jumlah', 'penjualan_detail.qty_retur')

        ->where('penjualan.id_penjualan', '=', $id)
        ->orderBy('penjualan.tanggal', 'desc')
        ->first();
        //$penjualan = Penjualan::find($id);
        //dd($penjualan);
        echo json_encode($penjualan);
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $penjualan = Penjualan::leftJoin('member', 'member.kode_member', '=', 'penjualan.kode_member')
        
        ->select('member.*', 'penjualan.*', 'penjualan.tanggal as tanggal')
        ->where('penjualan.id_penjualan', '=', $id)
        ->orderBy('penjualan.tanggal', 'desc')
        ->first();
        $penjualan->total_item   = $request['jumlah_sold'];
        $penjualan->total_harga   = $request['sub_total_sold'];
        $penjualan->bayar   = $request['sub_total_sold'];


        $detail = PenjualanDetail::where('penjualan_detail.id_penjualan', '=', $id)
        ->first();

        $detail->jumlah   = $request['jumlah_sold'];
        $detail->sub_total   = $request['sub_total_sold'];
        $detail->qty_retur   = $request['diterimaretur'];
        $detail->sub_total_retur   = $request['sub_total_retur'];

       
        
        
        $penjualan->update();
        $detail->update();

        $detailstok = PenjualanDetail::where('id_penjualan', '=', $id)->get();
        foreach($detailstok as $data){
            $produk = Produk::where('kode_produk', '=', $data->kode_produk)->first();
            if($produk->jenis_produk == 'Paket'){
                        $paket = PaketDetail::where('id_paket', $produk->id_produk)->get();
                        
                        foreach($paket as $pak){
                            $produk2 = Produk::where('kode_produk', '=', $pak->kode_produk)->first();
                            $produk2->stok += $request['diterimaretur'] * $pak->jumlah;
                            $produk2->update(); 
                           
                        }
                    }

       
                }
        echo json_encode(array('msg'=>'success'));
    }

    public function returupdate(Request $request, $idretur)
    {
        $penjualan = Penjualan::leftJoin('member', 'member.kode_member', '=', 'penjualan.kode_member')
        
        ->select('member.*', 'penjualan.*', 'penjualan.tanggal as tanggal')
        ->where('penjualan.id_penjualan', '=', $idretur)
        ->orderBy('penjualan.tanggal', 'desc')
        ->first();
        $penjualan->total_item   = $request['jumlah_sold'];
        $penjualan->total_harga   = $request['sub_total_sold'];
        $penjualan->bayar   = $request['sub_total_sold'];


        $detail = PenjualanDetail::where('penjualan_detail.id_penjualan', '=', $id)
        ->first();

        $detail->jumlah   = $request['jumlah_sold'];
        $detail->sub_total   = $request['sub_total_sold'];
        $detail->qty_retur   = $request['diterimaretur'];
        $detail->sub_total_retur   = $request['sub_total_retur'];
        $penjualan->update();
        $detail->update();

        $detailstok = PenjualanDetail::where('id_penjualan', '=', $id)->get();
        foreach($detailstok as $data){
            $produk = Produk::where('kode_produk', '=', $data->kode_produk)->first();
            if($produk->jenis_produk == 'Paket'){
                        $paket = PaketDetail::where('id_paket', $produk->id_produk)->get();
                        
                        foreach($paket as $pak){
                            $produk2 = Produk::where('kode_produk', '=', $pak->kode_produk)->first();
                            $produk2->stok += $request['diterimaretur'] * $pak->jumlah;
                            $produk2->update(); 
                           
                        }
                    }

       
                }
        
        
        echo json_encode(array('msg'=>'success'));
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
            if($produk->jenis_produk == 'Paket'){
                        $paket = PaketDetail::where('id_paket', $produk->id_produk)->get();
                        
                        foreach($paket as $pak){
                            $produk2 = Produk::where('kode_produk', '=', $pak->kode_produk)->first();
                            $produk2->stok += $data->jumlah * $pak->jumlah;
                            $produk2->update(); 
                           
                        }
                    }
            
            $data->delete();
        }
    }


    

    
}
