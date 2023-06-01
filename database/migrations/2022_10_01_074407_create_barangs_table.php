<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string("jenis")->nullable();
            $table->string("ukuran")->nullable();
            $table->string("koneksi")->nullable();
            $table->string("material")->nullable();
            $table->string("brand")->nullable();
            $table->integer("jumlah");
            $table->string("keterangan")->nullable();
            // $table->string("image_category");
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
        Schema::dropIfExists('barangs');
    }
}
