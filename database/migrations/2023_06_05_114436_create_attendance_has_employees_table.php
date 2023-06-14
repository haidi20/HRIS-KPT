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
            $table->foreignId('employee_id')->nullable();
            $table->string('cloud_id');
            $table->date('date');
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

            $table->decimal("lembur_kali_satu_lima",3,2)->default(0);
            $table->decimal("lembur_kali_dua",3,2)->default(0);
            $table->decimal("lembur_kali_tiga",3,2)->default(0);
            $table->decimal("lembur_kali_empat",3,2)->default(0);



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
        Schema::dropIfExists('attendance_has_employees');
    }
}
