<div class="modal" id="modal-bayar" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
    
   <form class="form-horizontal" data-toggle="validator" method="post">
   {{ csrf_field() }} {{ method_field('POST') }}
   
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
      @if( Auth::user()->level == 1 )
      <h3 class="modal-title">Pembayaran</h3>
      @else
      <h3 class="modal-title">Pembayaran</h3>
      @endif
   </div>
        
<div class="modal-body">
  
  <input type="hidden" id="id" name="id">
  <input type="hidden" id="jenis" name="jenis" value="Produksi">
  <div class="form-group">
    <!-- <label for="kode" class="col-md-3 control-label">Kode Produk</label> -->
    <div class="col-md-6">
      <input id="kode" type="hidden" class="form-control" name="kode" value="999" autofocus required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group">
    <label for="notransaksi" class="col-md-3 control-label">No Transaksi</label>
    <div class="col-md-6">
      <input id="notransaksi" type="text" class="form-control" name="notransaksi" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group">
    <label for="nama" class="col-md-3 control-label">Nama Konsumen</label>
    <div class="col-md-6">
      <input id="nama" type="text" class="form-control" name="nama" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>


  

  <div class="form-group">
    <label for="bayar" class="col-md-3 control-label">Bayar</label>
    <div class="col-md-3">
      <input id="bayar" type="text" class="form-control" name="bayar" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>
  <div class="form-group">
    <label for="diterima" class="col-md-3 control-label">Diterima</label>
    <div class="col-md-3">
      <input id="diterima" type="text" class="form-control" name="diterima" required>
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