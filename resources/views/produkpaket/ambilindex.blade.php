@extends('layouts.app')

@section('title')
  Laporan Pengambilan Barang Dagangan
@endsection

@section('breadcrumb')
   @parent
   <li>produkpaket</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
      </div>
      <div class="box-body">  

<form method="post" id="form-produkpaket">
{{ csrf_field() }}
<div class="table-responsive">
<table class="table table-striped">
<thead>
   <tr>
      <th width="20">No</th>
      <th>Nama ProdukPaket</th>
      <th>Ambil</th>
      <th>Keterangan</th>
      <th>User</th>
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

@endsection

@section('script')
<script type="text/javascript">
var table, save_method;
$(function(){
   table = $('.table').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "{{ route('ambil.data') }}",
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
         if(save_method == "add") url = "{{ route('produkpaket.store') }}";
         else url = "produkpaket/"+id;
         
         $.ajax({
           url : url,
           type : "POST",
           data : $('#modal-form form').serialize(),
           dataType: 'JSON',
           success : function(data){
             if(data.msg=="error"){
                alert('Kode produkpaket sudah digunakan!');
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
   $('.modal-title').text('Tambah ProdukPaket');
   $('#kode').attr('readonly', false);
}
function ambil(){
  $('#modal-ambil').modal('show');
}

function editForm(id){
   save_method = "edit";
   $('input[name=_method]').val('PATCH');
   $('#modal-form form')[0].reset();
   $.ajax({
     url : "produkpaket/"+id+"/edit",
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-form').modal('show');
        // $('.modal-title').text('Edit ProdukPaket');
        
       $('#id').val(data.id_produkpaket);
       $('#kode').val(data.kode_produkpaket).attr('readonly', true);
       $('#nama').val(data.nama_produkpaket);
       $('#kategori').val(data.id_kategori);
       $('#merk').val(data.merk);
       $('#harga_beli').val(data.harga_beli);
       $('#diskon').val(data.diskon);
       $('#harga_jual').val(data.harga_jual);
       $('#stok').val(data.stok);
       
     },
     error : function(){
       alert("Tidak dapat menampilkan data!");
     }
   });
}

function deleteData(id){
  if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "produkpaket/"+id,
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

function deleteAll(){
  if($('input:checked').length < 1){
    alert('Pilih data yang akan dihapus!');
  }else if(confirm("Apakah yakin akan menghapus semua data terpilih?")){
     $.ajax({
       url : "produkpaket/hapus",
       type : "POST",
       data : $('#form-produkpaket').serialize(),
       success : function(data){
         table.ajax.reload();
       },
       error : function(){
         alert("Tidak dapat menghapus data!");
       }
     });
   }
}

function printBarcode(){
  if($('input:checked').length < 1){
    alert('Pilih data yang akan dicetak!');
  }else{
    $('#form-produkpaket').attr('target', '_blank').attr('action', "produkpaket/cetak").submit();
  }
}
$(function(){
   $('#tanggal').datepicker({
     format: 'yyyy-mm-dd',
     autoclose: true
   });

});
</script>
@endsection