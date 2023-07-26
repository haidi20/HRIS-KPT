<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSalaryAdjustmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* type_incentive :
            - another = lain - lain
            - incentive = insentif
            - deduction = potongan
            - overtime = lembur
        */
        Schema::table('salary_adjustments', function (Blueprint $table) {
            if (!Schema::hasColumn('salary_adjustments', 'type_incentive')) {
                $table->enum('type_incentive', ['another', 'incentive', 'deduction', 'overtime']);
            }
        });
        Schema::table('salary_adjustment_details', function (Blueprint $table) {
            if (!Schema::hasColumn('salary_adjustment_details', 'type_incentive')) {
                $table->enum('type_incentive', ['another', 'incentive', 'deduction', 'overtime']);
            }
        });
        Schema::table('salary_adjustment_detail_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('salary_adjustment_detail_histories', 'type_incentive')) {
                $table->enum('type_incentive', ['another', 'incentive', 'deduction', 'overtime']);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_adjustments', function (Blueprint $table) {
            if (Schema::hasColumn('salary_adjustments', 'type_incentive')) {
                $table->dropColumn('type_incentive');
            }
        });
        Schema::table('salary_adjustment_details', function (Blueprint $table) {
            if (Schema::hasColumn('salary_adjustment_details', 'type_incentive')) {
                $table->dropColumn('type_incentive');
            }
        });
        Schema::table('salary_adjustment_detail_histories', function (Blueprint $table) {
            if (Schema::hasColumn('salary_adjustment_detail_histories', 'type_incentive')) {
                $table->dropColumn('type_incentive');
            }
        });
    }
}
