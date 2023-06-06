<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceFingerspotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_fingerspots', function (Blueprint $table) {
            $table->id();
            $table->string('pin');
            $table->string('cloud_id');
            $table->dateTime('scan_date');
            $table->integer('verify');
            $table->integer('status_scan');
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
        Schema::dropIfExists('attendance_fingerspots');
    }
}
