<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer("id_inv")->nullable();
            $table->string("no_invoice");
            $table->date("duedate")->nullable();
            $table->string("id_customer")->nullable();
            $table->string("name_customer")->nullable();
            $table->string("address_customer")->nullable();
            $table->string("phone_customer")->nullable();
            $table->string("comment")->nullable();
            $table->integer("diskon_rate")->default(0);
            $table->integer("tax_rate")->default(0);
            $table->integer("profit")->default(0);
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
        Schema::dropIfExists('invoices');
    }
}
