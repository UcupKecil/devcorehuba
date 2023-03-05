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
use App\StokHuba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

 
use App\Exports\ProdukExport;
use Maatwebsite\Excel\Facades\Excel;

class HistoryStokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function ambilindex(){
        
        $ambil = Ambil::orderBy('tanggal', 'desc')->get();

        return view('history_stok.ambilindex',compact('ambil'));
    }

    public function tambahindex(){
        
        $tambah = Tambah::orderBy('tanggal', 'desc')
        ->get();

        return view('history_stok.tambahindex',compact('tambah'));
    }

    public function stokhubaindex(){
        
        $stokhuba = StokHuba::leftJoin('produk', 'produk.kode_produk', '=', 'v_history_stok.kode_produk')
        ->leftJoin('users', 'users.id', '=', 'v_history_stok.user_id')
        ->select('users.name', 'produk.nama_produk','v_history_stok.*')
        ->orderBy('tanggal', 'desc')
        ->get();
        //DD($stokhuba);

        return view('history_stok.stokhubaindex',compact('stokhuba'));
    }
    
    public function ambildata(){
        $ambil = Ambil::leftJoin('produk', 'produk.kode_produk', '=', 'ambils.kode_produk')
        ->leftJoin('users', 'users.id', '=', 'ambils.user')
        // ->select('users.*', 'produk.*','ambils.*','CONCAT ( '-', `ambils`.`ambil`) AS `stok`')
        ->select('users.*', 'produk.nama_produk','ambils.*',DB::raw("CONCAT('-',' ',ambils.ambil) as stok"),
        DB::raw('0 as masuk'),'ambils.ambil AS keluar')
        ->orderBy('ambils.tanggal', 'desc')
        ->get();
            $no = 0;
            $data = array();
            foreach($ambil as $list){
                if($list->nama_kategori != 'Stock'){
                    $no ++;
                    $row = array();
                    $row[] = $no;
                    $row[] = tanggal_indonesia(substr($list->tanggal, 0, 10), false);
                    $row[] = $list->stok;
                    $row[] = $list->masuk;
                    $row[] = $list->keluar;
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

    public function tambahdata(){
        $tambah = Tambah::leftJoin('produk', 'produk.kode_produk', '=', 'tambahs.kode_produk')
        ->leftJoin('users', 'users.id', '=', 'tambahs.user')
        ->select('users.*', 'produk.nama_produk','tambahs.*',DB::raw("CONCAT('+',' ',tambahs.tambah) as stok"),
        'tambahs.tambah AS masuk',DB::raw('0 as keluar'))
        ->orderBy('tambahs.tanggal', 'desc')
        ->get();
            $no = 0;
            $data = array();
            foreach($tambah as $list){
                if($list->nama_kategori != 'Stock'){
                    $no ++;
                    $row = array();
                    $row[] = $no;
                    $row[] = tanggal_indonesia(substr($list->tanggal, 0, 10), false);
                    $row[] = $list->stok;
                    $row[] = $list->masuk;
                    $row[] = $list->keluar;
                    $row[] = $list->nama_produk;
                    $row[] = $list->tambah;
                    $row[] = $list->keterangan;
                    $row[] = $list->name;
                    $data[] = $row;
                }
            }
            
            $output = array("data" => $data);
            return response()->json($output);
    }

    public function stokhubadata(){
        $stokhuba = StokHuba::leftJoin('produk', 'produk.kode_produk', '=', 'v_history_stok.kode_produk')
        ->leftJoin('users', 'users.id', '=', 'v_history_stok.user_id')
        ->select('users.*', 'produk.nama_produk','v_history_stok.*')
        ->orderBy('v_history_stok.tanggal', 'DESC')
        ->get();
       
            $no = 0;
            $data = array();
            foreach($stokhuba as $list){
                if($list->nama_kategori != 'Stock'){
                    $no ++;
                    $row = array();
                    $row[] = $no;
                    $row[] = tanggal_indonesia(substr($list->tanggal, 0, 10), false);
                    $row[] = $list->stok;
                    $row[] = $list->masuk;
                    $row[] = $list->keluar;
                    $row[] = $list->nama_produk;
                    $row[] = $list->keterangan;
                    $row[] = $list->name;
                    $data[] = $row;
                }
            }
            
            $output = array("data" => $data);
            return response()->json($output);
    }
  
}
