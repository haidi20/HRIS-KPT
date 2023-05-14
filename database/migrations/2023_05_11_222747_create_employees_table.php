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
            $table->string('name')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('phone')->nullable();
            $table->string('religion')->nullable();
            $table->string('address')->nullable();
            $table->string('latest_education')->nullable();
            $table->string('expertise')->nullable();
            $table->string('photo')->nullable();
            $table->date('enter_date')->nullable();
            $table->date('out_date')->nullable();

            // DATA KEPEGAWAIAN
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('employee_type_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();

            $table->enum('bpjs_tk', ['Y', 'N'])->default('Y');
            $table->enum('bpjs_tk_pt', ['Y', 'N'])->default('Y');
            $table->enum('bpjs_kes', ['Y', 'N'])->default('Y');
            $table->enum('bpjs_kes_pt', ['Y', 'N'])->default('Y');
            $table->enum('training', ['Y', 'N'])->default('Y');

            // DATA KELUARGA
            // $table->string('father_name')->nullable();
            // $table->string('father_phone')->nullable();
            // $table->string('mother_name')->nullable();
            // $table->string('mother_phone')->nullable();
            // $table->string('wife_name')->nullable();
            // $table->string('wife_phone')->nullable();

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
