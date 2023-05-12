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
            $table->string('npwp')->nullable();
            $table->string('nik')->nullable();
            $table->string('bpjs_number')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('keahlian')->nullable();
            $table->string('foto')->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_keluar')->nullable();

            // DATA KEPEGAWAIAN
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('employee_type_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();

            $table->enum('bpjs', ['Y', 'N'])->default('Y');
            $table->enum('jkk', ['Y', 'N'])->default('Y');
            $table->enum('jkm', ['Y', 'N'])->default('Y');
            $table->enum('jht', ['Y', 'N'])->default('Y');
            $table->enum('ip', ['Y', 'N'])->default('Y');

            // DATA KELUARGA
            $table->string('nama_ayah')->nullable();
            $table->string('telepon_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('telepon_ibu')->nullable();
            $table->string('nama_istri')->nullable();
            $table->string('telepon_istri')->nullable();
            $table->string('nama_saudara')->nullable();
            $table->string('telepon_saudara')->nullable();

            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->foreign('employee_type_id')->references('id')->on('employee_types')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');

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
