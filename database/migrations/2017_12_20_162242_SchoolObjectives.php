<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SchoolObjectives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_objectives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id')->unsigned();
            $table->integer('objective_id')->unsigned();
            $table->integer('school_grade')->unsigned();
            $table->integer('year')->unsigned();
            $table->integer('semester')->unsigned();
            $table->integer('subject')->unsigned();
            $table->timestamps();
            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('objective_id')->references('id')->on('objectives');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_classes');
    }
}
