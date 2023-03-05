<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
<style>
    @page { size: A4 }

    h1 {
        font-weight: bold;
        font-size: 20pt;
        text-align: center;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    .table th {
        padding: 8px 8px;
        border:1px solid #000000;
        text-align: center;
    }

    .table td {
        padding: 3px 3px;
        border:1px solid #000000;
    }

    .text-center {
        text-align: center;
    }
</style>
<style>
	@media print {
    @page {
    size: 21cm 29.7cm;
	 margin: 30mm 45mm 30mm 45mm;
}
		.header-pt
		{
			font-weight:bold;
		}
	}
	.tbl-resi
	{
		font-size:11px;
	}
  .tbl-reso
	{
		font-size:14px;
	}
  .tbl-catatan
	{
		font-size:12px;
	}
	.table-wrapper
	{
		border:1px solid gray;
		border-top:4px solid gray;
		height:180px;
		padding-top:5px;
	}
	.border-bottom
	{
		border-bottom:1px solid gray;
	}
	.border-top
	{
		border-top:1px solid gray;
	}
	.border-left
	{
		border-left:1px solid gray;
	}
	.img-qrcode
	{
		position:absolute;
		top:0;
		right:0;
	}
	.img-logo
	{
		position:absolute;
		top:10px;
		left:20px;
	}
</style>
<div class="content-wrapper print resi">





	<head>
    <meta charset="utf-8">
    <title>REKAPITULASI PIUTANG</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
</head>
<body class="A4">
    <section class="sheet padding-10mm">
        <h1>REKAPITULASI TAGIHAN</h1>
				<table>
					<tr>
						<td width='450' align="center" valign='top'>

							<img class="img-logo" src="{{ asset('images/percetakan-penerbitan.png') }}" width="100" height="90" />
							<div class='header-pt'>PT. Setia Trans Budi</div>
							<div class='header-address'>Jl. Raya Ciwalengke No 17</div>
							<div class='header-address'>Ds Padamulya Kec. Majalaya</div>
							<div class='header-address'>Kab. Bandung 40382, Indonesia</div>
							<div class='header-address'>Wa / Telp 081320669938</div>
						</td>
						<td valign='top'>
							<h1> INVOICE </h1>
							<div >
								Bandung, <?php echo date('d M Y'); ?>
							</div>

						</td>
					</tr>
					<tr>
						<td rowspan="2">
							<div class='header-pt'>Pelanggan a.n : 
                     @foreach($detail as $data)
                     {{ $data->nama_produk }}
                     @endforeach
                        
                        NO INVOICE. @foreach($detail as $data)
                     {{ $data->nama_produk }}
                     @endforeach</div>


						</td>
					<tr>
				</table>

        <table class="table">
            <thead>


                  <tr  class="tbl-reso">

                    <th width=25 class="border-bottom border-top ">NO</th>
                    <th width=80 class="border-bottom border-top ">NO BUKTI</th>
                    <th width=70 class="border-bottom border-top ">TANGGAL</th>
                    <th width=700 class="border-bottom border-top ">URAIAN</th>
                    <th width=60 class="border-bottom border-top ">QTY</th>
                    <th width=60 class="border-bottom border-top ">HARGA</th>
                    <th width=60 class="border-bottom border-top ">DEBET</th>
                    <th width=60 class="border-bottom border-top ">KREDIT</th>
                    <th width=60 class="border-bottom border-top ">JUMLAH</th>
                  </tr>


            </thead>
						<tbody>

                  @foreach($detail as $data)
                <tr  class="tbl-resi">
               
                  <td align="center" class="border-bottom border-top ">1</td>
                  <td class="border-bottom border-top ">{{ $data->nama_produk }}</td>
                  <td align="center" class="border-bottom border-top ">{{ $data->nama_produk }}</td>
                  <td class="border-bottom border-top ">{{ $data->nama_produk }}</td>
                  <td class="border-bottom border-top ">{{ $data->nama_produk }}</td>
                  <td class="border-bottom border-top ">{{ $data->nama_produk }}</td>
                  <td class="border-bottom border-top ">{{ $data->nama_produk }}</td>
                  <td class="border-bottom border-top ">{{ $data->nama_produk }}</td>
                  <td class="border-bottom border-top ">{{ $data->nama_produk }}</td>


                  @endforeach

                </tr>
               
						<tr>
							<th colspan="6" height="10">Jumlah</th>
              <th  align="right">pemasukan</th>
              <th  align="right"> pengeluaran</th>
              <th  align="right">total</th>


						</tr>




					</tbody>
        </table>
        <td valign='top' style="width:15%">
          <div class='mt10'>
            

          </div>
        </td>






				<table style="width:100%">
					<tr class="tbl-catatan">
            <td valign='top' style="width:15%">
							<div class='mt10'>
								Catatan:
                 <br> * Mohon ditransfer ke Rekening atas nama <b>PT. SETIA TRANS BUDI </b>
                 <br> * No Rekening: A/C <b>376-085-7636 </b> Bank BCA Cab. Majalaya
                 <br> * Apabila Sudah ditransfer harap segera konfirmasi ke <b>Bpk. Anhar Budiman (081320669938) </b>
                 <br> * Pembayaran yang menyimpang diluar tanggung jawab kami
							</div>

						</td>




					</tr>


				</table>


    </section>

</div>
<script>
	$(function(){
		window.print();
	});
</script>
