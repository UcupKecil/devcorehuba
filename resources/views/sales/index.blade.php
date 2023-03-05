@extends('layouts.app')

@section('title')
  Daftar Sales Reseller
@endsection

@section('breadcrumb')
   @parent
   <li>Sales Reseller</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>
        <!-- <a onclick="printCard()" class="btn btn-info"><i class="fa fa-credit-card"></i> Cetak Kartu</a> -->
      </div>
      <div class="box-body"> 

<form method="post" id="form-sales">
{{ csrf_field() }}
<div class="table-responsive">
<table class="table table-striped">
<thead>
   <tr>
      <th width="20"><input type="checkbox" value="1" id="select-all"></th>
      <th width="20">No</th>
     
      <th>Nama Sales</th>
      <th>Alamat</th>
      <th>Wa</th>
   
      <th width="100">Aksi</th>
   </tr>
</thead>
<tbody></tbody>
</table>
</div>
</form>

      </div>
    </div>
  </div>
</div>

@include('sales.form')
@endsection

@section('script')
<script type="text/javascript">
var table, save_method;
$(function(){
   table = $('.table').DataTable({
     "processing" : true,
     "ajax" : {
       "url" : "{{ route('sales.data') }}",
       "type" : "GET"
     },
     'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false
      }],
      'order': [1, 'asc']
   }); 

   $('#select-all').click(function(){
      $('input[type="checkbox"]').prop('checked', this.checked);
   });
   
   $('#modal-form form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
         var id = $('#id').val();
         if(save_method == "add") url = "{{ route('sales.store') }}";
         else url = "sales/"+id;
         
         $.ajax({
           url : url,
           type : "POST",
           data : $('#modal-form form').serialize(),
           dataType: 'JSON',
           success : function(data){
            if(data.msg=="error"){
              alert('Kode sales sudah digunakan!');
              $('#kode').focus().select();
            }else{
              $('#modal-form').modal('hide');
              table.ajax.reload();
            }
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
   $('.modal-title').text('Tambah Sales Reseller');
   $('#kode').attr('readonly', false);
}

function editForm(id){
   save_method = "edit";
   $('input[name=_method]').val('PATCH');
   $('#modal-form form')[0].reset();
   $.ajax({
     url : "sales/"+id+"/edit",
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-form').modal('show');
       $('.modal-title').text('Edit Sales Reseller');
       
       $('#id').val(data.id_sales);
       $('#kode').val(data.kode_sales).attr('readonly', true);
       $('#nama').val(data.nama);
       $('#alamat').val(data.alamat);
       $('#telpon').val(data.telpon);
       $('#tempat_lahir').val(data.tempat_lahir);
       $('#tanggal_lahir').val(data.tanggal_lahir);
       $('#motivasi').val(data.motivasi);
       $('#medsos').val(data.medsos);
       
       
     },
     error : function(){
       alert("Tidak dapat menampilkan data!");
     }
   });
}

function deleteData(id){
   if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "sales/"+id,
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
$(function(){
   $('#tanggal_lahir').datepicker({
     format: 'yyyy-mm-dd',
     autoclose: true
   });

});

function printCard(){
  if($('input:checked').length < 1){
    alert('Pilih data yang akan dicetak!');
  }else{
    $('#form-sales').attr('target', '_blank').attr('action', "sales/cetak").submit();
  }
}
</script>
@endsection