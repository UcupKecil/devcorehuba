@extends('layouts.app')

@section('title')
  Transaksi Penjualan Distributor
@endsection

@section('breadcrumb')
   @parent
   <li>penjualan</li>
   <li>tambah</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
   
      <div class="box-body">

<form class="form form-horizontal form-produk" method="post">
{{ csrf_field() }}  
  <input type="hidden" name="idpenjualan" value="{{ $idpenjualan }}">
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

<form class="form-keranjang">
{{ csrf_field() }} {{ method_field('PATCH') }}
<div class="table-responsive">
<table class="table table-striped tabel-penjualan">
<thead>
   <tr>
      <th width="30">No</th>
      <th>Kode Produk</th>
      <th>Nama Produk</th>
      <th align="right">Harga</th>
      <th>Jumlah</th>
      <th>Diskon</th>
      <th align="right">Sub Total</th>
      <th width="100">Aksi</th>
   </tr>
</thead>
<tbody></tbody>
</table>
</div>
</form>

  <div class="col-md-6">
     <div id="tampil-bayar" style="background: #dd4b39; color: #fff; font-size: 80px; text-align: center; height: 120px"></div>
     <div id="tampil-terbilang" style="background: #3c8dbc; color: #fff; font-size: 25px; padding: 10px"></div>
      @if($errors->any())
        <div style="background: #dd4b39; color: #ffff00; font-size: 48px; padding: 10px"><h1><b>{{$errors->first()}}</b></h1></div>
      @endif
  </div>
  <form class="form form-horizontal form-penjualan" method="post" action="transaksi_distributor/simpan">
      {{ csrf_field() }}
  <div class="col-md-3">
  
      <input type="hidden" name="idpenjualan" value="{{ $idpenjualan }}">
      <input type="hidden" name="total" id="total">
      <input type="hidden" name="totalitem" id="totalitem">
      <input type="hidden" name="bayar" id="bayar">

      <div class="form-group">
      <label for="tanggal" class="col-md-4 control-label">Tanggal</label>
      <div class="col-md-8">
         <input id="tanggal" type="text" class="form-control" name="tanggal" autofocus required>
         <span class="help-block with-errors"></span>
      </div>
      </div>

      <div class="form-group">
        <label for="totalrp" class="col-md-4 control-label">Total</label>
        <div class="col-md-8">
          <input type="text" class="form-control" id="totalrp" readonly>
        </div>
      </div>

      <div class="form-group">
        <label for="member" class="col-md-4 control-label">Kode Member</label>
        <div class="col-md-8">
          <div class="input-group">
            <input id="member" type="text" class="form-control" name="member" placeholder="Pilih jika sudah menjadi member">
            <span class="input-group-btn">
              <button onclick="showMember()" type="button" class="btn btn-info">Add...</button>
            </span>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="member" class="col-md-4 control-label">Nama Member</label>
        <div class="col-md-8">
          
            <input id="namamember" type="text" class="form-control" name="namamember"  readonly>
           
        </div>
      </div>
      <div class="form-group">
        <label for="alamatkirim" class="col-md-4 control-label">Alamat Kirim</label>
        <div class="col-md-8">
        <textarea id="alamatkirim" class="form-control" name="alamatkirim" rows="3" placeholder="Isi Alamat"></textarea> 
        </div>
      </div>

      <div class="form-group">
        <label for="diskon" class="col-md-4 control-label">Diskon</label>
        <div class="col-md-8">
          <input type="text" class="form-control" name="diskon" id="diskon" value="0" readonly>
        </div>
      </div>
  </div>

  <div class="col-md-3">
      <div class="form-group">
        <label for="bayarrp" class="col-md-4 control-label">Bayar</label>
        <div class="col-md-8">
          <input type="text" class="form-control" id="bayarrp" readonly>
        </div>
      </div>

      <div class="form-group">
    <label for="jenis_pembayaran" class="col-md-4 control-label">Jenis Pembayaran</label>
    <div class="col-md-8">
      <select id="jenis_pembayaran" type="text" class="form-control" name="jenis_pembayaran" required>
        <option value=""> -- Pilih Jenis Pembayaran-- </option>
        @foreach($jenispembayaran as $list)
        <option value="{{ $list->jenis_pembayaran }}">{{ $list->jenis_pembayaran }}</option>
        @endforeach
      </select>
      <span class="help-block with-errors"></span>
    </div>
  </div>

      <div class="form-group">
        <label for="diterima" class="col-md-4 control-label">Diterima</label>
        <div class="col-md-8">
          <input type="number" class="form-control" value="0" name="diterima" id="diterima">
        </div>
      </div>

      <div class="form-group">
        <label for="kembali" class="col-md-4 control-label">Kembali</label>
        <div class="col-md-8">
          <input type="text" class="form-control" id="kembali" value="0" readonly>
        </div>
      </div>

      <div class="form-group">
        <label for="kurir" class="col-md-4 control-label">Kurir</label>
        <div class="col-md-8">
            <input id="kurir" type="text" class="form-control" name="kurir" placeholder="Isi nama kurir">
        </div>
      </div>


      <div class="form-group">
        <label for="ongkir" class="col-md-4 control-label">Ongkir</label>
        <div class="col-md-8">
          <input type="number" class="form-control" value="0" name="ongkir" id="ongkir">
        </div>
      </div>

    
  </div>
  </form>

      </div>
      
      <div class="box-footer">
        <button type="submit" class="btn btn-primary pull-right simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
      </div>
    </div>
  </div>
</div>
@include('penjualan_detail_distributor.produk')
@include('penjualan_detail_distributor.member')
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
       "url" : "{{ route('transaksi_distributor.data', $idpenjualan) }}",
       "type" : "GET"
     }
  }).on('draw.dt', function(){
    loadForm($('#diskon').val());
  });

   $('.form-produk').on('submit', function(){
      return false;
   });

   $('body').addClass('sidebar-collapse');

   $('#kode').change(function(){
      addItem();
   });

   $('.form-keranjang').submit(function(){
     return false;
   });

   $('#member').change(function(){
      selectMember($(this).val());
      
   });

  

   $('#diterima').change(function(){
      if($(this).val() == "") $(this).val(0).select();
      loadForm($('#diskon').val(), $(this).val());
   }).focus(function(){
      $(this).select();
   });

   $('.simpan').click(function(){
      $('.form-penjualan').submit();
   });

});

function addItem(){
  $.ajax({
    url : "{{ route('transaksi_distributor.store') }}",
    type : "POST",
    data : $('.form-produk').serialize(),
    success : function(data){
      $('#kode').val('').focus();
      table.ajax.reload(function(){
         loadForm($('#diskon').val());
      });             
    },
    error : function(){
      alert("Tidak dapat menyimpan data!");
    }   
  });
}

function showProduct(){
  $('#modal-produk').modal('show');
}

function showMember(){
  $('#modal-member').modal('show');
}

function selectItem(kode){
  $('#kode').val(kode);
  $('#modal-produk').modal('hide');
  addItem();
}

function changeCount(id){
     $.ajax({
        url : "transaksi_distributor/"+id,
        type : "POST",
        data : $('.form-keranjang').serialize(),
        success : function(data){
          $('#kode').focus();
          table.ajax.reload(function(){
            loadForm($('#diskon').val());
          });             
        },
        error : function(){
          alert("Tidak dapat menyimpan data!");
        }   
     });
}

function changeHarga(id){
     $.ajax({
        url : "transaksi_distributor/"+id,
        type : "POST",
        data : $('.form-keranjang').serialize(),
        success : function(data){
          $('#kode').focus();
          table.ajax.reload(function(){
            loadForm($('#diskon').val());
          });             
        },
        error : function(){
          alert("Tidak dapat menyimpan data!");
        }   
     });
}

function selectMember(kode,nama,alamat){
  $('#modal-member').modal('hide');
  $('#diskon').val('{{ $setting->diskon_member }}');
  $('#member').val(kode);
  $("input[name='namamember']").val(nama);
  $("textarea[name='alamatkirim']").val(alamat);

 
  loadForm($('#diskon').val());
  $('#diterima').val(0).focus().select();
}

function deleteItem(id){
   if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "transaksi_distributor/"+id,
       type : "POST",
       data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
       success : function(data){
         table.ajax.reload(function(){
            loadForm($('#diskon').val());
          }); 
       },
       error : function(){
         alert("Tidak dapat menghapus data!");
       }
     });
   }
}

function loadForm(diskon=0, diterima=0){
  $('#total').val($('.total').text());
  $('#totalitem').val($('.totalitem').text());

  $.ajax({
       url : "transaksi_distributor/loadform/"+diskon+"/"+$('#total').val()+"/"+diterima,
       type : "GET",
       dataType : 'JSON',
       success : function(data){
         $('#totalrp').val("Rp. "+data.totalrp);
         $('#bayarrp').val("Rp. "+data.bayarrp);
         $('#bayar').val(data.bayar);
         $('#tampil-bayar').html("<small>Bayar:</small> Rp. "+data.bayarrp);
         $('#tampil-terbilang').text(data.terbilang);
        
         $('#kembali').val("Rp. "+data.kembalirp);
         if($('#diterima').val() != 0){
            $('#tampil-bayar').html("<small>Kembali:</small> Rp. "+data.kembalirp);
            $('#tampil-terbilang').text(data.kembaliterbilang);
         }
       },
       error : function(){
         alert("Tidak dapat menampilkan data!");
       }
  });
}

$(function(){
   $('#tanggal').datepicker({
     format: 'yyyy-mm-dd',
     autoclose: true
   });

});

</script>

@endsection