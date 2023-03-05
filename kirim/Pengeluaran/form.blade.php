<div class="modal" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
     
   <form class="form-horizontal" data-toggle="validator" method="post">
   {{ csrf_field() }} {{ method_field('POST') }}
   
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
      <h3 class="modal-title"></h3>
   </div>
            
<div class="modal-body">
   
   <input type="hidden" id="id" name="id">
   <input type="hidden" id="suplier" name="suplier" value="-">

   <div class="form-group">
    <label for="kategori" class="col-md-3 control-label">Kategori</label>
    <div class="col-md-6">
      <select id="kategori" type="text" class="form-control" name="kategori" required>
        <option value=""> -- Pilih Kategori-- </option>
        @foreach($kategori as $list)
        <option value="{{ $list->id }}">{{ $list->nama}}</option>
        @endforeach
      </select>
      <span class="help-block with-errors"></span>
    </div>
  </div>

   <div class="form-group">
      <label for="jenis" class="col-md-3 control-label">Keterangan</label>
      <div class="col-md-8">
         <input id="jenis" type="text" class="form-control" name="jenis" autofocus required>
         <span class="help-block with-errors"></span>
      </div>
   </div>

   <div class="form-group">
      <label for="jenis" class="col-md-3 control-label">No Kuitansi</label>
      <div class="col-md-8">
         <input id="kuitansi" type="text" class="form-control" name="kuitansi" autofocus required>
         <span class="help-block with-errors"></span>
      </div>
   </div>

   <div class="form-group">
      <label for="nominal" class="col-md-3 control-label">Nominal</label>
      <div class="col-md-3">
         <input id="nominal" type="number" class="form-control" name="nominal" required>
         <span class="help-block with-errors"></span>
      </div>
   </div>

   <div class="form-group">
      <label for="awal" class="col-md-3 control-label">Tanggal</label>
      <div class="col-md-6">
         <input id="awal" type="text" class="form-control" name="awal" autofocus required>
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
