<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_zones', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->timestamps();
            $table->softDeletes();
            $table->integer('business_id')->unsigned();
            $table->integer('state_id')->unsigned();
            $table->integer('zone_id')->unsigned();
            
            $table->foreign('business_id')->references('id')->on('business');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('zone_id')->references('id')->on('zones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('city_zones');
    }
}
