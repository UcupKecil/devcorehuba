@extends('layouts.app')

@section('title')
  Laporan Penjualan {{ tanggal_indonesia($awal, false) }} s/d {{ tanggal_indonesia($akhir, false) }}
@endsection

@section('breadcrumb')
   @parent
   <li>penjualan</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <a onclick="periodeForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i> Periode Tanggal</a>
      </div>
      <div class="box-body">  
        <ul class="nav nav-pills ml-auto p-2" >
          <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Transaksi</a></li>
          <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Harian</a></li>
          <!-- <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Mingguan</a></li> -->
          <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Bulanan</a></li>
          <li class="nav-item"><a class="nav-link" href="#tab_4" data-toggle="tab">Tahunan</a></li>
        </ul>
        @if($errors->any())
        <div style="background: #dd4b39; color: #fff; font-size: 27px; padding: 10px"><h4><b>{{$errors->first()}}</b></h4></div>
        @endif
        <br></br>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            <table class="table table-striped tabel-penjualan">
              <thead>
                <tr>
                    <th width="30">No</th>
                    <th>No Transaksi</th>
                    <th>Tanggal</th>
                    <th>Nama Member</th>
                    <th>No Telepon Member</th>
                    <!-- <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Diskon</th> -->
                    <th>Total Penjualan</th>
                    <th>Kasir</th>
                    <th width="100">Aksi</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab_2">
            <h1>Tabel transaksi harian</h1>
            <table class="table table-striped tabel-harian">
              <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Tanggal</th>
                    <th>Total Transaksi</th>
                    <th>Total Bayar</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            <h1>Tabel produk harian</h1>
            <table class="table table-striped tabel-produkharian">
              <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Tanggal</th>
                    <th>Nama Produk</th>
                    <th>Total Item</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <!-- /.tab-pane --
          <div class="tab-pane" id="tab_3">
            <h1>Tabel transaksi mingguan</h1>
            <table class="table table-striped tabel-week">
              <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Minggu ke -</th>
                    <th>Total Transaksi</th>
                    <th>Total Bayar</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            <h1>Tabel produk mingguan</h1>
            <table class="table table-striped tabel-produkweek">
              <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Minggu ke -</th>
                    <th>Nama Produk</th>
                    <th>Total Item</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab_3">
            <h1>Tabel transaksi bulanan</h1>
            <table class="table table-striped tabel-month">
              <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Bulan</th>
                    <th>Total Transaksi</th>
                    <th>Total Bayar</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            <h1>Tabel produk bulanan</h1>
            <table class="table table-striped tabel-produkmonth">
              <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Bulan</th>
                    <th>Nama Produk</th>
                    <th>Total Item</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab_4">
            <h1>Tabel transaksi tahunan</h1>
            <table class="table table-striped tabel-year">
              <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Tahun</th>
                    <th>Total Transaksi</th>
                    <th>Total Bayar</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            <h1>Tabel produk tahunan</h1>
            <table class="table table-striped tabel-produkyear">
              <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Tahun</th>
                    <th>Nama Produk</th>
                    <th>Total Item</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <!-- /.tab-pane -->
        </div>
      </div>
    </div>
  </div>
</div>
@include('penjualan.detail')
@include('penjualan.form')

@endsection

@section('script')
<script type="text/javascript">
var table, save_method, table1;
$(function(){
   table = $('.tabel-penjualan').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "penjualan/data/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   }); 

   table = $('.tabel-harian').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "penjualan/data/day/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   });
   table = $('.tabel-produkharian').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "penjualan/produk/day/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   });
   table = $('.tabel-week').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "penjualan/data/week/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   });
   table = $('.tabel-produkweek').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "penjualan/produk/week/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   });
   table = $('.tabel-month').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "penjualan/data/month/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   });
   table = $('.tabel-produkmonth').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "penjualan/produk/month/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   });
   table = $('.tabel-year').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "penjualan/data/year/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   });
   table = $('.tabel-produkyear').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "penjualan/produk/year/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   });
   table1 = $('.tabel-detail').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "processing" : true
    });

   $('.tabel-supplier').DataTable();
});


function addForm(){
   $('#modal-supplier').modal('show');        
}

function showDetail(id){
    $('#modal-detail').modal('show');

    table1.ajax.url("penjualan/"+id+"/lihat");
    table1.ajax.reload();
  //   table2 = $('.tabel-detail').DataTable({
  //    "processing" : true,
  //    "serverside" : true,
  //    "ajax" : {
  //      "url" : "penjualan/"+id+"/lihat",
  //      "type" : "GET"
  //    }
  //  });
}

function deleteData(id){
   if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "penjualan/"+id,
       type : "POST",
       data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
       success : function(data){
         table.ajax.reload();
       },
       error : function(){
         alert("Tidak dapat menghapus data!");
       }
     });
   }
}

var table, awal, akhir;
$(function(){
   $('#awal, #akhir').datepicker({
     format: 'yyyy-mm-dd',
     autoclose: true
   });

});
//    table = $('.tabel-penjualan').DataTable({
//      "dom" : 'Brt',
//      "bSort" : false,
//      "bPaginate" : false,
//      "processing" : true,
//      "serverside" : true,
//      "ajax" : {
//        "url" : "penjualan/data/{{ $awal }}/{{ $akhir }}",
//        "type" : "GET"
//      }
//    }); 

// });

function periodeForm(){
   $('#modal-form').modal('show');        
}

</script>
@endsection