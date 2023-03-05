@extends('layouts.app')

@section('title')
  Buat Paket
@endsection

@section('breadcrumb')
   @parent
   <li>Paket</li>
   <li>Buat</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
   
      <div class="box-body">

<form class="form form-horizontal form-produk" method="post">
{{ csrf_field() }}  
  <input type="hidden" name="idpaket" value="{{ $idpaket }}">
  <div class="form-group">
      <label for="kode" class="col-md-2 control-label">Kode Produk</label>
      <div class="col-md-5">
        <div class="input-group">
          <input id="kode" type="text" class="form-control" name="kode" autofocus required>
          <span class="input-group-btn">
            <button onclick="showProduct()" type="button" class="btn btn-info">Add...</button>
          </span>
        </div>
      </div>
  </div>
</form>

<form class="form-keranjang" method="post" action="paket/simpan">
{{ csrf_field() }} {{ method_field('PATCH') }}
<div class="table-responsive">
<table class="table table-striped tabel-penjualan">
<thead>
   <tr>
      <!-- <th>Id</th> -->
      <th width="30">No</th>
      <th>Kode Produk</th>
      <th>Nama Produk</th>
      <!-- <th align="right">Harga</th> -->
      <th>Jumlah</th>
      <!-- <th>Diskon</th> -->
      <!-- <th align="right">Sub Total</th> -->
      <th width="100">Aksi</th>
      <!-- <th>Total Harga Beli</th> -->
   </tr>
</thead>
<tbody></tbody>
</table>
</div>
</form>
      <form class="form form-horizontal form-penjualan" method="post" action="paket/simpan">
      {{ csrf_field() }}  
        <input type="hidden" name="idpaket" value="{{ $idpaket }}">
          <div class="form-group">
            <label for="nama" class="col-md-4 control-label">Nama Paket</label>
            <div class="col-md-8">
              <input type="text" class="form-control" id="nama" name="nama">
            </div>
          </div>
          <div class="form-group">
            <label for="diskon" class="col-md-4 control-label">Diskon %</label>
            <div class="col-md-8">
              <input type="number" class="form-control" id="diskon" name="diskon">
            </div>
          </div>
          <div class="form-group">
            <label for="hargajual" class="col-md-4 control-label">Harga Jual</label>
            <div class="col-md-8">
              <input type="number" class="form-control" id="jual" name="hargajual">
            </div>
          </div>
          <div class="form-group">
            <label for="stock" class="col-md-4 control-label">Stock</label>
            <div class="col-md-8">
              <input type="number" class="form-control" id="stock" name="stock">
            </div>
          </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary pull-right simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
              
            </div>
      </form>
    </div>
  </div>
</div>
@include('paket.produk')
@endsection

@section('script')
<script type="text/javascript">
var table;

$(function(){
  $('.tabel-produk').DataTable();

  table = $('.tabel-penjualan').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "processing" : true,
     "ajax" : {
       "url" : "{{ route('paket.data', $idpaket) }}",
       "type" : "GET"
     }
  });

   $('.form-produk').on('submit', function(){
      return false;
   });

   $('#kode').change(function(){
      addItem();
   });

   $('.form-keranjang').submit(function(){
     return false;
   });

   $('.simpan').click(function(){
      $('.form-penjualan').submit();
   });

});

function showProduct(){
  $('#modal-produk').modal('show');
}
function selectItem(kode){
  $('#kode').val(kode);
  $('#modal-produk').modal('hide');
  addItem();
}
function addItem(){
  $.ajax({
    url : "{{ route('paket.store') }}",
    type : "POST",
    data : $('.form-produk').serialize(),
    success : function(data){
      $('#kode').val('').focus();
      table.ajax.reload(function(){
      });             
    },
    error : function(){
      alert("Tidak dapat menyimpan data!");
    }   
  });
}

function changeCount(id){
     $.ajax({
        url : "paket/"+id,
        type : "POST",
        data : $('.form-keranjang').serialize(),
        success : function(data){
          $('#kode').focus();
          table.ajax.reload(function(){
          });             
        },
        error : function(){
          alert("Tidak dapat menyimpan data!");
        }   
     });
}

function deleteItem(id){
   if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "paket/"+id,
       type : "POST",
       data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
       success : function(data){
         table.ajax.reload(function(){
          }); 
       },
       error : function(){
         alert("Tidak dapat menghapus data!");
       }
     });
   }
}
</script>
@endsection
