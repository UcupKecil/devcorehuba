<div class="modal" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
     
   <form class="form-horizontal" data-toggle="validator" method="post" action="{{route('sales.store')}}">
   {{ csrf_field() }} {{ method_field('POST') }}
   
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
      <h3 class="modal-title"></h3>
   </div>
            
<div class="modal-body">
   
   <input type="hidden" id="id" name="id">
   <div class="form-group">
      <!-- <label for="kode" class="col-md-3 control-label">Kode Member</label> -->
      <div class="col-md-6">
         <input id="kode" type="hidden" class="form-control" name="kode" value="9999" autofocus required>
         <span class="help-block with-errors"></span>
      </div>
   </div>

   

   <div class="form-group">
      <label for="nama" class="col-md-3 control-label">Nama Sales</label>
      <div class="col-md-6">
         <input id="nama" type="text" class="form-control" name="nama" autofocus required>
         <span class="help-block with-errors"></span>
      </div>
   </div>

   <div class="form-group">
      <label for="alamat" class="col-md-3 control-label">Alamat</label>
      <div class="col-md-8">
         <input id="alamat" type="text" class="form-control" name="alamat" required>
         <span class="help-block with-errors"></span>
      </div>
   </div>

   <div class="form-group">
      <label for="telpon" class="col-md-3 control-label">Telpon</label>
      <div class="col-md-6">
         <input id="telpon" type="text" class="form-control" name="telpon" autofocus required>
         <span class="help-block with-errors"></span>
      </div>
   </div>
   <div class="form-group">
      <label for="medsos" class="col-md-3 control-label">Medsos</label>
      <div class="col-md-6">
         <input id="medsos" type="text" class="form-control" name="medsos" autofocus required>
         <span class="help-block with-errors"></span>
      </div>
   </div>
   <div class="form-group">
      <label for="tempat_lahir" class="col-md-3 control-label">Tempat Lahir</label>
      <div class="col-md-6">
         <input id="tempat_lahir" type="text" class="form-control" name="tempat_lahir" autofocus required>
         <span class="help-block with-errors"></span>
      </div>
   </div>
   <div class="form-group">
      <label for="tanggal_lahir" class="col-md-3 control-label">Tanggal Lahir</label>
      <div class="col-md-6">
         <input id="tanggal_lahir" type="text" class="form-control" name="tanggal_lahir" autofocus required>
         <span class="help-block with-errors"></span>
      </div>
   </div>

   <div class="form-group">
      <label for="motivasi" class="col-md-3 control-label">Motivasi</label>
      <div class="col-md-8">
         <input id="motivasi" type="text" class="form-control" name="motivasi" required>
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
