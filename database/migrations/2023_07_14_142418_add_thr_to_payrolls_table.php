<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThrToPayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->unsignedBigInteger('jumlah_thr')->nullable();
            $table->unsignedBigInteger('pkp_thr_setahun')->nullable();
            $table->unsignedBigInteger('pkp_lima_persen_thr')->nullable();
            $table->unsignedBigInteger('pkp_lima_belas_persen_thr')->nullable();
            $table->unsignedBigInteger('pkp_dua_puluh_lima_persen_thr')->nullable();
            $table->unsignedBigInteger('pkp_tiga_puluh_persen_thr')->nullable();
            $table->unsignedBigInteger('pajak_pph_dua_satu_setahun_thr')->nullable();
            $table->unsignedBigInteger('total_pph_dipotong')->nullable();


            $table->unsignedBigInteger('gaji_jan_nov')->nullable();
            $table->unsignedBigInteger('gaji_des')->nullable();

            $table->unsignedBigInteger('pph_yang_dipotong_jan_nov')->nullable();
            $table->unsignedBigInteger('pph_yang_dipotong_des')->nullable();




            // $table->text('last_pdf')->nullable();
            // $table->text('last_pdf_pt_kpt')->nullable();
            // $table->text('last_pdf_cv_kpt')->nullable();

            // // $table->text('last_excel')->nullable();
            // $table->text('last_excel_pt_kpt')->nullable();
            // $table->text('last_excel_cv_kpt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            //
        });
    }
}
