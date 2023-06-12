<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOrderHasEmployeeHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_order_has_employee_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_order_has_employee_id');
            $table->foreignId('employee_id');
            $table->foreignId('project_id');
            $table->foreignId('job_order_id');
            $table->enum('status', [
                'active', 'pending', 'finish', 'overtime', 'correction'
            ])->nullable();
            $table->datetime('datetime_start');
            $table->datetime('datetime_end')->nullable();
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
        Schema::dropIfExists('job_order_has_employee_histories');
    }
}
