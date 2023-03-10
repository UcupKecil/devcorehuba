@extends('layouts.app')

@section('title')
  Daftar Belanja
@endsection

@section('breadcrumb')
   @parent
   <li>belanja</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>
      </div>
      <div class="box-body">  
<div class="table-responsive">
<table class="table table-striped">
<thead>
   <tr>
      <th width="30">No</th>
      <th>Tanggal</th>
      <th>Kategori Belanja</th>
      <th>Keterangan</th>
      <th>No Kuitansi</th>
      <th>Nominal</th>
      <th>Pembayaran</th>
      <th width="100">Aksi</th>
   </tr>
</thead>
<tbody></tbody>
</table>
</div>

      </div>
    </div>
  </div>
</div>

@include('pengeluaran.form')
@endsection

@section('script')
<script type="text/javascript">
var table, save_method;
$(function(){
   $('#awal').datepicker({
     format: 'yyyy-mm-dd',
     autoclose: true
   });

});
$(function(){
   table = $('.table').DataTable({
     "processing" : true,
     "ajax" : {
       "url" : "{{ route('pengeluaran.data') }}",
       "type" : "GET"
     }
   }); 
   
   $('#modal-form form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
         var id = $('#id').val();
         if(save_method == "add") url = "{{ route('pengeluaran.store') }}";
         else url = "pengeluaran/"+id;
         
         $.ajax({
           url : url,
           type : "POST",
           data : $('#modal-form form').serialize(),
           success : function(data){
             $('#modal-form').modal('hide');
             table.ajax.reload();
           },
           error : function(){
             alert("Tidak dapat menyimpan data!");
           }   
         });
         return false;
     }
   });
});

function addForm(){
   save_method = "add";
   $('input[name=_method]').val('POST');
   $('#modal-form').modal('show');
   $('#modal-form form')[0].reset();            
   $('.modal-title').text('Tambah Belanja');
}

function editForm(id){
   save_method = "edit";
   $('input[name=_method]').val('PATCH');
   $('#modal-form form')[0].reset();
   $.ajax({
     url : "pengeluaran/"+id+"/edit",
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-form').modal('show');
       $('.modal-title').text('Edit Belanja');
       
       $('#id').val(data.id_pengeluaran);
       $('#kuitansi').val(data.nokuitansi);
       $('#jenis').val(data.jenis_pengeluaran);
       $('#nominal').val(data.nominal);
       $('#pembayaran').val(data.jenis_pembayaran);
       
     },
     error : function(){
       alert("Tidak dapat menampilkan data!");
     }
   });
}

function deleteData(id){
   if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "pengeluaran/"+id,
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

</script>
@endsection