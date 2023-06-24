<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_adjustments', function (Blueprint $table) {
            $table->id();
            // start employee form
            $table->foreignId('position_id')->nullable();
            $table->foreignId('job_order_id')->nullable();
            $table->foreignId('project_id')->nullable();
            $table->enum('employee_base', [
                'all',
                'project',
                'position',
                'job_order',
                'choose_employee',
            ])->default('all');
            // end employee form
            $table->string("name");
            $table->enum('type_time', ['forever', 'base_time'])->default('forever');
            $table->boolean("is_month_end")->default(false);
            $table->date("month_start")->nullable();
            $table->date("month_end")->nullable();
            // kebutuhan di form employee has parent bagian proyek dan job order
            $table->date("month_filter_has_parent")->nullable();
            $table->enum('type_amount', ['nominal', 'percent'])->default('nominal');
            $table->double("amount")->nullable();
            $table->enum('type_adjustment', ['deduction', 'addition'])->default('deduction');
            $table->text("note")->nullable();
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
        Schema::dropIfExists('salary_adjustments');
    }
}
