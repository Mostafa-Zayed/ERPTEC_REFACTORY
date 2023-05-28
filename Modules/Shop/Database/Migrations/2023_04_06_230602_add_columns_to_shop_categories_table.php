<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToShopCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_categories', function (Blueprint $table) {
            $table->string('order_level')->default('0');
            $table->string('banner')->nullable();
            $table->string('icon')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('level')->nullable();
            $table->string('commision_rate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_categories', function (Blueprint $table) {
            $table->dropColumn('order_level');
            $table->dropColumn('banner');
            $table->dropColumn('icon');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
            $table->dropColumn('level');
            $table->dropColumn('commision_rate');
        });
    }
}
