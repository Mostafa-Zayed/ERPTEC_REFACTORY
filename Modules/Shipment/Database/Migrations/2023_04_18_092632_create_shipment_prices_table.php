<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('value');
            $table->string('cost')->nullable();
            $table->string('extra')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('business_id')->unsigned();
            $table->integer('shipment_company_id')->unsigned();
            $table->bigInteger('shipment_account_id')->unsigned();
            $table->integer('zone_id')->unsigned();
            $table->foreign('zone_id')->references('id')->on('zones');
            $table->foreign('business_id')->references('id')->on('business');
            $table->foreign('shipment_company_id')->references('id')->on('shipment_companies');
            $table->foreign('shipment_account_id')->references('id')->on('shipment_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipment_prices');
    }
}
