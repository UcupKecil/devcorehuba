<div class="modal" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
    
   <form class="form-horizontal" data-toggle="validator" method="post">
   {{ csrf_field() }} {{ method_field('POST') }}
   
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
      @if( Auth::user()->level == 1 || Auth::user()->level == 4 || Auth::user()->level == 5 )
      <h3 class="modal-title">Edit Produk</h3>
      @else
      <h3 class="modal-title">Tambah Stock</h3>
      @endif
   </div>
        
<div class="modal-body">
  
  <input type="hidden" id="id" name="id">
  <input type="hidden" id="kategori" name="kategori" value="102">
  <input type="hidden" id="jenis" name="jenis" value="Mentah">
  <div class="form-group">
    <!-- <label for="kode" class="col-md-3 control-label">Kode Produk</label> -->
    <div class="col-md-6">
      <input id="kode" type="hidden" class="form-control" name="kode" value="999" autofocus required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group">
    <label for="nama" class="col-md-3 control-label">Nama Produk</label>
    <div class="col-md-6">
      <input id="nama" type="text" class="form-control" name="nama" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>
  @if( Auth::user()->level == 1 || Auth::user()->level == 5 || Auth::user()->level == 4  )

  <div class="form-group">
    <label for="merk" class="col-md-3 control-label">Satuan</label>
    <div class="col-md-6">
      <input id="merk" type="text" class="form-control" name="merk" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group">
    <label for="harga_beli" class="col-md-3 control-label">Harga Beli</label>
    <div class="col-md-3">
      <input id="harga_beli" type="text" class="form-control" name="harga_beli" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group">
    <label for="diskon" class="col-md-3 control-label">Diskon</label>
    <div class="col-md-2">
      <input id="diskon" type="text" class="form-control" name="diskon" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group">
    <label for="harga_jual" class="col-md-3 control-label">Harga Jual</label>
    <div class="col-md-3">
      <input id="harga_jual" type="text" class="form-control" name="harga_jual" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>
  @endif
  <div class="form-group">
    <label for="stok" class="col-md-3 control-label">Stok</label>
    <div class="col-md-2">
      <input id="stok" type="text" class="form-control" name="stok" required>
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