@extends('layouts.app')

@section('title')
  Update Retur Partner {{ tanggal_indonesia($awal, false) }} s/d {{ tanggal_indonesia($akhir, false) }}
@endsection

@section('breadcrumb')
   @parent
   <li>retur</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <a onclick="periodeForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i> Periode Tanggal</a>
        
       
       
        
      </div>
      
                  
      <div class="box-body">  
      
        @if($errors->any())
        <div style="background: #dd4b39; color: #fff; font-size: 27px; padding: 10px"><h4><b>{{$errors->first()}}</b></h4></div>
        @endif
        <br></br>
        <div class="tab-content">
          
          
          

          <!-- /.tab-pane -->
          <div class="tab-pane active" id="tab_marketing">
          <div class="table-responsive">
            <table class="table table-striped tabel-penjualan-marketing">
              <thead>
                <tr>
                    <th width="30">No</th>
               
                    <th>Tanggal</th>
                    <th>Nama Toko</th>
                    <th>Alamat Kirim</th>
                    <th>Jasa Kirim</th>
                    <th>Kode Order</th>
                    <th>Qty Awal</th>
                    <th>Qty Retur</th>
                    <th>Qty Sold</th>
                          
                    <th>Total Penjualan</th>
                    <th>Kasir</th>
                    <th>Retur</th>
                 
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          </div>
          <!-- /.tab-pane -->

          
         
          
          <!-- /.tab-pane -->
        </div>
      </div>
    </div>
  </div>
</div>
@include('retur.detail')
@include('retur.form')
@include('retur.retur')
@endsection

@section('script')
<script type="text/javascript">
var table,table2, save_method, table1,table_enduser,table_marketing;
$(function(){
    table_marketing = $('.tabel-penjualan-marketing').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "retur/datamarketing/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     },
     'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false
      }],
      'order': [0, 'desc']
   }); 
   

   

   

   $('#modal-retur form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
         var id = $('#idretur').val();
         if(save_method == "add") url = "{{ route('retur.store') }}";
         else url = "retur/"+id;
         
         $.ajax({
           url : url,
           type : "POST",
           data : $('#modal-retur form').serialize(),
           success : function(data){
             $('#modal-retur').modal('hide');
             table_marketing.ajax.reload();
            
            
           },
           error : function(){
             alert("Tidak dapat menyimpan data!");
           }   
         });
         return false;
     }
   });

   

   

   
   
   
   
 
   
   
   table1 = $('.tabel-detail').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "processing" : true
    });

   $('.tabel-supplier').DataTable();
});




function showDetail(id){
    $('#modal-detail').modal('show');

    table1.ajax.url("retur/"+id+"/lihat");
    table1.ajax.reload();
  
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



function retur(id){
   save_method = "retur";
   $('input[name=_method]').val('PATCH');
   
   $.ajax({
     url : "retur/"+id+"/retur",
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-retur').modal('show');
        // $('.modal-title').text('Edit Produk');
     
       

        

		
        
       $('#idretur').val(data.id_penjualan);
       $('#notransaksiretur').val(data.notransaksi).attr('readonly', true);
       $('#namaretur').val(data.nama).attr('readonly', true);
       $('#namaproduk').val(data.nama_produk).attr('readonly', true);
       $('#jumlah_awal').val(data.jumlah_awal).attr('readonly', true);
       $('#sub_total_awal').val(data.sub_total_awal).attr('readonly', true);
       harga_pcs= data.sub_total_awal / data.jumlah_awal;
       
       $('#harga_pcs').val(harga_pcs).attr('readonly', true);
       $('#jumlah_sold').val(data.jumlah).attr('readonly', true);
       $('#sub_total_sold').val(data.sub_total).attr('readonly', true);
       $('#sub_total_retur').val(data.sub_total_retur).attr('readonly', true);
    
       $('#diterimaretur').val(data.qty_retur);
       

       
       
       
     },
     error : function(){
       alert("Tidak dapat menampilkan data!");
     }
   });
}

function hitungPcsSold() {
  harga_pcs = parseInt(myform.harga_pcs.value);
        jumlah_awal = parseInt(myform.jumlah_awal.value);
		    //jumlah_sold = parseInt(myform.jumlah_sold.value);
        //sub_total_sold = parseInt(myform.sub_total_sold.value);
        retur = parseInt(myform.diterimaretur.value);
        jumlah_sold = jumlah_awal - retur;
        sub_total_sold = harga_pcs * jumlah_sold;
        sub_total_retur = harga_pcs * retur;
        myform.jumlah_sold.value = jumlah_sold;
        myform.sub_total_sold.value = sub_total_sold;
        myform.sub_total_retur.value = sub_total_retur;

}



</script>
@endsection