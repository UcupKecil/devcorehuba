<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriPengeluaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_pengeluarans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 100); 
            $table->timestamps();
        });
        DB::table('kategori_pengeluarans')->insert([
            ['id' => '1', 'nama' => 'Pembelian Bahan Baku'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kategori_pengeluarans');
    }
}
