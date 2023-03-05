@extends('layouts.app')

@section('title')
  Cashflow {{ tanggal_indonesia($awal, false) }} s/d {{ tanggal_indonesia($akhir, false) }}
@endsection

@section('breadcrumb')
   @parent
   <li>laporan</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <a onclick="periodeForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i> Ubah Periode</a>
        <a href="laporan/pdf/{{$awal}}/{{$akhir}}" target="_blank" class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
      </div>
      <div class="box-body">  
        <ul class="nav nav-pills ml-auto p-2">
          <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Harian</a></li>
          <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Mingguan</a></li>
          <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Bulanan</a></li>
          <li class="nav-item"><a class="nav-link" href="#tab_4" data-toggle="tab">Tahunan</a></li>
        </ul>
        <br></br>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
          <div class="table-responsive">
            <table class="table table-striped tabel-laporan">
              <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Tanggal</th>
                    <th>Penjualan</th>
                    <th>Belanja</th>
                 
                    <th>Kas</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            </div>
          </div>
          
          <div class="tab-pane" id="tab_2">
          <div class="table-responsive">
            <table class="table table-striped tabel-week">
              <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Minggu ke </th>
                    <th>Penjualan</th>
                   
                    <th>Belanja</th>
                    <th>Kas</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          </div>
          <!-- /.tab-pane -->
          
          <div class="tab-pane" id="tab_3">
          <div class="table-responsive">
            <table class="table table-striped tabel-month">
              <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Bulan</th>
                    <th>Penjualan</th>
                  
                    <th>Belanja</th>
                    <th>Kas</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            </div>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab_4">
          <div class="table-responsive">
          <table class="table table-striped tabel-year">
              <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Tahun</th>
                    <th>Penjualan</th>
                 
                    <th>Belanja</th>
                    <th>Kas</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
        </div>
          </div>
          <!-- /.tab-pane -->
        </div>
      </div>
    </div>
  </div>
</div>

@include('laporan.form')
@endsection

@section('script')
<script type="text/javascript">
var table, awal, akhir;
$(function(){
   $('#awal, #akhir').datepicker({
     format: 'yyyy-mm-dd',
     autoclose: true
   });

   table = $('.tabel-laporan').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "bPaginate" : false,
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "laporan/data/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   }); 

   table = $('.tabel-week').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "bPaginate" : false,
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "laporan/data/week/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   }); 

   table = $('.tabel-month').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "bPaginate" : false,
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "laporan/data/month/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   }); 

   table = $('.tabel-year').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "bPaginate" : false,
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "laporan/data/year/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   });

});

function periodeForm(){
   $('#modal-form').modal('show');        
}

</script>
@endsection