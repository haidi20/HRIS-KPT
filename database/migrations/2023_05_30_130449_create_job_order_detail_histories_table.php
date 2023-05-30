<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOrderDetailHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
            fungsi sebagai kita tau kapan waktunya setiap perubahan setiap status.
            dan table ini untuk sebagai bahan analisa
        */
        Schema::create('job_order_detail_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->foreignId('job_order_id');
            $table->foreignId('job_order_detail_id');
            $table->enum('status', [
                'active', 'pending', 'finish', 'overtime', 'overtime_finish',
            ])->nullable();
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
        Schema::dropIfExists('job_order_detail_histories');
    }
}
