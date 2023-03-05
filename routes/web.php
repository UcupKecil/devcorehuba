<?php

use App\Http\Controllers\PenjualanController;
use Maatwebsite\Excel\Facades\Excel;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    // Route::get('/', function () {
    //     return view('welcome');
    // });

    Route::get('/', 'HomeController@index')->name('home');

    Auth::routes();

Route::group(['middleware' => 'web'], function(){
    Route::get('user/profil', 'UserController@profil')->name('user.profil');
    Route::patch('user/{id}/change', 'UserController@changeProfil');

    Route::get('transaksi/baru', 'PenjualanDetailController@newSession')->name('transaksi.new');
    Route::get('transaksi/{id}/data', 'PenjualanDetailController@listData')->name('transaksi.data');
    Route::get('transaksi/cetaknota', 'PenjualanDetailController@printNota')->name('transaksi.cetak');
    Route::get('transaksi/notapdf', 'PenjualanDetailController@notaPDF')->name('transaksi.pdf');
    Route::post('transaksi/simpan', 'PenjualanDetailController@saveData');
    Route::get('transaksi/loadform/{diskon}/{total}/{diterima}', 'PenjualanDetailController@loadForm');
    Route::resource('transaksi', 'PenjualanDetailController');

    Route::get('transaksi_reseller/baru', 'PenjualanDetailResellerController@newSession')->name('transaksi_reseller.new');
    Route::get('transaksi_reseller/{id}/data', 'PenjualanDetailResellerController@listData')->name('transaksi_reseller.data');
    Route::get('transaksi_reseller/cetaknota', 'PenjualanDetailResellerController@printNota')->name('transaksi_reseller.cetak');
    Route::get('transaksi_reseller/notapdf', 'PenjualanDetailResellerController@notaPDF')->name('transaksi_reseller.pdf');
    Route::post('transaksi_reseller/simpan', 'PenjualanDetailResellerController@saveData');
    Route::get('transaksi_reseller/loadform/{diskon}/{total}/{diterima}', 'PenjualanDetailResellerController@loadForm');
    Route::resource('transaksi_reseller', 'PenjualanDetailResellerController');

    Route::get('transaksi_distributor/baru', 'PenjualanDetailDistributorController@newSession')->name('transaksi_distributor.new');
    Route::get('transaksi_distributor/{id}/data', 'PenjualanDetailDistributorController@listData')->name('transaksi_distributor.data');
    Route::get('transaksi_distributor/cetaknota', 'PenjualanDetailDistributorController@printNota')->name('transaksi_distributor.cetak');
    Route::get('transaksi_distributor/notapdf', 'PenjualanDetailDistributorController@notaPDF')->name('transaksi_distributor.pdf');
    Route::post('transaksi_distributor/simpan', 'PenjualanDetailDistributorController@saveData');
    Route::get('transaksi_distributor/loadform/{diskon}/{total}/{diterima}', 'PenjualanDetailDistributorController@loadForm');
    Route::resource('transaksi_distributor', 'PenjualanDetailDistributorController');

    Route::get('transaksi_marketing/baru', 'PenjualanDetailMarketingController@newSession')->name('transaksi_marketing.new');
    Route::get('transaksi_marketing/{id}/data', 'PenjualanDetailMarketingController@listData')->name('transaksi_marketing.data');
    Route::get('transaksi_marketing/cetaknota', 'PenjualanDetailMarketingController@printNota')->name('transaksi_marketing.cetak');
    Route::get('transaksi_marketing/notapdf', 'PenjualanDetailMarketingController@notaPDF')->name('transaksi_marketing.pdf');
    Route::post('transaksi_marketing/simpan', 'PenjualanDetailMarketingController@saveData');
    Route::get('transaksi_marketing/loadform/{diskon}/{total}/{diterima}', 'PenjualanDetailMarketingController@loadForm');
    Route::resource('transaksi_marketing', 'PenjualanDetailMarketingController');

    Route::get('stock/{id}/data', 'StockController@listData')->name('stock.data');
    Route::get('stock/baru', 'StockController@newSession')->name('stock.new');
    Route::post('stock/destroy/{id}','StockController@destroy')->name('stock.destroy');
    Route::post('stock/simpan', 'StockController@saveData');
    Route::get('stock/laporan','StockController@laporan')->name('stock.laporan');
    Route::get('stock/data/{awal}/{akhir}', 'StockController@listDatalaporan')->name('stock.datad');
    Route::get('stock/data/day/{awal}/{akhir}', 'StockController@listDataday')->name('stock.dataday');
    Route::get('stock/produk/day/{awal}/{akhir}', 'StockController@listProdukday')->name('stock.produkday');
    Route::get('stock/data/week/{awal}/{akhir}', 'StockController@listDataweek')->name('stock.dataweek');
    Route::get('stock/produk/week/{awal}/{akhir}', 'StockController@listProdukweek')->name('stock.produkweek');
    Route::get('stock/data/month/{awal}/{akhir}', 'StockController@listDatamonth')->name('stock.datamonth');
    Route::get('stock/produk/month/{awal}/{akhir}', 'StockController@listProdukmonth')->name('stock.produkmonth');
    Route::get('stock/data/year/{awal}/{akhir}', 'StockController@listDatayear')->name('stock.datayear');
    Route::get('stock/produk/year/{awal}/{akhir}', 'StockController@listProdukyear')->name('stock.produkyear');
    Route::post('stock/stockrefresh', 'StockController@refresh')->name('stock.refresh');
    Route::resource('stock','StockController');
    Route::get('liststock','ProdukController@stock')->name('stock.list');
    Route::get('liststock/data','ProdukController@stockdata')->name('liststock.data');

    Route::get('paket/{id}/data', 'PaketController@listData')->name('paket.data');
    Route::get('paket/baru', 'PaketController@newSession')->name('paket.new');
    Route::post('paket/destroy/{id}','PaketController@destroy')->name('paket.destroy');
    Route::post('paket/simpan', 'PaketController@saveData');
    Route::post('paket/store', 'PaketController@store')->name('paket.store');
    Route::resource('paket','PaketController');

    Route::get('kategori/data', 'KategoriController@listData')->name('kategori.data');
    Route::resource('kategori', 'KategoriController');

    Route::get('katpeng/data', 'KategoriPengeluaranController@listData')->name('katpeng.data');
    Route::resource('katpeng', 'KategoriPengeluaranController');

    Route::get('note/data', 'NoteController@listData')->name('note.data');
    Route::resource('note', 'NoteController');

    Route::get('produk/data', 'ProdukController@listData')->name('produk.data');
    Route::post('produk/hapus', 'ProdukController@deleteSelected');
    Route::post('produk/cetak', 'ProdukController@printBarcode');
    Route::post('produk/ambil', 'ProdukController@ambil');
    Route::get('ambil' ,'ProdukController@ambilindex')->name('ambil.index');
    Route::get('ambil/data' ,'ProdukController@ambildata')->name('ambil.data');
    Route::post('produk/tambah', 'ProdukController@tambah');
    Route::get('tambah' ,'ProdukController@tambahindex')->name('tambah.index');
    Route::get('tambah/data' ,'ProdukController@tambahdata')->name('tambah.data');
    Route::resource('produk', 'ProdukController');

    Route::get('histori_pengambilan' ,'HistoryStokController@ambilindex')->name('histori_pengambilan.index');
    Route::get('histori_pengambilan/data' ,'HistoryStokController@ambildata')->name('histori_pengambilan.data');
    Route::get('histori_penambahan' ,'HistoryStokController@tambahindex')->name('histori_penambahan.index');
    Route::get('histori_penambahan/data' ,'HistoryStokController@tambahdata')->name('histori_penambahan.data');
    Route::get('histori_stokhuba' ,'HistoryStokController@stokhubaindex')->name('histori_stokhuba.index');
    Route::get('histori_stokhuba/data' ,'HistoryStokController@stokhubadata')->name('histori_stokhuba.data');

    Route::get('produkpaket/data', 'ProdukPaketController@listData')->name('produkpaket.data');
    Route::post('produkpaket/hapus', 'ProdukPaketController@deleteSelected');
    Route::post('produkpaket/cetak', 'ProdukPaketController@printBarcode');
    Route::post('produkpaket/ambil', 'ProdukPaketController@ambil');
    Route::get('ambil' ,'ProdukPaketController@ambilindex')->name('ambil.index');
    Route::get('ambil/data' ,'ProdukPaketController@ambildata')->name('ambil.data');
    Route::post('produkpaket/tambah', 'ProdukPaketController@tambah');
    Route::get('tambah' ,'ProdukPaketController@tambahindex')->name('tambah.index');
    Route::get('tambah/data' ,'ProdukPaketController@tambahdata')->name('tambah.data');
    Route::resource('produkpaket', 'ProdukPaketController');

    Route::get('supplier/data', 'SupplierController@listData')->name('supplier.data');
    Route::resource('supplier', 'SupplierController');

    Route::get('member/data', 'MemberController@listData')->name('member.data');
    Route::post('member/cetak', 'MemberController@printCard');
    Route::resource('member', 'MemberController');
    
    Route::get('sales/data', 'SalesController@listData')->name('sales.data');
    Route::post('sales/cetak', 'SalesController@printCard');
    Route::resource('sales', 'SalesController');

    Route::get('member_enduser/data', 'MemberEnduserController@listData')->name('member_enduser.data');
    Route::post('member_enduser/cetak', 'MemberEnduserController@printCard');
    Route::resource('member_enduser', 'MemberEnduserController');

    Route::get('member_distributor/data', 'MemberDistributorController@listData')->name('member_distributor.data');
    Route::post('member_distributor/cetak', 'MemberDistributorController@printCard');
    Route::resource('member_distributor', 'MemberDistributorController');

    Route::get('member_marketing/data', 'MemberMarketingController@listData')->name('member_marketing.data');
    Route::post('member_marketing/cetak', 'MemberMarketingController@printCard');
    Route::resource('member_marketing', 'MemberMarketingController');

    Route::get('member_reseller/data', 'MemberResellerController@listData')->name('member_reseller.data');
    Route::post('member_reseller/cetak', 'MemberResellerController@printCard');
    Route::resource('member_reseller', 'MemberResellerController');

    Route::get('pengeluaran/data', 'PengeluaranController@listData')->name('pengeluaran.data');
    Route::resource('pengeluaran', 'PengeluaranController');

    Route::get('pembelian','PengeluaranController@pembelian')->name('pembelian');
    Route::get('pembelian/data','PengeluaranController@Data')->name('pembelian.data');


    Route::get('user/data', 'UserController@listData')->name('user.data');
    Route::resource('user', 'UserController');

    Route::get('karyawan/data', 'KaryawanController@listData')->name('karyawan.data');
    Route::resource('karyawan', 'KaryawanController');

    // Route::get('pembelian/data', 'PembelianController@listData')->name('pembelian.data');
    // Route::get('pembelian/{id}/tambah', 'PembelianController@create');
    // Route::get('pembelian/{id}/lihat', 'PembelianController@show');
    // Route::resource('pembelian', 'PembelianController');   

    Route::get('pembelian_detail/{id}/data', 'PembelianDetailController@listData')->name('pembelian_detail.data');
    Route::get('pembelian_detail/loadform/{diskon}/{total}', 'PembelianDetailController@loadForm');
    Route::resource('pembelian_detail', 'PembelianDetailController');   

    Route::get('penjualan/{id}/lihat', 'PenjualanController@show');
    // Route::get('penjualan/data', 'PenjualanController@listData')->name('penjualan.data');
    Route::get('penjualan/data/{awal}/{akhir}', 'PenjualanController@listData')->name('laporan.data');
    Route::get('penjualan/dataenduser/{awal}/{akhir}', 'PenjualanController@listEnduserData')->name('laporan.data');
    Route::get('penjualan/datareseller/{awal}/{akhir}', 'PenjualanController@listResellerData')->name('laporan.data');
    Route::get('penjualan/datadistributor/{awal}/{akhir}', 'PenjualanController@listDistributorData')->name('laporan.data');
    Route::get('penjualan/datamarketing/{awal}/{akhir}', 'PenjualanController@listMarketingData')->name('laporan.data');
    Route::get('penjualan/notapdf/{id}', 'PenjualanController@notaPDF')->name('penjualan.pdf');
    Route::get('penjualan/invoicepdf/{id}', 'PenjualanController@invoicePDF')->name('penjualan.invoicepdf');
    Route::get('exportpenjualan/{awal}/{akhir}', [PenjualanController::class, 'export'])->name('exportpenjualan');
    Route::get('exportpenjualanreseller', [PenjualanController::class, 'exportreseller'])->name('exportpenjualanreseller');
    Route::get('exportpenjualandistributor', [PenjualanController::class, 'exportdistributor'])->name('exportpenjualandistributor');
    Route::get('exportpenjualanmarketing', [PenjualanController::class, 'exportmarketing'])->name('exportpenjualanmarketing');
    Route::get('export_excel', 'ProdukController@export_excel')->name('export_excel');;
    Route::get('penjualan/data/day/{awal}/{akhir}', 'PenjualanController@listDataday')->name('laporan.dataday');
    Route::get('penjualan/produk/day/{awal}/{akhir}', 'PenjualanController@listProdukday')->name('laporan.produkday');
    Route::get('penjualan/data/week/{awal}/{akhir}', 'PenjualanController@listDataweek')->name('laporan.dataweek');
    Route::get('penjualan/produk/week/{awal}/{akhir}', 'PenjualanController@listProdukweek')->name('laporan.produkweek');
    Route::get('penjualan/data/month/{awal}/{akhir}', 'PenjualanController@listDatamonth')->name('laporan.datamonth');
    Route::get('penjualan/produk/month/{awal}/{akhir}', 'PenjualanController@listProdukmonth')->name('laporan.produkmonth');
    Route::get('penjualan/data/year/{awal}/{akhir}', 'PenjualanController@listDatayear')->name('laporan.datayear');
    Route::get('penjualan/produk/year/{awal}/{akhir}', 'PenjualanController@listProdukyear')->name('laporan.produkyear');
    Route::post('penjualanrefresh', 'PenjualanController@refresh')->name('penjualan.refresh'); 
    Route::get('penjualan/{id}/bayar', 'PenjualanController@bayar')->name('laporan.data');
    Route::post('penjualan/bayarupdate', 'PenjualanController@bayarupdate');
    Route::resource('penjualan', 'PenjualanController');
    
    Route::get('retur/{id}/lihat', 'ReturController@show');
    Route::get('retur/data/{awal}/{akhir}', 'ReturController@listData')->name('laporan.data');
    Route::get('retur/datamarketing/{awal}/{akhir}', 'ReturController@listMarketingData')->name('laporan.data');
    Route::post('returrefresh', 'ReturController@refresh')->name('retur.refresh'); 
    Route::get('retur/{id}/retur', 'ReturController@retur')->name('laporan.data');
    
    Route::resource('retur', 'ReturController');

    Route::get('order/{id}/lihat', 'OrderController@show');
    // Route::get('order/data', 'OrderController@listData')->name('order.data');
    Route::get('order/data/{awal}/{akhir}', 'OrderController@listData')->name('laporan.data');
    Route::get('order/dataenduser/{awal}/{akhir}', 'OrderController@listEnduserData')->name('laporan.data');
    Route::get('order/datareseller/{awal}/{akhir}', 'OrderController@listResellerData')->name('laporan.data');
    Route::get('order/datadistributor/{awal}/{akhir}', 'OrderController@listDistributorData')->name('laporan.data');
    Route::get('order/datamarketing/{awal}/{akhir}', 'OrderController@listMarketingData')->name('laporan.data');
    Route::get('order/notapdf/{id}', 'OrderController@notaPDF')->name('order.pdf');
    Route::get('exportorder', [OrderController::class, 'export'])->name('exportorder');
    Route::get('exportorderreseller', [OrderController::class, 'exportreseller'])->name('exportorderreseller');
    Route::get('exportorderdistributor', [OrderController::class, 'exportdistributor'])->name('exportorderdistributor');
    Route::get('exportordermarketing', [OrderController::class, 'exportmarketing'])->name('exportordermarketing');
    Route::get('export_excel', 'ProdukController@export_excel')->name('export_excel');;
    Route::get('order/data/day/{awal}/{akhir}', 'OrderController@listDataday')->name('laporan.dataday');
    Route::get('order/produk/day/{awal}/{akhir}', 'OrderController@listProdukday')->name('laporan.produkday');
    Route::get('order/data/week/{awal}/{akhir}', 'OrderController@listDataweek')->name('laporan.dataweek');
    Route::get('order/produk/week/{awal}/{akhir}', 'OrderController@listProdukweek')->name('laporan.produkweek');
    Route::get('order/data/month/{awal}/{akhir}', 'OrderController@listDatamonth')->name('laporan.datamonth');
    Route::get('order/produk/month/{awal}/{akhir}', 'OrderController@listProdukmonth')->name('laporan.produkmonth');
    Route::get('order/data/year/{awal}/{akhir}', 'OrderController@listDatayear')->name('laporan.datayear');
    Route::get('order/produk/year/{awal}/{akhir}', 'OrderController@listProdukyear')->name('laporan.produkyear');
    Route::post('orderrefresh', 'OrderController@refresh')->name('order.refresh'); 
    Route::get('order/{id}/bayar', 'OrderController@bayar')->name('laporan.data');
    Route::post('order/bayarupdate', 'OrderController@bayarupdate');
    Route::resource('order', 'OrderController');

    Route::get('piutang/{id}/lihat', 'PiutangController@show');
    // Route::get('piutang/data', 'PiutangController@listData')->name('piutang.data');
    Route::get('piutang/data/{awal}/{akhir}', 'PiutangController@listData')->name('laporan.data');
    Route::get('piutang/dataenduser/{awal}/{akhir}', 'PiutangController@listEnduserData')->name('laporan.data');
    Route::get('piutang/datareseller/{awal}/{akhir}', 'PiutangController@listResellerData')->name('laporan.data');
    Route::get('piutang/datadistributor/{awal}/{akhir}', 'PiutangController@listDistributorData')->name('laporan.data');
    Route::get('piutang/datamarketing/{awal}/{akhir}', 'PiutangController@listMarketingData')->name('laporan.data');
    Route::get('piutang/notapdf/{id}', 'PiutangController@notaPDF')->name('piutang.pdf');
     Route::get('piutang/invoicepdf/{id}', 'PiutangController@invoicePDF')->name('piutang.invoicepdf');
    Route::get('exportpiutang', [PiutangController::class, 'export'])->name('exportpiutang');
    Route::get('exportpiutangreseller', [PiutangController::class, 'exportreseller'])->name('exportpiutangreseller');
    Route::get('exportpiutangdistributor', [PiutangController::class, 'exportdistributor'])->name('exportpiutangdistributor');
    Route::get('exportpiutangmarketing', [PiutangController::class, 'exportmarketing'])->name('exportpiutangmarketing');
    Route::get('export_excel', 'ProdukController@export_excel')->name('export_excel');;
    Route::get('piutang/data/day/{awal}/{akhir}', 'PiutangController@listDataday')->name('laporan.dataday');
    Route::get('piutang/produk/day/{awal}/{akhir}', 'PiutangController@listProdukday')->name('laporan.produkday');
    Route::get('piutang/data/week/{awal}/{akhir}', 'PiutangController@listDataweek')->name('laporan.dataweek');
    Route::get('piutang/produk/week/{awal}/{akhir}', 'PiutangController@listProdukweek')->name('laporan.produkweek');
    Route::get('piutang/data/month/{awal}/{akhir}', 'PiutangController@listDatamonth')->name('laporan.datamonth');
    Route::get('piutang/produk/month/{awal}/{akhir}', 'PiutangController@listProdukmonth')->name('laporan.produkmonth');
    Route::get('piutang/data/year/{awal}/{akhir}', 'PiutangController@listDatayear')->name('laporan.datayear');
    Route::get('piutang/produk/year/{awal}/{akhir}', 'PiutangController@listProdukyear')->name('laporan.produkyear');
    Route::post('piutangrefresh', 'PiutangController@refresh')->name('piutang.refresh'); 
    Route::get('piutang/{id}/bayar', 'PiutangController@bayar')->name('laporan.data');
    Route::post('piutang/bayarupdate', 'PiutangController@bayarupdate');
    Route::resource('piutang', 'PiutangController');




    Route::resource('penjualan_deal', 'PenjualanDealController');

    Route::get('laporan', 'LaporanController@index')->name('laporan.index');
    Route::post('laporan', 'LaporanController@refresh')->name('laporan.refresh');
    Route::get('laporan/data/{awal}/{akhir}', 'LaporanController@listData')->name('laporan.data'); 
    Route::get('laporan/data/week/{awal}/{akhir}', 'LaporanController@listDataweek')->name('laporan.dataweek'); 
    Route::get('laporan/data/month/{awal}/{akhir}', 'LaporanController@listDatamonth')->name('laporan.datamonth'); 
    Route::get('laporan/data/year/{awal}/{akhir}', 'LaporanController@listDatayear')->name('laporan.datayear'); 
    Route::get('laporan/pdf/{awal}/{akhir}', 'LaporanController@exportPDF');

    Route::resource('setting', 'SettingController');
    Route::resource('note', 'NoteController');
});

// Route::group(['middleware' => ['web', 'cekuser:1' ]], function(){
//     Route::get('kategori/data', 'KategoriController@listData')->name('kategori.data');
//     Route::resource('kategori', 'KategoriController');

//     Route::get('katpeng/data', 'KategoriPengeluaranController@listData')->name('katpeng.data');
//     Route::resource('katpeng', 'KategoriPengeluaranController');

//     Route::get('produk/data', 'ProdukController@listData')->name('produk.data');
//     Route::post('produk/hapus', 'ProdukController@deleteSelected');
//     Route::post('produk/cetak', 'ProdukController@printBarcode');
//     Route::resource('produk', 'ProdukController');

//     Route::get('supplier/data', 'SupplierController@listData')->name('supplier.data');
//     Route::resource('supplier', 'SupplierController');

//     Route::get('member/data', 'MemberController@listData')->name('member.data');
//     Route::post('member/cetak', 'MemberController@printCard');
//     Route::resource('member', 'MemberController');

//     Route::get('pengeluaran/data', 'PengeluaranController@listData')->name('pengeluaran.data');
//     Route::resource('pengeluaran', 'PengeluaranController');


//     Route::get('user/data', 'UserController@listData')->name('user.data');
//     Route::resource('user', 'UserController');

//     Route::get('karyawan/data', 'KaryawanController@listData')->name('karyawan.data');
//     Route::resource('karyawan', 'KaryawanController');

//     Route::get('pembelian/data', 'PembelianController@listData')->name('pembelian.data');
//     Route::get('pembelian/{id}/tambah', 'PembelianController@create');
//     Route::get('pembelian/{id}/lihat', 'PembelianController@show');
//     Route::resource('pembelian', 'PembelianController');   

//     Route::get('pembelian_detail/{id}/data', 'PembelianDetailController@listData')->name('pembelian_detail.data');
//     Route::get('pembelian_detail/loadform/{diskon}/{total}', 'PembelianDetailController@loadForm');
//     Route::resource('pembelian_detail', 'PembelianDetailController');   

//     Route::get('penjualan/{id}/lihat', 'PenjualanController@show');
//     Route::get('penjualan/data', 'PenjualanController@listData')->name('penjualan.data');
   
//     Route::resource('penjualan', 'PenjualanController');

//     Route::get('laporan', 'LaporanController@index')->name('laporan.index');
//     Route::post('laporan', 'LaporanController@refresh')->name('laporan.refresh');
//     Route::get('laporan/data/{awal}/{akhir}', 'LaporanController@listData')->name('laporan.data'); 
//     Route::get('laporan/pdf/{awal}/{akhir}', 'LaporanController@exportPDF');

//     Route::resource('setting', 'SettingController');
// });

