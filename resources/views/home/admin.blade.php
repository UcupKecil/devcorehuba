@extends('layouts.app')

@section('title')
  Dashboard
@endsection

@section('breadcrumb')
   @parent
   <li>Dashboard</li>
@endsection

@section('content') 
<div class="row">
<div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-success box-solid">
            <div class="box-header with-border">
            
              <h3 class="box-title">Member</h3>

          </div>
          
            <!-- /.box-header -->
           
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="{{ route('member_enduser.index') }}">Enduser <span class="pull-right badge bg-blue">{{ $memberenduser }}</span></a></li>
                <li><a href="{{ route('member_reseller.index') }}">Reseller <span class="pull-right badge bg-blue">{{ $memberreseller }}</span></a></li>
                <li><a href="{{ route('member_distributor.index') }}">Distributor <span class="pull-right badge bg-blue">{{ $memberdistributor }}</span></a></li>
                <li><a href="{{ route('member_marketing.index') }}">Partner <span class="pull-right badge bg-blue">{{ $membermarketing }}</span></a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->

        <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-success box-solid">
            <div class="box-header with-border">
            
              <p class="box-title" style="font-size:16px">Penjualan @currency($totalpenjualan) 
                / 
                @foreach ($totalpcs as $total)
             {{$total->totalpcs}} 
              @endforeach
              </p>

          </div>
          
            <!-- /.box-header -->
           
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
              @foreach ($detailpenjualan as $detail)
              <li><a href="{{ route('penjualan.index') }}">{{$detail->jenis_member}} <span class="pull-right badge bg-blue">@currency($detail->penjualan) / {{$detail->pcs}} </span></a></li>         
              @endforeach
   
                
                
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->

        <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-success box-solid">
            <div class="box-header with-border">
            
              <h3 class="box-title">Belanja @currency($totalpembelian)</h3>

          </div>
          
            <!-- /.box-header -->
           
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
              @foreach ($detailbelanja as $detail)
              <li><a href="{{ route('pengeluaran.index') }}">{{$detail->kategori}} <span class="pull-right badge bg-blue">@currency($detail->total)</span></a></li>
                                  
                      @endforeach
                
               
                
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->

        

    

        <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-success box-solid">
            <div class="box-header with-border">
            
              <h3 class="box-title">Total Uang</h3>

          </div>
          
            <!-- /.box-header -->
           
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#">Cash <span class="pull-right badge bg-blue">@currency($totaluangcash)</span></a></li>
                <li><a href="#">Transfer <span class="pull-right badge bg-blue">@currency($totaluangtransfer)</span></a></li>
                <li><a href="#"><b>Total</b> <span class="pull-right badge bg-blue">@currency($totaluangcash + $totaluangtransfer)</span></a></li>
                
                
              </ul>
            </div>
            
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->
        
        
        
   
    

        
        

        
</div>
<div class="row">
        <div class="col-lg-3 col-xs-6">
        
        </div>

        </div>

        <div class="row">
                        <div class="col-md-12">
                      
                        </div>
  </div>


<div class="row">
  <div class="col-md-9">
<div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>
              <h3 class="box-title">Note</h3>
            </div>
            <!-- /.box-header -->
            <div class="row">
  <div class="col-xs-12">
    <div class="box">

 <form class="form form-horizontal" data-toggle="validator" method="post" enctype="multipart/form-data">
   {{ csrf_field() }} {{ method_field('PATCH') }}
   <div class="box-body">

  <div class="alert alert-info alert-dismissible" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i>
    Perubahan berhasil disimpan.
  </div>
  
  

  <div class="form-group">

    <div class="col-md-12">
    <textarea name="body" id="body" type="text"
                                    class="form-control form-control-xs @error('body') is-invalid @enderror" value="{{ $setting->note ?? old('body') }}">{{ $setting->note }}</textarea>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  </div>
  <div class="box-footer">
    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Simpan Perubahan</button>
  </div>
</form>
    </div>
  </div>
</div>
            
</div>
</div>
    <div class="col-md-3">
    <div class="small-box bg-red">
            <div class="inner">
            	<h3>@currency($totalpiutang)</h3>
              <p>Total Piutang</p>
            </div>
       		<div class="icon">
           <i class="fa fa-credit-card"></i>
        	</div>
          <a href="{{ route('piutang.index') }}" class="small-box-footer">Baca Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
</div>

<div class="row">
    
</div>
          <!-- /.box -->








<!-- <div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
            	<h3 class="box-title">Grafik Pendapatan {{ tanggal_indonesia($awal1) }} s/d {{ tanggal_indonesia($akhir1) }}</h3>
            </div>
            <div class="box-body">
            	<div class="chart">
                    <canvas id="salesChart1" style="height: 250px;"></canvas>
                </div>
            </div>
        </div>
</div> -->
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
            	<h3 class="box-title">Grafik Pendapatan {{ tanggal_indonesia($awal1) }} s/d {{ tanggal_indonesia($akhir1) }}</h3>
            </div>
            <div class="box-body">
            	<div class="chart">
              <canvas id="myChart" style="height: 250px;"></canvas>
                </div>
            </div>
        </div>
</div>
    <!-- <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
            	<h3 class="box-title">Grafik Pendapatan {{ tanggal_indonesia($awal2) }} s/d {{ tanggal_indonesia($akhir2) }}</h3>
            </div>
            <div class="box-body">
            	<div class="chart">
                    <canvas id="salesChart2" style="height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
            	<h3 class="box-title">Grafik Pendapatan {{ tanggal_indonesia($awal3) }} s/d {{ tanggal_indonesia($akhir3) }}</h3>
            </div>
            <div class="box-body">
            	<div class="chart">
                    <canvas id="salesChart3" style="height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
            	<h3 class="box-title">Grafik Pendapatan {{ tanggal_indonesia($awal4) }} s/d {{ tanggal_indonesia($akhir4) }}</h3>
            </div>
            <div class="box-body">
            	<div class="chart">
                    <canvas id="salesChart4" style="height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div> -->




@include('home.form')

@endsection

@section('script')

<script type="text/javascript">
$(function(){
    showData();
   $('.form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){ 

         $.ajax({
           url : "note/1",
           type : "POST",
           data : new FormData($(".form")[0]),
           async: false,
           processData: false,
           contentType: false,
           success : function(data){
             showData();
             $('.alert').css('display', 'block').delay(2000).fadeOut();
           },
           error : function(){
             alert("Tidak dapat menyimpan data!");
           }   
         });
         return false;
     }
   });

});

function showData(){
  $.ajax({
    url : "note/1/edit",
    type : "GET",
    dataType : "JSON",
    success : function(data){
      var ckValue = CKEDITOR.instances["body"].getData(data.note);
      //$("textarea[name='body']").val(data.note);
    },
    error : function(){
      alert("Tidak dapat menyimpan data!");
    }   
  });
}
</script>

<script type="text/javascript">
var table, save_method;
$(function(){
   table = $('.table').DataTable({
     "processing" : true,
     "ajax" : {
       "url" : "{{ route('katpeng.data') }}",
       "type" : "GET"
     }
   }); 
   
   $('#modal-form form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
         var id = $('#id').val();
         if(save_method == "add") url = "{{ route('note.store') }}";
         else url = "note/"+id;
         
         $.ajax({
           url : url,
           type : "POST",
           data : $('#modal-form form').serialize(),
           success : function(data){
             $('#modal-form').modal('hide');
             table.ajax.reload();
           },
           error : function(){
             alert("Tidak dapat menyimpan data!");
           }   
         });
         return false;
     }
   });
});
function addForm(){
   save_method = "add";
   $('input[name=_method]').val('POST');
   $('#modal-form').modal('show');
   $('#modal-form form')[0].reset();            
   $('.modal-title').text('Tambah Notes');
}

$(function () {
  var salesChartCanvas = $("#salesChart1").get(0).getContext("2d");
  var salesChart = new Chart(salesChartCanvas);

  var salesChartData = {
    labels: {{ json_encode($data_tanggal1) }},
    datasets: [
      {
        label: "Electronics",
        fillColor: "rgba(60,141,188,0.9)",
        strokeColor: "rgb(210, 214, 222)",
        pointColor: "rgb(210, 214, 222)",
        pointStrokeColor: "#c1c7d1",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgb(220,220,220)",
        data: {{ json_encode($data_pendapatan1) }}
      }
    ]
  };

  var salesChartOptions = {
    legend: {display: false},
    scales: {
      yAxes: [{ticks: {min: 6, max:16}}],
    },
    pointDot: false,
    responsive: true
  };

  //Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);
});
</script>

<script type="text/javascript">

  var xValues = {{ json_encode($data_tanggal1) }};
var yValues = {{ json_encode($data_pendapatan1) }};

new Chart("myChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: "",
      borderColor: "rgba(255, 255, 0)",
      pointBackgroundColor: "rgb(128, 0, 0)",
     
      data: yValues
    }]
  },
  
  options: {
    legend: {display: false},
    scales: {
      yAxes: [{min: 0,
        max: 1200,
        ticks: {
          // forces step size to be 50 units
          stepSize: 50
        }}],
    }
  }
});

</script>
<script type="text/javascript">
$(function () {
  var salesChartCanvas = $("#salesChart3").get(0).getContext("2d");
  var salesChart = new Chart(salesChartCanvas);

  var salesChartData = {
    labels: {{ json_encode($data_tanggal3) }},
    datasets: [
      {
        label: "Electronics",
        fillColor: "rgba(60,141,188,0.9)",
        strokeColor: "rgb(210, 214, 222)",
        pointColor: "rgb(210, 214, 222)",
        pointStrokeColor: "#c1c7d1",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgb(220,220,220)",
        data: {{ json_encode($data_pendapatan3) }}
      }
    ]
  };

  var salesChartOptions = {
    pointDot: false,
    responsive: true
  };

  //Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);
});
</script>
<script type="text/javascript">
$(function () {
  var salesChartCanvas = $("#salesChart4").get(0).getContext("2d");
  var salesChart = new Chart(salesChartCanvas);

  var salesChartData = {
    labels: {{ json_encode($data_tanggal4) }},
    datasets: [
      {
        label: "Electronics",
        fillColor: "rgba(60,141,188,0.9)",
        strokeColor: "rgb(210, 214, 222)",
        pointColor: "rgb(210, 214, 222)",
        pointStrokeColor: "#c1c7d1",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgb(220,220,220)",
        data: {{ json_encode($data_pendapatan4) }}
        
      }
      
    ]
  };

  var salesChartOptions = {
    pointDot: false,
    responsive: true
  };

  //Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);
});



</script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.2.1/classic/ckeditor.js"></script>
<script>
    
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