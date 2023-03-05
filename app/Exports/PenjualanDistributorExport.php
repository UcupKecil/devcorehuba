<?php

namespace App\Exports;

use App\Penjualan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenjualanDistributorExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Tanggal',
            'Distributor',
            'Dropship',
            'Alamat Kirim',
            'No Hp',
            'Jasa Kirim',
            'Biaya Jasa Kirim',
            'Kode Orderan',
            'Banyaknya (Bks)',
            'Harga per bks',
            'jumlah',
            'ket bayar',

            
        ];
    }
    public function collection()
    {
        return DB::table('penjualan_detail')
        ->join('penjualan', 'penjualan.id_penjualan', '=', 'penjualan_detail.id_penjualan')
        ->join('member', 'member.kode_member', '=', 'penjualan.kode_member')
        ->join('produk', 'produk.kode_produk', '=', 'penjualan_detail.kode_produk')
        ->where('member.jenis_member', '=', 'distributor')
        ->orderBy('produk.id_produk', 'desc')
        ->get([
                'penjualan.tanggal', 'member.nama_sa as distributor', 
                'member.nama as namakonsumen',
                'penjualan.alamat_kirim as alamatkirim', 'member.telpon as nohp',
                'penjualan.kurir as jasakirim','penjualan.ongkir as biayajasakirim',
                'produk.nama_produk as namaproduk', 'penjualan_detail.jumlah', 
                'penjualan_detail.harga_jual', 'penjualan_detail.sub_total',
                'penjualan.ket_bayar',
        ]);


    }
}
