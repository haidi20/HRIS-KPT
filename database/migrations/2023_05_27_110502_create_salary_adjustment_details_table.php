<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryAdjustmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_adjustment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salary_adjustment_id')->nullable();
            $table->foreignId('employee_id')->nullable();
            $table->enum('type_amount', ['nominal', 'percent'])->default('nominal');
            $table->double("amount")->nullable();
            $table->enum('type_time', ['forever', 'base_time'])->default('forever');
            $table->date("month_start")->nullable();
            $table->date("month_end")->nullable();
            $table->boolean("is_thr")->default(false);
            $table->string("name_salary_adjustment")->nullable();
            $table->text("note_salary_adjustment")->nullable();
            $table->integer("is_payroll_use")->default(0); // menandakan sudah terpakai di payroll
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_adjustment_details');
    }
}
