<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRealtionIdToDetailPayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_payrolls', function (Blueprint $table) {
            $table->foreignId('salary_advance_id')->nullable();
            $table->foreignId('salary_adjustment_detail_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_payrolls', function (Blueprint $table) {
            //
        });
    }
}
