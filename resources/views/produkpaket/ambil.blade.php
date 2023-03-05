<div class="modal" id="modal-ambil" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
    
   <form class="form-horizontal" data-toggle="validator" method="post" action="produkpaket/ambil">
   {{ csrf_field() }} {{ method_field('POST') }}
   <h3 class="modal-title">Pengurangan Stock Paket Huba</h3>
        
<div class="modal-body">
    <?php
        $produkpaket=DB::table('produk')->where('id_kategori','not like','102')->where('jenis_produk','Paket')->where('stok',"not like",'0')->get();
    ?>
  <div class="form-group">
      <label for="tanggal" class="col-md-3 control-label">Tanggal</label>
      <div class="col-md-6">
         <input id="tanggal" type="text" class="form-control" name="tanggal" autofocus required>
         <span class="help-block with-errors"></span>
      </div>
  </div>
  <div class="form-group">
    <label for="kode_produkpaket" class="col-md-3 control-label">Nama ProdukPaket</label>
    <div class="col-md-6">
      <select id="kode_produkpaket" type="text" class="form-control" name="kode_produkpaket" required>
        <option value=""> -- Pilih ProdukPaket-- </option>
        @foreach($produkpaket as $list)
        <option value="{{ $list->kode_produk }}">{{ $list->nama_produk }}</option>
        @endforeach
      </select>
      <span class="help-block with-errors"></span>
    </div>
  </div>
  <div class="form-group">
    <label for="stok" class="col-md-3 control-label">Ambil</label>
    <div class="col-md-2">
      <input id="ambil" type="number" class="form-control" name="ambil" required>
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


