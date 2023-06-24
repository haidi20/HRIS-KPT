<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->string('pin')->nullable();
            $table->foreignId('employee_id')->nullable();
            $table->string('cloud_id')->nullable();
            $table->date('date')->nullable();
            $table->datetime('hour_start')->nullable();
            $table->datetime('hour_end')->nullable();
            $table->integer('duration_work')->nullable(); // dalam bentuk menit
            $table->datetime('hour_rest_start')->nullable();
            $table->datetime('hour_rest_end')->nullable();
            $table->integer('duration_rest')->nullable(); // dalam bentuk menit
            $table->datetime('hour_overtime_start')->nullable();
            $table->datetime('hour_overtime_end')->nullable();
            $table->integer('duration_overtime')->nullable(); // dalam bentuk menit
            $table->datetime('hour_overtime_job_order_start')->nullable();
            $table->datetime('hour_overtime_job_order_end')->nullable();
            $table->integer('duration_overtime_job_order')->nullable();

            $table->double("lembur_kali_satu_lima")->default(0);
            $table->double("lembur_kali_dua")->default(0);
            $table->double("lembur_kali_tiga")->default(0);
            $table->double("lembur_kali_empat")->default(0);



            $table->integer("is_weekend")->default(0);
            $table->integer("is_vacation")->default(0);
            $table->integer("is_payroll_use")->default(0);
            $table->foreignId('payroll_id')->nullable();
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
        Schema::dropIfExists('attendance');
    }
}
