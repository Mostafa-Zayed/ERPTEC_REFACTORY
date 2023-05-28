<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsPageMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_page_metas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('cms_page_id');
            $table->foreign('cms_page_id')
                ->references('id')->on('cms_pages')
                ->onDelete('cascade');

            $table->string('meta_key');
            $table->longText('meta_value')->nullable();
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
        Schema::dropIfExists('cms_page_metas');
    }
}
