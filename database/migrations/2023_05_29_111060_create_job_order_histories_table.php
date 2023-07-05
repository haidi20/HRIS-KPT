<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOrderHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_order_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_order_id');
            $table->foreignId('project_id');
            $table->foreignId('job_id')->nullable();
            $table->enum('job_level', ['hard', 'middle', 'easy']);
            // gambar di store table image_has_parent
            // $table->string('image')->nullable();
            $table->string('job_another_name')->nullable();
            $table->text('job_note')->nullable();
            $table->datetime('datetime_start');
            $table->datetime('datetime_end')->nullable();
            $table->datetime('datetime_estimation_end');
            $table->integer('estimation');
            $table->boolean('is_assessment_qc')->default(true);
            $table->enum('time_type', ['minutes', 'hours', 'days']);
            // reguler = reguler, daily = harian, fixed_price = borongan
            $table->enum('category', ['reguler', 'daily', 'fixed_price']);
            $table->enum('status', [
                'active', 'pending',
                'overtime', 'correction',
                'finish', 'assessment',
            ]);
            $table->text('status_note')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('job_order_histories');
    }
}
