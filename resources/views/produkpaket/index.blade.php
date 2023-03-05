@extends('layouts.app')

@section('title')
  Daftar Paket Huba
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
        <a href="{{ route('paket.new') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>
        <a onclick="deleteAll()" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
        <a onclick="ambil()" class="btn btn-warning"><i class="fa fa-minus-circle"></i>Pengambilan Paket Huba</a>
        <a onclick="tambah()" class="btn btn-info"><i class="fa fa-plus-circle"></i>Penambahan Paket Huba</a>
      </div>
      <div class="box-body">  

<form method="post" id="form-produkpaket">
{{ csrf_field() }}
<div class="table-responsive">
<table class="table table-striped">
<thead>
   <tr>
      <th width="20"><input type="checkbox" value="1" id="select-all"></th>
      <th width="20">No</th>
      <th>Kode ProdukPaket</th>
      <th>Nama ProdukPaket</th>
      <th>Kategori</th>
      <!-- <th>Merk</th> -->
      <th>Harga Beli</th>
      <th>Harga Jual</th>
      <th>Diskon</th>
      <th>Stok</th>
      <th width="100">Aksi</th>
   </tr>
</thead>
<tbody></tbody>
</table>
<div>
</form>

      </div>
    </div>
  </div>
</div>

@include('produkpaket.form')
@include('produkpaket.ambil')
@include('produkpaket.tambah')
@endsection

@section('script')
<script type="text/javascript">
var table, save_method;
$(function(){
   table = $('.table').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "{{ route('produkpaket.data') }}",
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
   $('.modal-title').text('Tambah Barang Dagangan');
   $('#kode').attr('readonly', false);
}
function ambil(){
  $('#modal-ambil').modal('show');
}
function tambah(){
  $('#modal-tambah').modal('show');
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
        
       $('#id').val(data.id_produk);
       $('#kode').val(data.kode_produk).attr('readonly', true);
       $('#nama').val(data.nama_produk);
      
     
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
$(function(){
   $('#tanggal_tambah').datepicker({
     format: 'yyyy-mm-dd',
     autoclose: true
   });

});
</script>
@endsection