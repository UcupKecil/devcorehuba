<!DOCTYPE html>
<html>
<head>
   <title>Nota PDF</title>
   <style type="text/css">
      body{
         font-size:12px;
      }
      h3{
         font-size:18px;
      }
      table td{font: arial 2px;}
      table.data td,
      table.data th{
         /* border: 1px solid #ccc;
         padding: 2px; */
      }
      table.data th{
         text-align: center;
      }
      table.data{ border-collapse: collapse }
   </style>
</head>
<body>

<div style="text-align:center; width:100%">
   <h3>{{ $setting->nama_perusahaan }}</h3>
   {{ $setting->alamat }}
   <br>
   {{ tanggal_indonesia(substr($penjualan->created_at, 0, 10), false) }}
   <table>
      <tr>
         <td align="left">Kasir</td>
         <td align="right">{{Auth::user()->name}}</td>
      </tr>
   </table>
</div>
<div width="100%">
   <table>
   @foreach($detail as $data)
      <tr>
         <td>{{ $data->nama_produk }}</td>
         <td>{{ format_uang($data->harga_jual) }}</td>
         <td>{{ $data->jumlah }}</td>
         <td>{{ format_uang($data->sub_total) }}</td>
      </tr>
      @endforeach
      <tr><td>&nbsp;</td></tr>
      <tr>
         <td  colspan="3" align="left">Total Harga</td>
         <td align="right">{{ format_uang($penjualan->bayar) }}</td>
      </tr>
      <tr>
         <td  colspan="3" align="left">Diterima</td>
         <td align="right">{{ format_uang($penjualan->diterima) }}</td>
      </tr>
      <tr>
         <td  colspan="3" align="left">Kembali</td>
         <td align="right">{{ format_uang($penjualan->diterima - $penjualan->bayar) }}</td>
      </tr>
   </table>
</div>
         
<!-- <table width="100%" class="data">
<thead>
   <tr>
    <!-- <th>No</th> -->
    <!-- <th>Kode Produk</th> --
    <th>Nama Produk</th>
    <th>Harga Satuan</th>
    <th>Jumlah</th>
    <!-- <th>Diskon</th> --
    <th>Subtotal</th>
   </tr>

   <tbody>
    @foreach($detail as $data)
      
    <tr>
       <!-- <td>{{ ++$no }}</td> --
       <!-- <td>{{ $data->kode_produk }}</td> --
       <td>{{ $data->nama_produk }}</td>
       <td align="right">{{ format_uang($data->harga_jual) }}</td>
       <td>{{ $data->jumlah }}</td>
       <!-- <td align="right">{{ format_uang($data->diskon) }}%</td> --
       <td align="right">{{ format_uang($data->sub_total) }}</td>
    </tr>
    @endforeach
   
   </tbody>
   <tfoot>
    <tr><td colspan="6" align="right"><b>Total Harga</b></td><td align="right"><b>{{ format_uang($penjualan->total_harga) }}</b></td></tr>
    <tr><td colspan="6" align="right"><b>Diskon</b></td><td align="right"><b>{{ format_uang($penjualan->diskon) }}%</b></td></tr>
    <tr><td colspan="6" align="right"><b>Total Bayar</b></td><td align="right"><b>{{ format_uang($penjualan->bayar) }}</b></td></tr>
    <tr><td colspan="6" align="right"><b>Diterima</b></td><td align="right"><b>{{ format_uang($penjualan->diterima) }}</b></td></tr>
    <tr><td colspan="6" align="right"><b>Kembali</b></td><td align="right"><b>{{ format_uang($penjualan->diterima - $penjualan->bayar) }}</b></td></tr>
   </tfoot>
</table> -->

<div style="text-align:center">
   <b>Terimakasih telah berbelanja dan sampai jumpa</b>
</div>
<!-- <div style="text-align:center">
   Kasir {{Auth::user()->name}}
</div>
<table width="100%">
  <tr>
    <td>
      <b>Terimakasih telah berbelanja dan sampai jumpa</b>
    </td>
    <td align="center">
      Kasir<br><br><br> {{Auth::user()->name}}
    </td>
  </tr>
</table> -->
</body>
</html>