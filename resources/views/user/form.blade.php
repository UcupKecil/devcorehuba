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
   <div class="form-group">
      <label for="nama" class="col-md-3 control-label">Nama User</label>
      <div class="col-md-6">
         <input id="nama" type="text" list="karyawans" class="form-control" name="nama" autofocus required>
         <span class="help-block with-errors"></span>
         <datalist id="karyawans">
         <?php 
            $data = DB::table('karyawans')->get();
            foreach ($data as $dt){
               echo '<option value="'.$dt->nama.'">';
               $email = $dt->email;
            }
         ?>
         </datalist>
      </div>
   </div>

   <div class="form-group">
      <label for="level" class="col-md-3 control-label">Level</label>
      <div class="col-md-6">
         <select id="level" type="text" class="form-control" name="level" required>
        <option value=""> -- Pilih Level-- </option>
        <option value="1">Admin</option>
        <option value="2">Admin & Marketing</option>
        <option value="3">Marketing</option>
        <option value="4">Produksi</option>
        <option value="5">Logistik & Delivery</option>
      </select>
         <span class="help-block with-errors"></span>
      </div>
   </div>

    <div class="form-group">
      <label for="password" class="col-md-3 control-label">Password</label>
      <div class="col-md-6">
         <input id="password" type="password" class="form-control" name="password" required>
         <span class="help-block with-errors"></span>
      </div>
   </div>

   <div class="form-group">
      <label for="password1" class="col-md-3 control-label">Ulang Password</label>
      <div class="col-md-6">
         <input id="password1" type="password" class="form-control" data-match="#password" name="password1" required>
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
