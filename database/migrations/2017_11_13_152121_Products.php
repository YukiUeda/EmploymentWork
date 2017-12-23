<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plugin_id')->default(0);
            $table->integer('company_id')->unsigned();
            $table->string('name');
            $table->string('url');
            $table->integer('price');
            $table->string('image');
            $table->integer('click_price');
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('company_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
