<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_details', function (Blueprint $table) {
            $table->increments('id');                 
            $table->integer('id_paket')->unsigned();  
            $table->string('nama_produk', 100)->unsigned();    
            $table->integer('nama_produk')->unsigned(); 
            $table->integer('jumlah')->unsigned();  
            $table->bigInteger('harga_beli')->unsigned();         
            $table->integer('diskon')->unsigned();             
            $table->bigInteger('harga_jual')->unsigned(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paket_details');
    }
}
