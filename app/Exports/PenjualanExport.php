<?php

namespace App\Exports;

use App\Penjualan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenjualanExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Konsumen',
            'Alamat Kirim',
            'No Hp',
            'Jasa Kirim',
            'Biaya Jasa Kirim',
            'Kode Orderan',
            '(Pcs)',
            'Banyaknya (Bks)',
            'Harga per bks',
            'jumlah',
            'ket bayar',

            
        ];
    }
    protected $awal;
    protected $akhir;
    function __construct($awal,$akhir) {
        $this->awal = $awal;
        $this->akhir = $akhir;
                                }
    
    public function collection()
    {
        return DB::table('v_pcs')
       
        ->where('jenis_member', '=', 'enduser')
        ->whereBetween('tanggal',[ $this->awal,$this->akhir])
        //->whereBetween('penjualan.tanggal',[ '2023-02-01','2023-02-01'])

        ->orderBy('tanggal', 'asc')
        ->orderBy( 'id_penjualan', 'asc')
        ->get([
                'tanggal','nama','alamat_kirim','telpon',
                'kurir','ongkir','nama_produk','pcs','banyak','harga_jual',
                'sub_total','ket_bayar'
        ]);


    }
}
