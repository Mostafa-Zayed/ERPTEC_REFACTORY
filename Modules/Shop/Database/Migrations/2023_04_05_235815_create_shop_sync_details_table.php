<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopSyncDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_sync_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sync_type');
            $table->string('operation')->nullable();
            $table->text('data')->nullable();
            $table->text('details')->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('business_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('business_id')->references('id')->on('business');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_sync_details');
    }
}
