@extends('layouts.app')

@section('title')
  Ambil Barang Mentah
@endsection

@section('breadcrumb')
   @parent
   <li>Barang Mentah</li>
   <li>Ambil</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
   
      <div class="box-body">

<form class="form form-horizontal form-produk" method="post">
{{ csrf_field() }}  
  <input type="hidden" name="idstock" value="{{ $idstock }}">
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

<form class="form-keranjang" method="post" action="stock/simpan">
{{ csrf_field() }} {{ method_field('PATCH') }}
@if($errors->any())
        <div style="background: #dd4b39; color: #fff; font-size: 27px; padding: 10px"><h4><b>{{$errors->first()}}</b></h4></div>
      @endif
<table class="table table-striped tabel-penjualan">
<thead>
   <tr>
      <th>Id</th>
      <th width="30">No</th>
      <th>Kode Produk</th>
      <th>Nama Produk</th>
      <!-- <th align="right">Harga</th> -->
      <th>Jumlah</th>
      <!-- <th>Diskon</th> -->
      <!-- <th align="right">Sub Total</th> -->
      <th width="100">Aksi</th>
   </tr>
</thead>
<tbody></tbody>
</table>
</form>
      <form class="form form-horizontal form-penjualan" method="post" action="stock/simpan">
      {{ csrf_field() }}  
        <input type="hidden" name="idstock" value="{{ $idstock }}">
            <div class="box-footer">
              <button type="submit" class="btn btn-primary pull-right simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
            </div>
      </form>
    </div>
  </div>
</div>
@include('stock.produk')
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
       "url" : "{{ route('stock.data', $idstock) }}",
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
    url : "{{ route('stock.store') }}",
    type : "POST",
    data : $('.form-produk').serialize(),
    success : function(data){
      $('#kode').val('').focus();
      table.ajax.reload(function(){
      });             
    },
    error : function(){
      alert("Tidak dapat menyimpan dataaa!");
    }   
  });
}

function changeCount(id){
     $.ajax({
        url : "stock/"+id,
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
       url : "stock/"+id,
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
