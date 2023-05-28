<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingDetailesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_detailes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('content');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('account_id')->unsigned()->nullable();
            $table->integer('business_id')->unsigned();
            $table->integer('created_by')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_detailes');
    }
}
