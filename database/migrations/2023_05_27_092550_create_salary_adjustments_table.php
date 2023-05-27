<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_adjustments', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->enum('type_time', ['forever', 'base time']);
            $table->boolean("is_date_end")->default(false);
            $table->date("date_start")->nullable();
            $table->date("date_end")->nullable();
            $table->enum('type_amount', ['nominal', 'percent']);
            $table->double("amount");
            $table->enum('type_adjustment', ['deduction', 'addition']);
            $table->text("note")->nullable();
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
        Schema::dropIfExists('salary_adjustments');
    }
}
