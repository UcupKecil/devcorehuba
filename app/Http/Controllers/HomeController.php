<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Setting;
use App\Note;
use App\Kategori;
use App\Produk;
use App\Supplier;
use App\Member;
use App\Grafik;
use App\Penjualan;
use App\PenjualanDetail;
use App\Pengeluaran;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::find(1);
        $notes = Note::get();
        

        

         $awal1 = date('Y-m-d', mktime(0,0,0, date('m'), 1, date('Y')));
         $akhir1 = date('Y-m-d');
        // $awal1 = date('Y-m-d', mktime(0,0,0, date('m'), 1, date('Y')));
        // $akhir1 = date('Y-m-d', mktime(0,0,0, date('m'), 1+6, date('Y')));
        
        
        $tanggal1 = $awal1;
        $data_tanggal1 = array();
        $data_pendapatan1 = array();

        while(strtotime($tanggal1) <= strtotime($akhir1)){ 
            $data_tanggal1[] = (int)substr($tanggal1,8,2);
            // $jumlah1 = PenjualanDetail::leftJoin('penjualan', 'penjualan.id_penjualan', '=', 'penjualan_detail.id_penjualan')
            // ->leftJoin('produk', 'produk.id_produk', '=', 'penjualan_detail.kode_produk')
            // ->leftJoin('paket_details', 'produk.id_produk', '=', 'paket_details.id_paket')
            // //->select(DB::raw('sum(paket_details.jumlah * penjualan_detail.jumlah) as totalpcs'))
            // ->where('penjualan.tanggal', 'LIKE', "$tanggal1%")->sum('paket_details.jumlah');

            // $jumlah2 = PenjualanDetail::leftJoin('penjualan', 'penjualan.id_penjualan', '=', 'penjualan_detail.id_penjualan')
            // ->leftJoin('produk', 'produk.id_produk', '=', 'penjualan_detail.kode_produk')
            // ->leftJoin('paket_details', 'produk.id_produk', '=', 'paket_details.id_paket')
            // //->select(DB::raw('sum(paket_details.jumlah * penjualan_detail.jumlah) as totalpcs'))
            // ->where('penjualan.tanggal', 'LIKE', "$tanggal1%")->sum('penjualan_detail.jumlah');
            // //->get();
            // $pendapatan1 = $jumlah1 * $jumlah2;
            $pendapatan1 = Grafik::where('tanggal', 'LIKE', "$tanggal1%")->sum('pcs');
            
            $data_pendapatan1[] = (int) $pendapatan1;
            
            $tanggal1 = date('Y-m-d', strtotime("+1 day", strtotime($tanggal1)));
            //dd($pendapatan1);
        }
        $awal2 = date('Y-m-d', mktime(0,0,0, date('m'), 8, date('Y')));
        $akhir2 = date('Y-m-d', mktime(0,0,0, date('m'), 8+6, date('Y')));

        
        $tanggal2 = $awal2;
        $data_tanggal2 = array();
        $data_pendapatan2 = array();

        while(strtotime($tanggal2) <= strtotime($akhir2)){ 
            $data_tanggal2[] = (int)substr($tanggal2,8,2);
            $pendapatan2 = Penjualan::where('tanggal', 'LIKE', "$tanggal2%")->sum('bayar');
            $data_pendapatan2[] = (int) $pendapatan2;
            $tanggal2 = date('Y-m-d', strtotime("+1 day", strtotime($tanggal2)));
        }
        $awal3 = date('Y-m-d', mktime(0,0,0, date('m'), 15, date('Y')));
        $akhir3 = date('Y-m-d', mktime(0,0,0, date('m'), 15+6, date('Y')));
        $tanggal3 = $awal3;
        $data_tanggal3 = array();
        $data_pendapatan3 = array();

        while(strtotime($tanggal3) <= strtotime($akhir3)){ 
            $data_tanggal3[] = (int)substr($tanggal3,8,2);
            $pendapatan3 = Penjualan::where('tanggal', 'LIKE', "$tanggal3%")->sum('bayar');
            $data_pendapatan3[] = (int) $pendapatan3;
            $tanggal3 = date('Y-m-d', strtotime("+1 day", strtotime($tanggal3)));
        }
        $awal4 = date('Y-m-d', mktime(0,0,0, date('m'), 22, date('Y')));
        $akhir4 = date('Y-m-d', mktime(0,0,0, date('m'), 22+6, date('Y')));
        $tanggal4 = $awal4;
        $data_tanggal4 = array();
        $data_pendapatan4 = array();

        while(strtotime($tanggal4) <= strtotime($akhir4)){ 
            $data_tanggal4[] = (int)substr($tanggal4,8,2);
            $pendapatan4 = Penjualan::where('tanggal', 'LIKE', "$tanggal4%")->sum('bayar');
            $data_pendapatan4[] =  (int)$pendapatan4;
            $tanggal4 = date('Y-m-d', strtotime("+1 day", strtotime($tanggal4)));
        }

            $awal = date('Y-m-d', mktime(0,0,0, date('m'), 1, date('Y')));
            $tanggal = substr($awal, 0, 7);
            $awal = date('Y-m-d', strtotime("+1 month", strtotime($awal)));
            $totalpenjualan = Penjualan::where('tanggal', 'LIKE', "$tanggal%")->sum('bayar');
           
            $totalpiutang = Penjualan::where('ket_bayar', '=','belum lunas')->where('tanggal', 'LIKE', "$tanggal%")->sum('bayar');
          
            $totaluang = Penjualan::where('ket_bayar', '=','lunas')->where('tanggal', 'LIKE', "$tanggal%")->sum('bayar');
            
            $totalpembelian = Pengeluaran::where('tanggal', 'LIKE', "$tanggal%")->sum('nominal');
           
            $totaluangcashawal = Penjualan::where('ket_bayar', '=','lunas')
            ->where('tanggal', 'LIKE', "$tanggal%")
            ->where('jenis_pembayaran', '=', "Cash")
            ->sum('bayar');
            $totaluangcash = $totaluangcashawal - $totalpembelian;
            $totaluangtransfer = Penjualan::where('ket_bayar', '=','lunas')
            ->where('tanggal', 'LIKE', "$tanggal%")
            ->where('jenis_pembayaran', '=', "Transfer")
            ->sum('bayar');

            

            $totalpcs = PenjualanDetail::leftJoin('penjualan', 'penjualan.id_penjualan', '=', 'penjualan_detail.id_penjualan')
            ->leftJoin('produk', 'produk.id_produk', '=', 'penjualan_detail.kode_produk')
            ->leftJoin('paket_details', 'produk.id_produk', '=', 'paket_details.id_paket')
            ->select(DB::raw('sum(paket_details.jumlah * penjualan_detail.jumlah) as totalpcs'))
            ->where('penjualan.tanggal', 'LIKE', "$tanggal%")
            ->get();

            $sapipcs = PenjualanDetail::leftJoin('penjualan', 'penjualan.id_penjualan', '=', 'penjualan_detail.id_penjualan')
            ->leftJoin('produk', 'produk.id_produk', '=', 'penjualan_detail.kode_produk')
            ->leftJoin('paket_details', 'produk.id_produk', '=', 'paket_details.id_paket')
            ->select(DB::raw('sum(paket_details.jumlah * penjualan_detail.jumlah) as totalpcs'))
            ->where('penjualan.tanggal', 'LIKE', "$tanggal%")
            ->where('paket_details.nama_produk', '=', "Huba Sapi")
            ->get();

            $ayampcs = PenjualanDetail::leftJoin('penjualan', 'penjualan.id_penjualan', '=', 'penjualan_detail.id_penjualan')
            ->leftJoin('produk', 'produk.id_produk', '=', 'penjualan_detail.kode_produk')
            ->leftJoin('paket_details', 'produk.id_produk', '=', 'paket_details.id_paket')
            ->select(DB::raw('sum(paket_details.jumlah * penjualan_detail.jumlah) as totalpcs'))
            ->where('penjualan.tanggal', 'LIKE', "$tanggal%")
            ->where('paket_details.nama_produk', '=', "Huba Ayam")
            ->get();

            

            $detailbelanja = Pengeluaran::leftJoin('kategori_pengeluarans', 'pengeluaran.id_kategori', '=', 'kategori_pengeluarans.id')
            // ->select('kategori_pengeluarans.nama','sum(pengeluaran.nominal) as total')
            ->select(DB::raw('sum(pengeluaran.nominal) as total'),DB::raw('(kategori_pengeluarans.nama) as kategori'))
            ->where('pengeluaran.tanggal', 'LIKE', "$tanggal%")
            ->groupby('pengeluaran.id_kategori','kategori_pengeluarans.nama')
            ->orderby('pengeluaran.id_kategori', 'DESC')
            ->get();

            $detailpenjualan = PenjualanDetail::leftJoin('penjualan', 'penjualan.id_penjualan', '=', 'penjualan_detail.id_penjualan')
            ->leftJoin('produk', 'produk.id_produk', '=', 'penjualan_detail.kode_produk')
            ->leftJoin('paket_details', 'produk.id_produk', '=', 'paket_details.id_paket')
            ->leftJoin('member', 'member.kode_member', '=', 'penjualan.kode_member')
            ->leftJoin('jenis_member', 'jenis_member.jenis_member', '=', 'penjualan.jenis_member')
            ->select(DB::raw('penjualan.jenis_member'),DB::raw('sum(penjualan_detail.sub_total) as penjualan'),DB::raw('sum(paket_details.jumlah*penjualan_detail.jumlah) as pcs'))
            ->where('penjualan.tanggal', 'LIKE', "$tanggal%")
            ->groupby('penjualan.jenis_member')
            ->orderby('jenis_member.id_jenis', 'ASC')
            ->get();
            //dd($detailpenjualan);

           

        $kategori = Kategori::count();
        $produk = Produk::count();
        $supplier = Supplier::count();
        $memberenduser = Member::where('jenis_member', '=','enduser')->count();
        $memberreseller = Member::where('jenis_member', '=','reseller')->count();
        $memberdistributor = Member::where('jenis_member', '=','distributor')->count();
        $membermarketing = Member::where('jenis_member', '=','partner')->count();
        if(Auth::user()->level != 1) 
        return view('home.kasir', compact('setting'));
        
        else return view('home.admin', compact('kategori', 'produk', 'supplier', 'memberenduser',
        'memberreseller','memberdistributor','membermarketing', 'awal1', 'akhir1',
        'totalpenjualan','totalpiutang','totaluang','totalpembelian',
         'data_pendapatan1', 'data_tanggal1','awal2','akhir2','data_pendapatan2', 'data_tanggal2',
         'awal3','akhir3','data_pendapatan3', 'data_tanggal3',
         'awal4','akhir4','data_pendapatan4', 'data_tanggal4','totalpcs','sapipcs','ayampcs',
         'detailbelanja','totaluangcash','totaluangtransfer','detailpenjualan','notes','setting'
        ));
    }

    
    
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
