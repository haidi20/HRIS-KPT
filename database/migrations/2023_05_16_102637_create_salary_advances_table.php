<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryAdvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_advances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->double('loan_amount'); // total pinjaman
            $table->double('monthly_deduction')->nullable(); // potongan bulanan
            $table->integer('duration')->nullable(); // durasi pinjaman
            // sisa gaji setelah potongan cicilan bulanan
            $table->double('remaining_salary')->nullable();
            $table->text('note')->nullable();
            // status sudah di handle oleh approval_aggrement
            $table->enum('status', ['accept', 'reject', 'review'])->default('review');
            $table->enum('payment_status', ['paid', 'unpaid'])->nullable();
            $table->enum('payment_method', ['cash', 'transfer']);
            $table->date('month_loan_complite')->nullable(); // bulan selesai kasbon
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
        Schema::dropIfExists('salary_advances');
    }
}
