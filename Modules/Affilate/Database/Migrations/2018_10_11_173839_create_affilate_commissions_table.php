<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffilateCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affilate_commissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->double('amount')->nullable()->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('transaction_id')->nullable();
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
        Schema::dropIfExists('affilate_commissions');
    }
}
