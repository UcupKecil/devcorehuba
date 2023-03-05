<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <?php
      $set = DB::table('setting')->where('id_setting','1')->first();
      ?>
  <title>{{$set->nama_perusahaan}}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <link rel="stylesheet" href="{{ asset('adminLTE/plugins/morris.js/morris.css') }}">
  <link rel="stylesheet" href="{{ asset('adminLTE/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminLTE/dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminLTE/dist/css/skins/skin-yellow.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('adminLTE/plugins/datepicker/datepicker3.css') }}">
  <link rel="shortcut icon" href=" {{asset('images/logo.png')}} " type="image/x-icon">
  

</head>
<body class="hold-transition skin-yellow sidebar-mini">
<div class="wrapper">

   <!-- Header -->
  <header class="main-header">

    <a href="#" class="logo">
    
      <span class="logo-mini"><b>POS</b></span>
     <span class="logo-lg"><b>{{$set->nama_perusahaan}}</b></span>
    </a>


    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
         
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('images/'.Auth::user()->foto) }}" class="user-image" alt="User Image">
                <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
                <li class="user-header">
                    <img src="{{ asset('images/'.Auth::user()->foto) }}" class="img-circle" alt="User Image">

                    <p>
                      {{ Auth::user()->name }}
                    </p>
                </li>
                <li class="user-footer">
                    <div class="pull-left">
                        <a class="btn btn-default btn-flat" href="{{ route('user.profil') }}">Edit Profil</a>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-default btn-flat" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>

            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- End Header -->


  <!-- Sidebar -->
  <aside class="main-sidebar">

    <section class="sidebar">
      <ul class="sidebar-menu">
      @if( Auth::user()->level == 1 )
      <li class="treeview menu-open" style="height: auto;">
      <a href="{{route('home')}}">
      <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      </a>
      </li>
        <li class="treeview">
              <a href="#">
                <i class="fa fa-database"></i> <span>Data Master</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
        <ul class="treeview-menu">
        <li><a href="{{ route('member.index') }}"><i class="fa fa-credit-card"></i> <span>Customer</span></a></li>
        <li><a href="{{ route('sales.index') }}"><i class="fa fa-credit-card"></i> <span>Sales Reseller</span></a></li>
        <li><a href="{{ route('karyawan.index') }}"><i class="fa fa-user"></i> <span>Karyawan</span></a></li>
        <li><a href="{{ route('supplier.index') }}"><i class="fa fa-truck"></i> <span>Supplier</span></a></li>
        <li><a href="{{ route('kategori.index') }}"><i class="fa fa-cube"></i> <span>Jenis Huba</span></a></li>
        <li><a href="{{ route('produkpaket.index') }}"><i class="fa fa-cubes"></i> <span>Paket Huba</span></a></li>
        <li><a href="{{ route('katpeng.index') }}"><i class="fa fa-money"></i> <span>Kategori Belanja</span></a></li>   
        <li><a href="{{ route('user.index') }}"><i class="fa fa-user"></i> <span>User</span></a></li> 
              </ul>
        </li>
        <li class="treeview">
              <a href="#">
                <i class="fa fa-cutlery"></i> <span>Bagian Produksi</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">    
        <li><a href="{{ route('produk.index') }}"><i class="fa fa-cubes"></i> <span>Varian Huba</span></a></li>
        <!-- <li><a href="{{ route('pembelian') }}"><i class="fa fa-cubes"></i> <span>Pembelian</span></a></li> -->
        <li><a href="{{ route('pengeluaran.index') }}"><i class="fa fa-money"></i> <span>Belanja</span></a></li>
        <li><a href="{{ route('stock.list') }}"><i class="fa fa-cubes"></i> <span>Bahan Produksi</span></a></li>
        <li><a href="{{ route('stock.new') }}"><i class="fa fa-download"></i> <span>Ambil Bahan Produksi</span></a></li>
              </ul>
        </li>
        <li class="treeview">
              <a href="#">
                <i class="fa fa-cubes"></i> <span>Order Masuk</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">    
        <li><a href="{{ route('order.index') }}"><i class="fa fa-cubes"></i> <span>Order Masuk</span></a></li>
       
              </ul>
        </li>
      
        <li class="treeview">
              <a href="#">
                <i class="fa fa-history"></i> <span>Histori</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
        <ul class="treeview-menu">
        <li><a href="{{ route('stock.laporan') }}"><i class="fa fa-history"></i> <span>History Stok Bahan</span></a></li>
        <li><a href="{{ route('histori_penambahan.index') }}"><i class="fa fa-history"></i> <span>History Produksi Huba</span></a></li>
        <li><a href="{{ route('histori_pengambilan.index') }}"><i class="fa fa-history"></i> <span>History Pengambilan Huba</span></a></li>
        <li><a href="{{ route('histori_stokhuba.index') }}"><i class="fa fa-history"></i> <span>History Stok Huba</span></a></li>
              </ul>
        </li>
        <li class="treeview">
              <a href="#">
                <i class="fa fa-calculator"></i> <span>Kasir</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <li><a href="{{ route('transaksi.new') }}"><i class="fa fa-cart-plus"></i> <span>Transaksi Baru Enduser</span></a></li>
              <li><a href="{{ route('transaksi_reseller.new') }}"><i class="fa fa-cart-plus"></i> <span>Transaksi Baru Reseller</span></a></li>
              <li><a href="{{ route('transaksi_distributor.new') }}"><i class="fa fa-cart-plus"></i> <span>Transaksi Baru Distributor</span></a></li>
              <li><a href="{{ route('transaksi_marketing.new') }}"><i class="fa fa-cart-plus"></i> <span>Transaksi Baru Partner</span></a></li>
        <li><a href="{{ route('penjualan.index') }}"><i class="fa fa-file-excel-o"></i> <span>Data Penjualan</span></a></li>
              </ul>
        </li>

        <li class="treeview">
              <a href="#">
                <i class="fa fa-recycle"></i> <span>Update Retur</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">    
        <li><a href="{{ route('retur.index') }}"><i class="fa fa-recycle"></i> <span>Update Retur Partner</span></a></li>
       
              </ul>
        </li>
        <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i> <span>Laporan</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
        <ul class="treeview-menu">
        <li><a href="{{ route('laporan.index') }}"><i class="fa fa-file-excel-o"></i> <span>Laporan Cashflow</span></a></li>
        <li><a href="{{ route('penjualan.index') }}"><i class="fa fa-file-excel-o"></i> <span>Laporan Penjualan</span></a></li>
       
              </ul>
        </li>
      <li class="treeview menu-open" style="height: auto;">
      <a href="{{route('setting.index')}}">
      <i class="fa fa-gears"></i> <span>Setting</span>
      
      </a>

        
       
        @elseif(Auth::user()->level == 2)
        <li class="treeview menu-open" style="height: auto;">
      <a href="{{route('home')}}">
      <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      </a>
      </li>
        <li class="treeview">
              <a href="#">
                <i class="fa fa-database"></i> <span>Data Master</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
        <ul class="treeview-menu">
        <li><a href="{{ route('member.index') }}"><i class="fa fa-credit-card"></i> <span>Customer</span></a></li>
        <li><a href="{{ route('sales.index') }}"><i class="fa fa-credit-card"></i> <span>Sales Reseller</span></a></li>
        <li><a href="{{ route('karyawan.index') }}"><i class="fa fa-user"></i> <span>Karyawan</span></a></li>
        <li><a href="{{ route('supplier.index') }}"><i class="fa fa-truck"></i> <span>Supplier</span></a></li>
        <li><a href="{{ route('kategori.index') }}"><i class="fa fa-cube"></i> <span>Jenis Huba</span></a></li>
        <li><a href="{{ route('produkpaket.index') }}"><i class="fa fa-cubes"></i> <span>Paket Huba</span></a></li>
        <li><a href="{{ route('katpeng.index') }}"><i class="fa fa-money"></i> <span>Kategori Belanja</span></a></li>   
        <li><a href="{{ route('user.index') }}"><i class="fa fa-user"></i> <span>User</span></a></li> 
              </ul>
        </li>
        <li class="treeview">
              <a href="#">
                <i class="fa fa-cutlery"></i> <span>Bagian Produksi</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">    
        <li><a href="{{ route('produk.index') }}"><i class="fa fa-cubes"></i> <span>Huba</span></a></li>
        <li><a href="{{ route('pengeluaran.index') }}"><i class="fa fa-money"></i> <span>Belanja</span></a></li>
        <!-- <li><a href="{{ route('pembelian') }}"><i class="fa fa-cubes"></i> <span>Pembelian</span></a></li> -->
        <li><a href="{{ route('stock.list') }}"><i class="fa fa-cubes"></i> <span>Bahan Produksi</span></a></li>
        <li><a href="{{ route('stock.new') }}"><i class="fa fa-download"></i> <span>Ambil Bahan Produksi</span></a></li>
              </ul>
        </li>
        <li class="treeview">
              <a href="#">
                <i class="fa fa-cubes"></i> <span>Order Masuk</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">    
        <li><a href="{{ route('order.index') }}"><i class="fa fa-cubes"></i> <span>Order Masuk</span></a></li>
       
              </ul>
        </li>
        
        <li class="treeview">
              <a href="#">
                <i class="fa fa-history"></i> <span>Histori</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
        <ul class="treeview-menu">
        <li><a href="{{ route('stock.laporan') }}"><i class="fa fa-history"></i> <span>History Stok Bahan</span></a></li>
        <li><a href="{{ route('histori_penambahan.index') }}"><i class="fa fa-history"></i> <span>History Produksi Huba</span></a></li>
        <li><a href="{{ route('histori_pengambilan.index') }}"><i class="fa fa-history"></i> <span>History Pengambilan Huba</span></a></li>
        <li><a href="{{ route('histori_stokhuba.index') }}"><i class="fa fa-history"></i> <span>History Stok Huba</span></a></li>
              </ul>
        </li>
        <li class="treeview">
              <a href="#">
                <i class="fa fa-calculator"></i> <span>Kasir</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <li><a href="{{ route('transaksi.new') }}"><i class="fa fa-cart-plus"></i> <span>Transaksi Baru Enduser</span></a></li>
              <li><a href="{{ route('transaksi_reseller.new') }}"><i class="fa fa-cart-plus"></i> <span>Transaksi Baru Reseller</span></a></li>
              <li><a href="{{ route('transaksi_distributor.new') }}"><i class="fa fa-cart-plus"></i> <span>Transaksi Baru Distributor</span></a></li>
              <li><a href="{{ route('transaksi_marketing.new') }}"><i class="fa fa-cart-plus"></i> <span>Transaksi Baru Partner</span></a></li>
        <li><a href="{{ route('penjualan.index') }}"><i class="fa fa-file-excel-o"></i> <span>Data Penjualan</span></a></li>
              </ul>
        </li>
        <li class="treeview">
              <a href="#">
                <i class="fa fa-cubes"></i> <span>Update Retur</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">    
        <li><a href="{{ route('retur.index') }}"><i class="fa fa-cubes"></i> <span>Update Retur Partner</span></a></li>
       
              </ul>
        </li>
        <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i> <span>Laporan</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
        <ul class="treeview-menu">
        <li><a href="{{ route('laporan.index') }}"><i class="fa fa-file-excel-o"></i> <span>Laporan Cashflow</span></a></li>
        <li><a href="{{ route('penjualan.index') }}"><i class="fa fa-file-excel-o"></i> <span>Laporan Penjualan</span></a></li>
        
              </ul>
        </li>
      <li class="treeview menu-open" style="height: auto;">
      <a href="{{route('setting.index')}}">
      <i class="fa fa-gears"></i> <span>Setting</span>
      
      </a>
      @elseif(Auth::user()->level == 3)
      <li class="treeview menu-open" style="height: auto;">
      <a href="{{route('home')}}">
      <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      </a>
      </li>
        
        <li class="treeview">
              <a href="#">
                <i class="fa fa-cutlery"></i> <span>Bagian Produksi</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">    
        <li><a href="{{ route('produk.index') }}"><i class="fa fa-cubes"></i> <span>Varian Huba</span></a></li>
        <li><a href="{{ route('pengeluaran.index') }}"><i class="fa fa-money"></i> <span>Belanja</span></a></li>
        <!-- <li><a href="{{ route('pembelian') }}"><i class="fa fa-cubes"></i> <span>Pembelian</span></a></li> -->
        <li><a href="{{ route('stock.list') }}"><i class="fa fa-cubes"></i> <span>Bahan Produksi</span></a></li>
        <li><a href="{{ route('stock.new') }}"><i class="fa fa-download"></i> <span>Ambil Bahan Produksi</span></a></li>
              </ul>
        </li>
        
        <li class="treeview">
              <a href="#">
                <i class="fa fa-history"></i> <span>Histori</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
        <ul class="treeview-menu">
        <li><a href="{{ route('stock.laporan') }}"><i class="fa fa-history"></i> <span>History Stok Bahan</span></a></li>
        <li><a href="{{ route('histori_penambahan.index') }}"><i class="fa fa-history"></i> <span>History Produksi Huba</span></a></li>
        <li><a href="{{ route('histori_pengambilan.index') }}"><i class="fa fa-history"></i> <span>History Pengambilan Huba</span></a></li>
        <li><a href="{{ route('histori_stokhuba.index') }}"><i class="fa fa-history"></i> <span>History Stok Huba</span></a></li>
              </ul>
        </li>
        <li class="treeview">
              <a href="#">
                <i class="fa fa-calculator"></i> <span>Kasir</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <li><a href="{{ route('transaksi.new') }}"><i class="fa fa-cart-plus"></i> <span>Transaksi Baru Enduser</span></a></li>
              <li><a href="{{ route('transaksi_reseller.new') }}"><i class="fa fa-cart-plus"></i> <span>Transaksi Baru Reseller</span></a></li>
              <li><a href="{{ route('transaksi_distributor.new') }}"><i class="fa fa-cart-plus"></i> <span>Transaksi Baru Distributor</span></a></li>
              <li><a href="{{ route('transaksi_marketing.new') }}"><i class="fa fa-cart-plus"></i> <span>Transaksi Baru Partner</span></a></li>
        <li><a href="{{ route('penjualan.index') }}"><i class="fa fa-file-excel-o"></i> <span>Data Penjualan</span></a></li>
              </ul>
        </li>

        <li class="treeview">
              <a href="#">
                <i class="fa fa-recycle"></i> <span>Update Retur</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">    
        <li><a href="{{ route('retur.index') }}"><i class="fa fa-recycle"></i> <span>Update Retur Partner</span></a></li>
       
              </ul>
        </li>
        
      
      @elseif(Auth::user()->level == 4)
      <li class="treeview menu-open" style="height: auto;">
      <a href="{{route('home')}}">
      <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      </a>
      </li>
        
        <li class="treeview">
              <a href="#">
                <i class="fa fa-cutlery"></i> <span>Bagian Produksi</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">    
        <li><a href="{{ route('produk.index') }}"><i class="fa fa-cubes"></i> <span>Varian Huba</span></a></li>
        <li><a href="{{ route('stock.list') }}"><i class="fa fa-cubes"></i> <span>Bahan Produksi</span></a></li>
        <li><a href="{{ route('stock.new') }}"><i class="fa fa-download"></i> <span>Ambil Bahan Produksi</span></a></li>
              </ul>
        </li>

        <li class="treeview">
              <a href="#">
                <i class="fa fa-cubes"></i> <span>Order Masuk</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">    
        <li><a href="{{ route('order.index') }}"><i class="fa fa-cubes"></i> <span>Order Masuk</span></a></li>
       
              </ul>
        </li>
       
        <li class="treeview">
              <a href="#">
                <i class="fa fa-history"></i> <span>Histori</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
        <ul class="treeview-menu">
        <li><a href="{{ route('stock.laporan') }}"><i class="fa fa-history"></i> <span>History Stok Bahan</span></a></li>
        <li><a href="{{ route('histori_penambahan.index') }}"><i class="fa fa-history"></i> <span>History Produksi Huba</span></a></li>
        <li><a href="{{ route('histori_pengambilan.index') }}"><i class="fa fa-history"></i> <span>History Pengambilan Huba</span></a></li>
        <li><a href="{{ route('histori_stokhuba.index') }}"><i class="fa fa-history"></i> <span>History Stok Huba</span></a></li>
              </ul>
        </li>
        
      @elseif(Auth::user()->level == 5)
      <li class="treeview menu-open" style="height: auto;">
      <a href="{{route('home')}}">
      <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      </a>
      </li>
        
        <li class="treeview">
              <a href="#">
                <i class="fa fa-cutlery"></i> <span>Bagian Produksi</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">    

        <li><a href="{{ route('pengeluaran.index') }}"><i class="fa fa-money"></i> <span>Belanja</span></a></li>
        <li><a href="{{ route('stock.list') }}"><i class="fa fa-cubes"></i> <span>Bahan Produksi</span></a></li>
        <li><a href="{{ route('stock.new') }}"><i class="fa fa-download"></i> <span>Ambil Bahan Produksi</span></a></li>
              </ul>
        </li>
        
        <li class="treeview">
              <a href="#">
                <i class="fa fa-history"></i> <span>Histori</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
        <ul class="treeview-menu">
        <li><a href="{{ route('stock.laporan') }}"><i class="fa fa-history"></i> <span>History Stok Bahan</span></a></li>
        <li><a href="{{ route('histori_penambahan.index') }}"><i class="fa fa-history"></i> <span>History Produksi Huba</span></a></li>
        <li><a href="{{ route('histori_pengambilan.index') }}"><i class="fa fa-history"></i> <span>History Pengambilan Huba</span></a></li>
        <li><a href="{{ route('histori_stokhuba.index') }}"><i class="fa fa-history"></i> <span>History Stok Huba</span></a></li>
              </ul>
        </li>
        
        
      
      @endif
      </ul>
    </section>
  </aside>
  <!-- End Sidebar -->

  <!-- Content  -->
  <div class="content-wrapper">
   <section class="content-header">
      <h1>
        @yield('title')
      </h1>
      <ol class="breadcrumb">
        @section('breadcrumb')
        <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
        @show
      </ol>
    </section>

    <section class="content">
        @yield('content')
    </section>
  </div>
  <!-- End Content -->

  <!-- Footer -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      HUBA
    </div>
    <strong>Copyright &copy; 2023 <a href="#">POS HUBA</a>.</strong> All rights reserved.
  </footer>
  <!-- End Footer -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="{{ asset('adminLTE/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script src="{{ asset('adminLTE/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('adminLTE/dist/js/app.min.js') }}"></script>
<script src="{{ asset('adminLTE/plugins/morris.js/morris.min.js') }}"></script>

<script
src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>
<!-- <script src="{{ asset('adminLTE/plugins/chartjs/Chart.min.js') }}"></script> -->
<script src="{{ asset('adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('adminLTE/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('js/validator.min.js') }}"></script>

@yield('script')

</body>
</html>