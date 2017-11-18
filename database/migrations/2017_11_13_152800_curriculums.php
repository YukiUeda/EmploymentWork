<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Curriculums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('programmer_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->string('title');
            $table->string('description');
            $table->string('curriculum_image');
            $table->integer('subject');
            $table->timestamps();
            $table->foreign('programmer_id')->references('id')->on('programmer_accounts');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curriculums');
    }
}
