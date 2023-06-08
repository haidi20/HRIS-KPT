<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable();
            $table->foreignId('period_payroll_id')->nullable();
            // $table->foreignId('job_order_id')->nullable();


            $table->decimal("pendapatan_gaji_dasar")->default(0);
            $table->decimal("pendapatan_tunjagan_tetap")->default(0);
            $table->decimal("pendapatan_uang_makan")->default(0);
            $table->decimal("pendapatan_lembur")->default(0);
            $table->decimal("pendapatan_tambahan_lain_lain")->default(0);
            $table->decimal("jumlah_pendapatan")->default(0);



            $table->decimal("pemotongan_bpjs_dibayar_karyawan")->default(0);
            $table->decimal("pemotongan_pph_dua_satu")->default(0);
            $table->decimal("pemotongan_potongan_lain_lain")->default(0);
            $table->decimal("jumlah_pemotongan")->default(0);

            $table->decimal("gaji_bersih")->default(0);


            //////////////

            $table->date("bulan")->nullable();
            $table->string("posisi")->nullable();
            $table->decimal("gaji_dasar")->default(0);
            $table->decimal("tunjangan_tetap")->default(0);
            $table->decimal("rate_lembur")->default(0);


            $table->decimal("tunjangan_makan")->default(0);
            $table->decimal("tunjangan_transport")->default(0);
            $table->decimal("tunjangan_kehadiran")->default(0);
            $table->decimal("ptkp_karyawan")->default(0);
            $table->decimal("jumlah_cuti_ijin_per_bulan")->default(0);
            $table->decimal("sisa_cuti_tahun")->default(0);

            $table->decimal("dasar_updah_bpjs_tk")->default(0);
            $table->decimal("dasar_updah_bpjs_kes")->default(0);

            $table->decimal("jht_perusahaan_persen")->default(0);
            $table->decimal("jht_karyawan_persen")->default(0);
            $table->decimal("jht_perusahaan_rupiah")->default(0);
            $table->decimal("jht_karyawan_rupiah")->default(0);


            $table->decimal("jkk_perusahaan_persen")->default(0);
            $table->decimal("jkk_karyawan_persen")->default(0);
            $table->decimal("jkk_perusahaan_rupiah")->default(0);
            $table->decimal("jkk_karyawan_rupiah")->default(0);

            $table->decimal("jkm_perusahaan_persen")->default(0);
            $table->decimal("jkm_karyawan_persen")->default(0);
            $table->decimal("jkm_perusahaan_rupiah")->default(0);
            $table->decimal("jkm_karyawan_rupiah")->default(0);

            $table->decimal("jp_perusahaan_persen")->default(0);
            $table->decimal("jp_karyawan_persen")->default(0);
            $table->decimal("jp_perusahaan_rupiah")->default(0);
            $table->decimal("jp_karyawan_rupiah")->default(0);

            $table->decimal("bpjs_perusahaan_persen")->default(0);
            $table->decimal("bpjs_karyawan_persen")->default(0);
            $table->decimal("bpjs_perusahaan_rupiah")->default(0);
            $table->decimal("bpjs_karyawan_rupiah")->default(0);

            $table->decimal("total_bpjs_perusahaan_persen")->default(0);
            $table->decimal("total_bpjs_karyawan_persen")->default(0);
            $table->decimal("total_bpjs_perusahaan_rupiah")->default(0);
            $table->decimal("total_bpjs_karyawan_rupiah")->default(0);






            // $table->integer("status")->default(0);
            // $table->integer("number_of_workdays")->nullable();
            // $table->date("date_start")->nullable();
            // $table->date("date_end")->nullable();




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
        Schema::dropIfExists('payrolls');
    }
}
