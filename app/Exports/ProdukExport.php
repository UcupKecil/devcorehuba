<?php

namespace App\Exports;

use App\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProdukExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Produk::all();
    }
}
