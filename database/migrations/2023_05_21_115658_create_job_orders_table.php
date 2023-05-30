<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id');
            $table->foreignId('job_id');
            $table->text('job_note')->nullable();
            $table->datetime('date_time_end');
            // reguler = reguler, daily = harian, fixed_price = borongan
            $table->enum('category', ['reguler', 'daily', 'fixed_price']);
            $table->enum('status', [
                'active', 'pending', 'finish', 'overtime',
                'overtime_finish', 'correction', 'assessment',
            ]);
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
        Schema::dropIfExists('job_orders');
    }
}
