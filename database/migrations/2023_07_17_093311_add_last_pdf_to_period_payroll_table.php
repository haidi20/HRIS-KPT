<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastPdfToPeriodPayrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('period_payrolls', function (Blueprint $table) {
            $table->text('last_pdf')->nullable();
            $table->text('last_pdf_pt_kpt')->nullable();
            $table->text('last_pdf_cv_kpt')->nullable();

            // $table->text('last_excel')->nullable();
            $table->text('last_excel_pt_kpt')->nullable();
            $table->text('last_excel_cv_kpt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('period_payrolls', function (Blueprint $table) {
            //
        });
    }
}
