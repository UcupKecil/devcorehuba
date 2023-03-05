<div class="modal" id="modal-retur" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
    
   <form name="myform" class="form-horizontal" data-toggle="validator" method="post">
   {{ csrf_field() }} {{ method_field('POST') }}
   
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
      @if( Auth::user()->level == 1 )
      <h3 class="modal-title">Retur</h3>
      @else
      <h3 class="modal-title">Retur</h3>
      @endif
   </div>
        
<div class="modal-body">
  
  <input type="hidden" id="idretur" name="idretur">
  <input type="hidden" id="jenis" name="jenis" value="Produksi">
  <div class="form-group">
    <!-- <label for="kode" class="col-md-3 control-label">Kode Produk</label> -->
    <div class="col-md-6">
      <input id="kode" type="hidden" class="form-control" name="kode" value="999" autofocus required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group">
    <label for="notransaksiretur" class="col-md-3 control-label">No Transaksi</label>
    <div class="col-md-6">
      <input id="notransaksiretur" type="text" class="form-control" name="notransaksiretur" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group">
    <label for="namaretur" class="col-md-3 control-label">Nama Konsumen</label>
    <div class="col-md-6">
      <input id="namaretur" type="text" class="form-control" name="namaretur" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>
  <div class="form-group">
    <label for="namaproduk" class="col-md-3 control-label">Nama Produk</label>
    <div class="col-md-6">
      <input id="namaproduk" type="text" class="form-control" name="namaproduk" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>


  <div class="form-group">
    <label for="jumlah_awal" class="col-md-3 control-label">Jml Awal</label>
    <div class="col-md-3">
      <input id="jumlah_awal" type="text" class="form-control" name="jumlah_awal" required>
      <span class="help-block with-errors"></span>
    </div>
    <label for="jumlah_sold" class="col-md-2 control-label">Jml Sold</label>
    <div class="col-md-3">
      <input id="jumlah_sold" type="text" class="form-control" name="jumlah_sold" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

 

  <div class="form-group">
    <label for="sub_total_awal" class="col-md-3 control-label">Sub Total Awal</label>
    <div class="col-md-3">
      <input id="sub_total_awal" type="text" class="form-control" name="sub_total_awal" required>
      <span class="help-block with-errors"></span>
    </div>
    <label for="sub_total_sold" class="col-md-2 control-label">Sub Total Sold</label>
    <div class="col-md-3">
      <input id="sub_total_sold" type="text" class="form-control" name="sub_total_sold" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  

  <div class="form-group">
    <label for="harga_pcs" class="col-md-3 control-label">Harga Pack</label>
    <div class="col-md-3">
      <input id="harga_pcs" type="number" onChange="hitungPcsSold()"  class="form-control" name="harga_pcs" required>
      <span class="help-block with-errors"></span>
    </div>
    <label for="sub_total_retur" class="col-md-2 control-label">Sub Total Retur</label>
    <div class="col-md-3">
      <input id="sub_total_retur" type="number" class="form-control" name="sub_total_retur" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group">
    <label for="diterima" class="col-md-3 control-label">Retur</label>
    <div class="col-md-3">
      <input id="diterimaretur" type="number" onChange="hitungPcsSold()" class="form-control" name="diterimaretur" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>
  

  
  
</div>
   
   <div class="modal-footer">
      <button type="submit" class="btn btn-primary btn-save"><i class="fa fa-floppy-o"></i> Simpan </button>
      <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
   </div>
    
   </form>

         </div>
      </div>
   </div>