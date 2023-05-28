<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_companies', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('phone')->nullable();
            $table->string('type')->default('system');
            $table->boolean('status')->default(true);
            $table->integer('business_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipment_companies');
    }
}
