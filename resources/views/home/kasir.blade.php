@extends('layouts.app')

@section('title')
  Baranda
@endsection

@section('breadcrumb')
   @parent  
   <li>Dashboard</li>
@endsection

@section('content') 
<div class="row">
  <div class="col-xs-12">
    <div class="box">
       <div class="box-body text-center">
            <h1>Selamat Datang</h1>
            
   </div>
  </div>

  <div class="col-md-12">
          <!-- Widget: user widget style 1 -->
          <div class="box box-success box-solid">
            <div class="box-header with-border">
            
              <h3 class="box-title">NOTE</h3>

          </div>
          
            <!-- /.box-header -->
           
            <div class="box-footer no-padding">
            <div class="col-md-12">
            <div style="word-wrap: break-word;">
                            {!! $setting->note !!}
                        </div>
   
    </div>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->
  
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/35.2.1/classic/ckeditor.js"></script>
<script>
  editor.setReadOnly( true);
    
    ClassicEditor
        .create( document.querySelector( '#body' ) )
        .then( editor => {
          
                console.log( editor );
        } )
        .catch( error => {
                console.error( error );
        } )
        ;
</script>

@endsection

