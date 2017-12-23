<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CurriculumContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculum_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('curriculum_id')->unsigned();
            $table->string('contents');
            $table->string('image');
            $table->timestamps();
            $table->foreign('curriculum_id')->references('id')->on('curriculums');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Curriculum_contents');
    }
}
