@extends('layouts.app')

@section('title')
  Order Masuk {{ tanggal_indonesia($awal, false) }} s/d {{ tanggal_indonesia($akhir, false) }}
@endsection

@section('breadcrumb')
   @parent
   <li>order</li>
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
         
        </ul>
        @if($errors->any())
        <div style="background: #dd4b39; color: #fff; font-size: 27px; padding: 10px"><h4><b>{{$errors->first()}}</b></h4></div>
        @endif
        <br></br>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
          <div class="table-responsive">
            <table class="table table-striped tabel-penjualan">
              <thead>
                <tr>
                    <th width="30">No</th>
                   
                    <th>Tanggal</th>
                    <th>Nama Konsumen</th>
                    <th>No Hp</th>
                    <th>Alamat Kirim</th>
                    <th>Jasa Kirim</th>
                    <th>Ongkir</th>                
                    <th>Total Penjualan</th>
                    <th>Kasir</th>
                   
                    <th width="20">Aksi</th>
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
@include('order.detail')
@include('order.form')
@include('order.bayar')
@endsection

@section('script')
<script type="text/javascript">
var table,table2, save_method, table1,table_enduser,table_reseller,table_distributor,table_marketing;
$(function(){
   table2 = $('.tabel-penjualan').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "order/data/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     },
     'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false
      }],
      'order': [0, 'desc']
   }); 

   table_enduser = $('.tabel-penjualan-enduser').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "order/dataenduser/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     },
     'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false
      }],
      'order': [0, 'desc']
   });

   $('#modal-bayar form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
         var id = $('#id').val();
         if(save_method == "add") url = "{{ route('order.store') }}";
         else url = "order/"+id;
         
         $.ajax({
           url : url,
           type : "POST",
           data : $('#modal-bayar form').serialize(),
           success : function(data){
             $('#modal-bayar').modal('hide');
             table2.ajax.reload();
             table_enduser.ajax.reload();
             table_reseller.ajax.reload();
             table_marrketing.ajax.reload();
             table_distributor.ajax.reload();
           },
           error : function(){
             alert("Tidak dapat menyimpan data!");
           }   
         });
         return false;
     }
   });

   table_reseller = $('.tabel-penjualan-reseller').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "order/datareseller/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     },
     'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false
      }],
      'order': [0, 'desc']
   }); 

   table_distributor = $('.tabel-penjualan-distributor').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "order/datadistributor/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     },
     'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false
      }],
      'order': [0, 'desc']
   }); 

   table_marketing = $('.tabel-penjualan-marketing').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "order/datamarketing/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     },
     'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false
      }],
      'order': [0, 'desc']
   }); 

   table = $('.tabel-harian').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "order/data/day/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
    
   });
   table = $('.tabel-produkharian').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "order/produk/day/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   });
   table = $('.tabel-week').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "order/data/week/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   });
   table = $('.tabel-produkweek').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "order/produk/week/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   });
   table = $('.tabel-month').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "order/data/month/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   });
   table = $('.tabel-produkmonth').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "order/produk/month/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   });
   table = $('.tabel-year').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "order/data/year/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   });
   table = $('.tabel-produkyear').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "order/produk/year/{{ $awal }}/{{ $akhir }}",
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

    table1.ajax.url("order/"+id+"/lihat");
    table1.ajax.reload();
  
}



function deleteData(id){
   if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "order/"+id,
       type : "POST",
       data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
       success : function(data){
         table2.ajax.reload();
       },
       error : function(){
         alert("Tidak dapat menghapus data!");
       }
     });
   }
}

function tampilNota(id){
  var url = '{{ route("order.pdf", ":id") }}';

url = url.replace(':id', id);

window.location.href=url;
                
              }  


             

var table2, awal, akhir;
$(function(){
   $('#awal, #akhir').datepicker({
     format: 'yyyy-mm-dd',
     autoclose: true
   });

   

});
   



function periodeForm(){
   $('#modal-form').modal('show');        
}

function bayar(id){
   save_method = "bayar";
   $('input[name=_method]').val('PATCH');
   
   $.ajax({
     url : "order/"+id+"/bayar",
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-bayar').modal('show');
        // $('.modal-title').text('Edit Produk');
        
       $('#id').val(data.id_penjualan);
       $('#notransaksi').val(data.notransaksi).attr('readonly', true);
       $('#nama').val(data.nama).attr('readonly', true);
       $('#bayar').val(data.bayar).attr('readonly', true);
       $('#diterima').val(data.diterima);
       
       
     },
     error : function(){
       alert("Tidak dapat menampilkan data!");
     }
   });
}



</script>
@endsection