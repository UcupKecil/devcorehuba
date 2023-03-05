<div class="modal" id="modal-sales" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
     
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
      <h3 class="modal-title">Cari Sales</h3>
   </div>
            
<div class="modal-body">
   <table class="table table-striped tabel-produk">
      <thead>
         <tr>
            <th>Kode Sales</th>
            <th>Nama Sales</th>
            <th>Alamat</th>
            <th>Telpon</th>
            <th>Aksi</th>
         </tr>
      </thead>
      <tbody>
         @foreach($sales as $data)
         <tr>
            <th>{{ $data->kode_sales }}</th>
            <th>{{ $data->nama }}</th>
            <th>{{ $data->alamat }}</th>
            <th>{{ $data->telepon }}</th>
            <input type="hidden" id="nama" name="nama" value="{{ $data->nama }}">
            <input type="hidden" id="alamat" name="alamat" value="{{ $data->alamat }}">
            <th><a onclick="selectSales({{ $data->kode_sales }},'{{ $data->nama }}','{{ $data->alamat }}')" class="btn btn-primary"><i class="fa fa-check-circle"></i> Pilih</a></th>
          </tr>
         @endforeach
      </tbody>
   </table>

</div>
      
         </div>
      </div>
   </div>
