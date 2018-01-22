<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SchoolWeekdaySchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_weekday_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('class_id')->unsigned();
            $table->integer('timetable_id')->unsigned();
            $table->integer('week')->unsigned();
            $table->integer('year')->unsigned();
            $table->integer('subject')->unsigned();
            $table->timestamps();
            $table->foreign('class_id')->references('id')->on('teacher_classes');
            $table->foreign('timetable_id')->references('id')->on('school_time_tables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
