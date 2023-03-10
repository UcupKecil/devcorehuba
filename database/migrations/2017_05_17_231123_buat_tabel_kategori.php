<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTabelKategori extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori', function(Blueprint $table){
            $table->increments('id_kategori');          
            $table->string('nama_kategori', 100);           
            $table->timestamps();         
        });
        DB::table('kategori')->insert([
            ['id_kategori' => '102', 'nama_kategori' => 'Stock'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('kategori');
    }
}
