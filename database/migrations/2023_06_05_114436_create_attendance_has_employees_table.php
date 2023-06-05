<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceHasEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_has_employees', function (Blueprint $table) {
            $table->id();
            $table->string('pin');
            $table->foreignId('employee_id');
            $table->foreignId('cloud_id');
            $table->date('date');
            $table->time('hour_start')->nullable();
            $table->time('hour_end')->nullable();
            $table->integer('duration_work')->nullable();
            $table->time('hour_rest_start')->nullable();
            $table->time('hour_rest_end')->nullable();
            $table->time('hour_overtime_start')->nullable();
            $table->time('hour_overtime_end')->nullable();
            $table->integer('duration_overtime')->nullable();
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
        Schema::dropIfExists('attendance_has_employees');
    }
}
