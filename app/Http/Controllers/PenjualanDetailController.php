<?php

namespace App\Http\Controllers;

use Redirect;
use Auth;
use PDF;
use Carbon;
use App\Penjualan;
use App\Produk;
use App\Member;
use App\JenisPembayaran;
use App\Setting;
use App\PenjualanDetail;
use App\PaketDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenispembayaran = JenisPembayaran::where('id_jenis','not like','1000')->where('id_jenis','not like','1003')->get();
        $produk = Produk::where('id_kategori', 'not like' ,'102')
                       
                        ->where('jenis_produk','Paket')
                        ->orderBy('id_produk','desc')->get();
        $member = Member::all();
        $setting = Setting::first();

        if(!empty(session('idpenjualan'))){
            $idpenjualan = session('idpenjualan');
            return view('penjualan_detail.index', compact('jenispembayaran','produk', 'member', 'setting', 'idpenjualan'));
        }else{
            return Redirect::route('home');  
        }
    }

    public function listData($id)
    {
        $detail = PenjualanDetail::leftJoin('produk', 'produk.kode_produk', '=', 'penjualan_detail.kode_produk')
            ->where('id_penjualan', '=', $id)


            ->get([
                'penjualan_detail.kode_produk', 'produk.nama_produk', 
                'penjualan_detail.harga_jual', 'penjualan_detail.jumlah',
                'penjualan_detail.diskon','penjualan_detail.sub_total',
                'penjualan_detail.id_penjualan_detail','penjualan_detail.id_penjualan',
                
        ]);
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
            
            $row[] = "<input type='number' class='form-control' name='harga_jual_$list->id_penjualan_detail' value='$list->harga_jual' onChange='changeHarga($list->id_penjualan_detail)'>";
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
        $detail->tanggal = $request['tanggal'];
        $detail->kode_produk = $request['kode'];
        $detail->harga_jual = $produk->harga_jual;
        $detail->jumlah = 1;
        $detail->jumlah_awal = 1;
        $detail->sub_total_awal = $produk->harga_jual - ($produk->diskon/100 * $produk->harga_jual);
        $detail->qty_retur = 0;
        $detail->sub_total_retur = 0;
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
        $harga_input = "harga_jual_".$id;
        $detail = PenjualanDetail::find($id);
        $total_harga = $request[$nama_input] * $request[$harga_input];
       

        $detail->jumlah = $request[$nama_input];
        $detail->harga_jual = $request[$harga_input];
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
        $kurang = 0;
        $detail = PenjualanDetail::where('id_penjualan', '=', $request['idpenjualan'])->get();
        foreach($detail as $data){
            $produk = Produk::where('kode_produk', '=', $data->kode_produk)->first();
            if($produk->jenis_produk == 'Paket'){
                // dd($produk->id_kategori);
                $paket = PaketDetail::where('id_paket', $produk->id_produk)->get();
                 //dd($paket);
                foreach($paket as $pak){
                    $produk2 = Produk::where('kode_produk', '=', $pak->kode_produk)->first();
                    if($produk2->stok < $data->jumlah){
                        $kurang = 1;
                        $nampro = $produk2->nama_produk;
                        break;
                    }
                }
            }
            // if($produk->stok < $data->jumlah){
            //     $kurang = 1;
            //     $nampro = $produk->nama_produk;
            //     break;
            // }
        }
        if ($kurang == 1){
            return Redirect::back()->withErrors(['msg' => 'Stock '.$nampro.' tidak cukup !!!']);
        }
        // if ($request['diterima'] < $request['bayar']){
        //     return Redirect::back()->withErrors(['msg' => 'Uang Sebelumnya Kurang !!!']);
        // }
        else{
            
            $penjualan = Penjualan::find($request['idpenjualan']);
            if(!empty($request['member'])){
                $member = Member::where('kode_member','like',$request['member'])->first();
                // dd($member->nama);
                $penjualan->kode_member = $member->kode_member;
                $penjualan->nama = $member->nama;
                $penjualan->telpon = $member->telpon;
                $penjualan->jenis_member = $member->jenis_member;
                $penjualan->nama_sa = $member->nama_sa;
                
            }
            $penjualan->tanggal = $request['tanggal'];
            $penjualan->jenis_pembayaran = $request['jenis_pembayaran'];
            $penjualan->total_item = $request['totalitem'];
            $penjualan->total_harga = $request['total'];
            $penjualan->alamat_kirim = $request['alamatkirim'];
            
            
            $penjualan->diskon = $request['diskon'];
            $penjualan->bayar = $request['bayar'];
            $penjualan->diterima = $request['diterima'];
            $penjualan->ongkir = $request['ongkir'];
            $penjualan->kurir = $request['kurir'];
            $idpenjualan= $request['idpenjualan'];
            if ($penjualan->diterima >= $penjualan->bayar ){
                $penjualan->ket_bayar = 'LUNAS';
            }

            else {
                $penjualan->ket_bayar = 'BELUM LUNAS';
            }
            
            $penjualan->update();

            try{
                DB::transaction(function () use ($request, $idpenjualan) {
                  $tgldetail = PenjualanDetail::where('id_penjualan', $idpenjualan)->update([
                      'tanggal'              => $request->tanggal
                  ]);
  
              });
  
                  $json = [
                      'msg' => 'Data tanggal berhasil diubah',
                      'status' => true
                  ];
              } catch(Exception $e) {
                  $json = [
                      'msg'       => 'error',
                      'status'    => false,
                      'e'         => $e
                  ];
              }

            

            $detail = PenjualanDetail::where('id_penjualan', '=', $request['idpenjualan'])->get();
            foreach($detail as $data){
                $produk = Produk::where('kode_produk', '=', $data->kode_produk)->first();
                if($produk->jenis_produk == 'Paket'){
                    // dd($produk->id_kategori);
                    $paket = PaketDetail::where('id_paket', $produk->id_produk)->get();
                    // dd($paket);
                    foreach($paket as $pak){
                        $produk2 = Produk::where('kode_produk', '=', $pak->kode_produk)->first();
                        $produk2->stok -= $data->jumlah * $pak->jumlah;
                        $produk2->update(); 
                    }
                }
                // $produk->stok = $produk->stok - $data->jumlah;
                // $produk->update();
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
