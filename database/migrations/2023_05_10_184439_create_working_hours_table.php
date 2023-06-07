<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkingHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_hours', function (Blueprint $table) {
            $table->id();
            $table->time('start_time')->nullable();
            $table->time('after_work')->nullable();
            $table->time('after_work_limit')->nullable(); // batas maksimal jam pulang
            $table->time('start_rest')->nullable();
            $table->time('end_rest')->nullable();
            $table->time('maximum_delay')->nullable();
            $table->time('fastest_time')->nullable();
            $table->time('overtime_work')->nullable();
            $table->time('saturday_work_hour')->nullable();
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
        Schema::dropIfExists('working_hours');
    }
}
