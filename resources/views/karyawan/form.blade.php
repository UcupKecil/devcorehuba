<div class="modal" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
     
   <form class="form-horizontal" data-toggle="validator" method="POST" enctype="multipart/form-data" >
   {{ csrf_field() }} {{ method_field('POST') }}
   
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
      <h3 class="modal-title"></h3>
   </div>
            
<div class="modal-body">
   
   <input type="hidden" id="id" name="id" >
   <div class="form-group">
      <label for="nama" class="col-md-3 control-label">NIP form</label>
      <div class="col-md-6">
         <input id="NIP" type="text" class="form-control" name="NIP" autofocus required>
         <span class="help-block with-errors"></span>
      </div>
   </div>
   <div class="form-group">
      <label for="nama" class="col-md-3 control-label">Nama Karyawan</label>
      <div class="col-md-6">
         <input id="nama" type="text" class="form-control" name="nama" autofocus required>
         <span class="help-block with-errors"></span>
      </div>
   </div>

   <div class="form-group">
      <label for="email" class="col-md-3 control-label">Email</label>
      <div class="col-md-6">
         <input id="email" type="email" class="form-control" name="email" required>
         <span class="help-block with-errors"></span>
      </div>
   </div>

    <div class="form-group">
      <label for="password" class="col-md-3 control-label">Alamat</label>
      <div class="col-md-6">
         <input id="alamat" type="text" class="form-control" name="alamat" required>
         <span class="help-block with-errors"></span>
      </div>
   </div>

   <div class="form-group">
      <label for="nama" class="col-md-3 control-label">No KTP</label>
      <div class="col-md-6">
         <input id="NoKTP" type="text" class="form-control" name="NoKTP" autofocus required>
         <span class="help-block with-errors"></span>
      </div>
   </div>

   <div class="form-group">
      <label for="nama" class="col-md-3 control-label">Foto</label>
      <div class="col-md-6">
         <input id="foto" type="file" class="form-control" name="foto" autofocus>
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
