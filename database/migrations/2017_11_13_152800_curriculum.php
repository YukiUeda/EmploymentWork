<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Curriculum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculum', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('programmer_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->string('title');
            $table->string('description');
            $table->string('curriculum_image');
            $table->integer('subject');
            $table->timestamps();
            $table->foreign('programmer_id')->references('id')->on('programmerAccount');
            $table->foreign('product_id')->references('id')->on('product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curriculum');
    }
}
