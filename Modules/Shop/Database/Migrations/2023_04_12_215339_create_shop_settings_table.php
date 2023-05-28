<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shop_name');
            $table->string('shop_url');
            $table->string('code');
            $table->string('username');
            $table->string('password');
            $table->string('type')->default('admin');
            $table->text('settings')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('business_id')->unsigned();
            $table->foreign('business_id')->references('id')->on('business');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_settings');
    }
}
