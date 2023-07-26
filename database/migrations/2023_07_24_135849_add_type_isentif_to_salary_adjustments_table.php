<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeIsentifToSalaryAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_adjustments', function (Blueprint $table) {
            if (!Schema::hasColumn('salary_adjustments', 'type_incentive')) {
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
    }
}
