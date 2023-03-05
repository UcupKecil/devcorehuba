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
         border: 1px solid #000;
         padding: 2px;
      }
      table.data th{
         text-align: center;
      }
      table.data{ border-collapse: collapse }
   </style>
</head>
<body>

<table>
		<tr>
      <img class="img-logo" src="{{ public_path('images/logo.png') }}" width="100" height="50" />
			<td width='450' align="left" valign='top' >
         
				<div class='header-pt' style="color:black;font-size:14px;">Tahu Bakso Bandung</div>
				<div class='header-address' style="color:black;font-size:14px;">Jl. Subang 3 No. 3A, Antapani, Bandung</div>
				<div class='header-address' style="color:black;font-size:14px;">Telp : 0895-0337-1800</div>
			</td>
         <hr>

         
         
         
			<td valign='top'>
         
				<div style="color:black;font-size:24px;position: absolute;
		top: 0px;
		right: 0px;">
					INVOICE
				</div>
				
			</td>
		</tr>
		<tr>

		<tr>
</table>
<hr color="red">

<table>
		<tr>
			<td width='450' align="left" valign='top' >
				
				<div class='header-pt'>Kepada Yth.</div>
				<div class='header-address'>Nama     : {{ $penjualan->nama }}             </div>
				<div class='header-address'>No. Telp : {{ $penjualan->telpon }} </div>
            <div class='header-address'>Alamat   : {{ $penjualan->alamat_kirim }}</div>
            
			</td>
        
			<td valign='top'>
				
				<div style="color:black;position: absolute;
		top: 75px;
		left: 550px;">
					Sales : Admin
				</div>
				<div style="color:black;position: absolute;
		top: 95px;
		left: 550px;">
					Tgl Order : {{ tanggal_indonesia(substr($penjualan->tanggal, 0, 10), false) }}
				</div>
				<div style="color:black;position: absolute;
		top: 115px;
		left: 550px;">
					Tgl Invoice : {{ tanggal_indonesia(substr($penjualan->tanggal, 0, 10), false) }}
				</div>
				
			</td>
		</tr>
		<tr>

		<tr>
</table>

         
<table width="100%" class="data">
<thead>
   <tr>
    <th>No</th>
    <th>Nama Produk</th>
    <th>Qty</th>
    <th>Harga Satuan</th>
    <th>Total</th>
   </tr>

   <tbody>
    @foreach($detail as $data)
      
    <tr>
       <td>{{ ++$no }}</td> 
     
       <td>{{ $data->nama_lengkap_produk }}</td>
       <td>{{ $data->jumlah }}</td>
       <td align="right">{{ format_uang($data->harga_jual) }}</td>
      
      
       <td align="right">{{ format_uang($data->sub_total) }}</td>
    </tr>
    @endforeach
   
   </tbody>
   <tfoot>
    <tr><td colspan="4" align="right"><b>Total Harga</b></td><td align="right"><b>{{ format_uang($penjualan->bayar) }}</b></td></tr>
    <tr><td colspan="4" align="right"><b>Ongkir</b></td><td align="right"><b>{{ format_uang($penjualan->ongkir) }}</b></td></tr>
    <tr><td colspan="4" align="right"><b>Grand Total</b></td><td align="right"><b>{{ format_uang($penjualan->bayar+$penjualan->ongkir) }}</b></td></tr>
    
   </tfoot>
</table>



<table width="100%">
  <tr>
    <td>
      Transfer pembayaran ke rekening atas nama Dimas Prasetyo<br>
      <b style="color:black;font-size:18px;">BCA : 437.232.56.43</b><br><br>
      Note: Pembayaran maksimal 2 hari pasca huba diterima oleh Konsumen / Reseller / Distributor
    </td>
    
  </tr>
</table> 
</body>
</html>