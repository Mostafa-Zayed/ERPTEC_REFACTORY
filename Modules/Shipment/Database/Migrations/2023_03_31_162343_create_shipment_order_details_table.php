<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_order_details', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->text('details');
            $table->integer('transaction_id')->unsigned();
            $table->bigInteger('account_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            
            // relationship 
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->foreign('account_id')->references('id')->on('shipment_accounts');
            $table->foreign('company_id')->references('id')->on('shipment_companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipment_order_details');
    }
}
