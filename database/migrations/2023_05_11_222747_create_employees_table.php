<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            // DATA PERSONAL
            $table->string('nip')->nullable();
            $table->string('nik')->nullable();
            $table->string('name')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('phone')->nullable();
            $table->string('religion')->nullable();
            $table->string('address')->nullable();
            $table->string('photo')->nullable();

            // DATA KEPEGAWAIAN
            $table->date('enter_date')->nullable();
            $table->string('npwp')->nullable();
            $table->string('no_bpjs')->nullable();
            $table->string('no_bpjs_tenaga_kerja')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('employee_type_id')->nullable();

            $table->string('contract_start')->nullable();
            $table->string('contract_end')->nullable();
            $table->string('latest_education')->nullable();
            $table->string('working_hour')->nullable();

            // $table->enum('bpjs', ['Y', 'N'])->default('Y');
            $table->enum('bpjs_jht', ['Y', 'N'])->default('Y');
            $table->enum('bpjs_jkk', ['Y', 'N'])->default('Y');
            $table->enum('bpjs_jkm', ['Y', 'N'])->default('Y');
            $table->enum('bpjs_jp', ['Y', 'N'])->default('Y');
            $table->enum('bpjs_kes', ['Y', 'N'])->default('Y');

            $table->string('ptkp')->nullable();
            $table->bigInteger('ptkp_karyawan')->default(0);

            // DATA KELUARGA
            // $table->string('father_name')->nullable();
            // $table->string('father_phone')->nullable();
            // $table->string('mother_name')->nullable();
            // $table->string('mother_phone')->nullable();
            // $table->string('wife_name')->nullable();
            // $table->string('wife_phone')->nullable();

            $table->string('married_status')->nullable();
            $table->enum('employee_status', ['aktif', 'tidak_aktif'])->default('aktif')->nullable();
            $table->date('out_date')->nullable();
            $table->string('reason')->nullable();

            // DATA GAJI & REKENING
            $table->bigInteger('basic_salary')->default(0)->nullable();
            $table->bigInteger('allowance')->default(0)->nullable();
            $table->bigInteger('meal_allowance_per_attend')->default(0)->nullable();
            $table->bigInteger('transport_allowance_per_attend')->default(0)->nullable();
            $table->bigInteger('attend_allowance_per_attend')->default(0)->nullable();
            $table->bigInteger('overtime_rate_per_hour')->default(0)->nullable();

            $table->bigInteger('vat_per_year')->default(0)->nullable();

            $table->string('rekening_number')->nullable();
            $table->string('rekening_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch')->nullable();

            // DATA FINGER
            // $table->string('id_finger')->nullable();
            // $table->string('finger_doc_2')->nullable();

            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->foreign('employee_type_id')->references('id')->on('employee_types')->onDelete('cascade');
            // $table->foreign('finger_tool_id')->references('id')->on('finger_tools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
