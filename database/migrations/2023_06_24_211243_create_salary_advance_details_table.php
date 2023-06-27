<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryAdvanceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_advance_details', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('salary_advance_id')->nullable();
            $table->foreignId('employee_id')->nullable();
            $table->datetime('date_start')->nullable();
            $table->datetime('date_end')->nullable();
            $table->foreignId('payroll_id')->nullable();
            $table->double('amount')->nullable()->default(0);
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
        Schema::dropIfExists('salary_advance_details');
    }
}
