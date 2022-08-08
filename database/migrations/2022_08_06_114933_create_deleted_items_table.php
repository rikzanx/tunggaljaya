<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeletedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deleted_items', function (Blueprint $table) {
            $table->id();
            $table->integer("invoice_id");
            $table->string("item_of");
            $table->string("description");
            $table->integer("qty");
            $table->integer("item_price");
            $table->date("duedate")->nullable();
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
        Schema::dropIfExists('deleted_items');
    }
}
