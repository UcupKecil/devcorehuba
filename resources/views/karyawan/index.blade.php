@extends('layouts.app')

@section('title')
  Daftar Karyawan
@endsection

@section('breadcrumb')
   @parent
   <li>karyawan</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah karyawan</a>
      </div>
      <div class="box-body">  
<div class="table-responsive">
<table class="table table-striped">
<thead>
   <tr>
      <th width="30">No</th>
      <th>NIP</th>
      <th>Nama Karyawan</th>
      <th>Email</th>
      <th>No KTP</th>
      <th>Alamat</th>
      <th>Foto</th>
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

@include('karyawan.form')
@include('karyawan.edit')
@endsection

@section('script')
<script type="text/javascript">
var table, save_method;
$(function(){
   table = $('.table').DataTable({
     "processing" : true,
     "ajax" : {
       "url" : "{{ route('karyawan.data') }}",
       "type" : "GET"
     }
   }); 
   
   $('#modal-form form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
         var id = $('#id').val();
         if(save_method == "add") url = "karyawan/"+id; 
         else url = "{{ route('karyawan.store') }}";
         
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
   save_method = "store";
   $('input[name=_method]').val('POST');
   $('#modal-edit').modal('show');
   $('#modal-edit form')[0].reset();            
   $('.modal-title').text('Tambah Karyawan');
}

function editForm(id){
   save_method = "update";
   $('input[name=_method]').val('post');
   $('#modal-edit form')[0].reset();
   $.ajax({
     url : "karyawan/"+id+"/edit",
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-edit').modal('show');
       $('.modal-title').text('Edit karyawan');
       
       $('#id').val(data.id);
       $('#NIP').val(data.NIP);
       $('#NoKTP').val(data.NoKTP);
       $('#alamat').val(data.alamat);
       $('#nama').val(data.nama);
       $('#email').val(data.email);    
     },
     error : function(){
       alert("Tidak dapat menampilkan data!");
     }
   });
}

function deleteData(id){
   if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "karyawan/"+id,
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