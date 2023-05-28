<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
           $table->bigIncrements('id');
            $table->string('name');
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_default')->default(false);
            $table->integer('contact_id')->length(10)->unsigned();
            $table->integer('country_id')->length(11)->unsigned();
            $table->integer('city_id')->length(11)->unsigned();
            $table->integer('state_id')->length(11)->unsigned();
            $table->string('content')->nullable();
            $table->integer('business_id')->unsigned();
            
            $table->timestamps();
            
            
            
            $table->foreign('business_id')->references('id')->on('business');
            $table->foreign('contact_id')->references('id')->on('contacts');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('state_id')->references('id')->on('states');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
