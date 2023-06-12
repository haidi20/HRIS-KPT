<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryAdjustmentDetailHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_adjustment_detail_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salary_adjustment_detail_id');
            $table->foreignId('salary_adjustment_id');
            $table->foreignId('employee_id');
            $table->double("amount");
            $table->enum('type_amount', ['nominal', 'percent']);
            $table->enum('type_time', ['forever', 'base_time']);
            $table->date("month_start")->nullable();
            $table->date("month_end")->nullable();
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
        Schema::dropIfExists('salary_adjustment_detail_histories');
    }
}
