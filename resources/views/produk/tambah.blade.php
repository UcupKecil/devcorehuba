<div class="modal" id="modal-tambah" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
    
   <form class="form-horizontal" data-toggle="validator" method="post" action="produk/tambah">
   {{ csrf_field() }} {{ method_field('POST') }}
   <h3 class="modal-title">Penambahan Stock</h3>
        
<div class="modal-body">
    <?php
        $produk=DB::table('produk')->where('id_kategori','not like','102')->where('jenis_produk','Produksi')->get();
    ?>
  <div class="form-group">
      <label for="tanggal_tambah" class="col-md-3 control-label">Tanggal</label>
      <div class="col-md-6">
         <input id="tanggal_tambah" type="text" class="form-control" name="tanggal_tambah" autofocus required>
         <span class="help-block with-errors"></span>
      </div>
  </div>
  <div class="form-group">
    <label for="kode_produk" class="col-md-3 control-label">Nama Produk</label>
    <div class="col-md-6">
      <select id="kode_produk" type="text" class="form-control" name="kode_produk" required>
        <option value=""> -- Pilih Produk-- </option>
        @foreach($produk as $list)
        <option value="{{ $list->kode_produk }}">{{ $list->nama_produk }}</option>
        @endforeach
      </select>
      <span class="help-block with-errors"></span>
    </div>
  </div>
  <div class="form-group">
    <label for="stok" class="col-md-3 control-label">Tambah</label>
    <div class="col-md-2">
      <input id="tambah" type="number" class="form-control" name="tambah" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>
  <div class="form-group">
    <label for="stok" class="col-md-3 control-label">Keterangan</label>
    <div class="col-md-6">
      <input id="keterangan" type="text" class="form-control" name="keterangan" required>
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


