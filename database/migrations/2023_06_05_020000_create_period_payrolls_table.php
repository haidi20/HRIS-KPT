<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodPayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('period_payrolls', function (Blueprint $table) {
            $table->id();
            // start employee form
            // $table->foreignId('position_id')->nullable();
            // $table->foreignId('job_order_id')->nullable();
            $table->string("name")->nullable();
            $table->integer("status")->default(0);
            $table->integer("number_of_workdays")->nullable();
            $table->date("period")->nullable();
            $table->date("date_start")->nullable();
            $table->date("date_end")->nullable();




            // $table->text("note")->nullable();
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
        Schema::dropIfExists('period_payrolls');
    }
}
