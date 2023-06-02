<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratPenawaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_penawarans', function (Blueprint $table) {
            $table->id();
            $table->integer("id_pnw")->nullable();
            $table->string("no_surat");
            $table->date("duedate")->nullable();
            $table->string("name_customer")->nullable();
            $table->string("address_customer")->nullable();
            $table->string("phone_customer")->nullable();
            $table->string("comment")->nullable();
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
        Schema::dropIfExists('surat_penawarans');
    }
}
