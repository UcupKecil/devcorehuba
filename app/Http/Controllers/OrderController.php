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

class OrderController extends Controller
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
        return view('order.index', compact('awal', 'akhir'));
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
                   
                    $row[] = tanggal_indonesia(substr($list->tanggal, 0, 10), false);
                    $row[] = $list->nama;
                    $row[] = $list->telpon;
                    $row[] = $list->alamat_kirim;
                    $row[] = $list->kurir;
                    $row[] = $list->ongkir;
                    // $row[] = $list->total_item;
                    // $row[] = "Rp. ".format_uang($list->total_harga);
                    // $row[] = $list->diskon."%";
                    $row[] = "Rp. ".format_uang($list->bayar);
                    $row[] = $list->name;
                  
                    
                    
                    $row[] = '<div class="btn-group">
                            <a onclick="showDetail('.$list->id_penjualan.')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                            
        
                            
                            </div>';
                    $data[] = $row;
                }
            }
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    public function listEnduserData($awal, $akhir)
    {
    
        $penjualan = Penjualan::leftJoin('users', 'users.id', '=', 'penjualan.id_user')
        ->leftJoin('member', 'member.kode_member', '=', 'penjualan.kode_member')
        
        ->select('users.*','member.*', 'penjualan.*', 'penjualan.tanggal as tanggal')
        ->where('member.jenis_member', '=', 'enduser')
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
                    $row[] = $list->telpon;
                    $row[] = $list->alamat_kirim;
                    $row[] = $list->kurir;
                    $row[] = $list->ongkir;
                    // $row[] = $list->total_item;
                    // $row[] = "Rp. ".format_uang($list->total_harga);
                    // $row[] = $list->diskon."%";
                    $row[] = "Rp. ".format_uang($list->bayar);
                    $row[] = $list->name;
                  
                    
                    
                    $row[] = '<div class="btn-group">
                            <a onclick="showDetail('.$list->id_penjualan.')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>

                           
                            </div>';
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
            return view('order.index', compact('awal', 'akhir')); 
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
        $penjualan->diterima   = $request['diterima'];
        if ($request['diterima'] >= $request['bayar']){
            $penjualan->ket_bayar   = 'LUNAS';
        }
        else {
            $penjualan->ket_bayar   = 'BELUM LUNAS';
        }
        
        
        $penjualan->update();
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

    public function notaPDF($id){
        $detail = PenjualanDetail::leftJoin('produk', 'produk.kode_produk', '=', 'penjualan_detail.kode_produk')
            ->where('id_penjualan', '=', $id)
            ->get();

        $penjualan = Penjualan::find($id);
        $setting = Setting::find(1);
        $no = 0;
        
        $pdf = PDF::loadView('penjualan.notapdf', compact('detail', 'penjualan', 'setting', 'no'));
        $pdf->setPaper(array(0,0,200,600), 'potrait');      
        return $pdf->stream();
    }

    public function export()
    {
        return Excel::download(new PenjualanExport, 'penjualan_enduser.xlsx');
        //return Excel::download(new PenjualanExport, 'enduser.xls', \Maatwebsite\Excel\Excel::XLS);
    }
    public function exportreseller()
    {
        return Excel::download(new PenjualanResellerExport, 'penjualan_reseller.xlsx');
        //return Excel::download(new PenjualanExport, 'enduser.xls', \Maatwebsite\Excel\Excel::XLS);
    }
    public function exportdistributor()
    {
        return Excel::download(new PenjualanDistributorExport, 'penjualan_distributor.xlsx');
        //return Excel::download(new PenjualanExport, 'enduser.xls', \Maatwebsite\Excel\Excel::XLS);
    }
    public function exportmarketing()
    {
        return Excel::download(new PenjualanMarketingExport, 'penjualan_marketing.xlsx');
        //return Excel::download(new PenjualanExport, 'enduser.xls', \Maatwebsite\Excel\Excel::XLS);
    }
}
