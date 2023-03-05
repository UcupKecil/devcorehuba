<?php

namespace App\Http\Controllers;

use Redirect;
use Auth;
use PDF;
use Carbon;
use App\Penjualan;
use App\Produk;
use App\Member;
use App\Setting;
use App\PenjualanDetail;
use App\PaketDetail;
use Illuminate\Http\Request;

class PenjualanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::where('id_kategori', 'not like' ,'102')->where('stok','not like','0')->orderBy('id_produk','desc')->get();
        $member = Member::all();
        $setting = Setting::first();

        if(!empty(session('idpenjualan'))){
            $idpenjualan = session('idpenjualan');
            return view('penjualan_detail.index', compact('produk', 'member', 'setting', 'idpenjualan'));
        }else{
            return Redirect::route('home');  
        }
    }

    public function listData($id)
    {
        $detail = PenjualanDetail::leftJoin('produk', 'produk.kode_produk', '=', 'penjualan_detail.kode_produk')
            ->where('id_penjualan', '=', $id)
            ->get();
        $no = 0;
        $data = array();
        $total = 0;
        $total_item = 0;
        foreach($detail as $list){
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = $list->kode_produk;
            $row[] = $list->nama_produk;
            $row[] = "Rp. ".format_uang($list->harga_jual);
            $row[] = "<input type='number' class='form-control' name='jumlah_$list->id_penjualan_detail' value='$list->jumlah' onChange='changeCount($list->id_penjualan_detail)'>";
            $row[] = $list->diskon."%";
            $row[] = "Rp. ".format_uang($list->sub_total);
            $row[] = '<div class="btn-group">
                    <a onclick="deleteItem('.$list->id_penjualan_detail.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
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

        $detail = new PenjualanDetail;
        $detail->id_penjualan = $request['idpenjualan'];
        $detail->kode_produk = $request['kode'];
        $detail->harga_jual = $produk->harga_jual;
        $detail->jumlah = 1;
        $detail->diskon = $produk->diskon;
        $detail->sub_total = $produk->harga_jual - ($produk->diskon/100 * $produk->harga_jual);
        $detail->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PenjualanDetail  $penjualanDetail
     * @return \Illuminate\Http\Response
     */
    public function show(PenjualanDetail $penjualanDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PenjualanDetail  $penjualanDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(PenjualanDetail $penjualanDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PenjualanDetail  $penjualanDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nama_input = "jumlah_".$id;
        $detail = PenjualanDetail::find($id);
        $total_harga = $request[$nama_input] * $detail->harga_jual;

        $detail->jumlah = $request[$nama_input];
        $detail->sub_total = $total_harga - ($detail->diskon/100 * $total_harga);
        $detail->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PenjualanDetail  $penjualanDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->delete();
    }

    public function newSession()
    {
        $table_no = Penjualan::max('id_penjualan');
        $tgl = substr(str_replace( '-', '', Carbon\carbon::now()), 0,8);
        
        $no= $tgl.$table_no;
        $auto=substr($no,8);
        $auto=intval($auto)+1;
        $auto_number=substr($no,0,8).str_repeat(0,(4-strlen($auto))).$auto;

        $penjualan = new Penjualan; 
        // $penjualan->kode_member = 0; 
        $penjualan->notransaksi = $auto_number; 
        $penjualan->total_item = 0;    
        $penjualan->total_harga = 0;    
        $penjualan->diskon = 0;    
        $penjualan->bayar = 0;    
        $penjualan->diterima = 0;    
        $penjualan->id_user = Auth::user()->id;    
        $penjualan->save();
        
        session(['idpenjualan' => $penjualan->id_penjualan]);

        return Redirect::route('transaksi.index');    
    }

    public function saveData(Request $request)
    {
        if ($request['diterima'] < $request['bayar']){
            return Redirect::back()->withErrors(['msg' => 'Uang Sebelumnya Kurang !!!']);
        }else{
            $penjualan = Penjualan::find($request['idpenjualan']);
            if(!empty($request['member'])){
                $member = Member::where('kode_member','like',$request['member'])->first();
                // dd($member->nama);
                $penjualan->kode_member = $member->nama;
                $penjualan->telp = $member->telpon;
            }elseif(empty($request['namamember']) AND empty($request['telp'])){
                $request['namamember'] = "nama kosong";
                $request['telp'] = "00000000";
            }else{
                
                $penjualan->kode_member = $request['namamember'];
                $penjualan->telp = $request['telp'];

                $table_no = Member::max('id_member');
                $tgl = substr(str_replace( '-', '', Carbon\carbon::now()), 0,8);
                
                $no= $tgl.$table_no;
                $auto=substr($no,8);
                $auto=intval($auto)+1;
                $auto_number=substr($no,0,8).str_repeat(0,(4-strlen($auto))).$auto;
                $member = new Member;
                $member->kode_member = $auto_number;
                $member->nama   = $request['namamember'];
                $member->alamat = "";
                $member->telpon = $request['telp'];
                $member->save();
            }
            $penjualan->total_item = $request['totalitem'];
            $penjualan->total_harga = $request['total'];
            $penjualan->diskon = $request['diskon'];
            $penjualan->bayar = $request['bayar'];
            $penjualan->diterima = $request['diterima'];
            $penjualan->update();

            $detail = PenjualanDetail::where('id_penjualan', '=', $request['idpenjualan'])->get();
            foreach($detail as $data){
                $produk = Produk::where('kode_produk', '=', $data->kode_produk)->first();
                if($produk->id_kategori == '103'){
                    // dd($produk->id_kategori);
                    $paket = PaketDetail::where('id_paket', $produk->id_produk)->get();
                    // dd($paket);
                    foreach($paket as $pak){
                        $produk2 = Produk::where('kode_produk', '=', $pak->kode_produk)->first();
                        $produk2->stok -= $data->jumlah;
                        $produk2->update(); 
                    }
                }
                $produk->stok = $produk->stok - $data->jumlah;
                $produk->update();
            }
            return Redirect::route('transaksi.cetak');
        }
    }
    
    public function loadForm($diskon, $total, $diterima){
        $bayar = $total - ($diskon / 100 * $total);
        $kembali = ($diterima != 0) ? $diterima - $bayar : 0;

        $data = array(
            "totalrp" => format_uang($total),
            "bayar" => $bayar,
            "bayarrp" => format_uang($bayar),
            "terbilang" => ucwords(terbilang($bayar))." Rupiah",
            "kembalirp" => format_uang($kembali),
            "kembaliterbilang" => ucwords(terbilang($kembali))." Rupiah"
        );
        return response()->json($data);
    }

    public function printNota()
    {
        $detail = PenjualanDetail::leftJoin('produk', 'produk.kode_produk', '=', 'penjualan_detail.kode_produk')
            ->where('id_penjualan', '=', session('idpenjualan'))
            ->get();

        $penjualan = Penjualan::find(session('idpenjualan'));
        $setting = Setting::find(1);
        
        // if($setting->tipe_nota == 0){
        //     $handle = printer_open(); 
        //     printer_start_doc($handle, "Nota");
        //     printer_start_page($handle);

        //     $font = printer_create_font("Consolas", 100, 80, 600, false, false, false, 0);
        //     printer_select_font($handle, $font);
            
        //     printer_draw_text($handle, $setting->nama_perusahaan, 400, 100);

        //     $font = printer_create_font("Consolas", 72, 48, 400, false, false, false, 0);
        //     printer_select_font($handle, $font);
        //     printer_draw_text($handle, $setting->alamat, 50, 200);

        //     printer_draw_text($handle, date('Y-m-d'), 0, 400);
        //     printer_draw_text($handle, substr("             ".Auth::user()->name, -15), 600, 400);

        //     printer_draw_text($handle, "No : ".substr("00000000".$penjualan->id_penjualan, -8), 0, 500);

        //     printer_draw_text($handle, "============================", 0, 600);
            
        //     $y = 700;
            
        //     foreach($detail as $list){           
        //         printer_draw_text($handle, $list->kode_produk." ".$list->nama_produk, 0, $y+=100);
        //         printer_draw_text($handle, $list->jumlah." x ".format_uang($list->harga_jual), 0, $y+=100);
        //         printer_draw_text($handle, substr("                ".format_uang($list->harga_jual*$list->jumlah), -10), 850, $y);

        //         if($list->diskon != 0){
        //             printer_draw_text($handle, "Diskon", 0, $y+=100);
        //             printer_draw_text($handle, substr("                      -".format_uang($list->diskon/100*$list->sub_total), -10),  850, $y);
        //         }
        //     }
            
        //     printer_draw_text($handle, "----------------------------", 0, $y+=100);

        //     printer_draw_text($handle, "Total Harga: ", 0, $y+=100);
        //     printer_draw_text($handle, substr("           ".format_uang($penjualan->total_harga), -10), 850, $y);

        //     printer_draw_text($handle, "Total Item: ", 0, $y+=100);
        //     printer_draw_text($handle, substr("           ".$penjualan->total_item, -10), 850, $y);

        //     printer_draw_text($handle, "Diskon Member: ", 0, $y+=100);
        //     printer_draw_text($handle, substr("           ".$penjualan->diskon."%", -10), 850, $y);

        //     printer_draw_text($handle, "Total Bayar: ", 0, $y+=100);
        //     printer_draw_text($handle, substr("            ".format_uang($penjualan->bayar), -10), 850, $y);

        //     printer_draw_text($handle, "Diterima: ", 0, $y+=100);
        //     printer_draw_text($handle, substr("            ".format_uang($penjualan->diterima), -10), 850, $y);

        //     printer_draw_text($handle, "Kembali: ", 0, $y+=100);
        //     printer_draw_text($handle, substr("            ".format_uang($penjualan->diterima-$penjualan->bayar), -10), 850, $y);
            

        //     printer_draw_text($handle, "============================", 0, $y+=100);
        //     printer_draw_text($handle, "-= TERIMA KASIH =-", 250, $y+=100);
        //     printer_delete_font($font);
            
        //     printer_end_page($handle);
        //     printer_end_doc($handle);
        //     printer_close($handle);
        // }
        
        return view('penjualan_detail.selesai', compact('setting'));
    }

    public function notaPDF(){
        $detail = PenjualanDetail::leftJoin('produk', 'produk.kode_produk', '=', 'penjualan_detail.kode_produk')
            ->where('id_penjualan', '=', session('idpenjualan'))
            ->get();

        $penjualan = Penjualan::find(session('idpenjualan'));
        $setting = Setting::find(1);
        $no = 0;
        
        $pdf = PDF::loadView('penjualan_detail.notapdf', compact('detail', 'penjualan', 'setting', 'no'));
        $pdf->setPaper(array(0,0,200,600), 'potrait');      
        return $pdf->stream();
    }
}
