<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable(); // perusahaan
            $table->foreignId('foreman_id')->nullable(); // pengawas
            $table->foreignId('barge_id')->nullable(); // kapal
            $table->string("name"); // nama proyek
            $table->date('date_end'); // tanggal selesai
            $table->integer('day_duration')->nullable(); // berapa lama hari pengerjaan
            $table->double('price'); // biaya proyek
            $table->double('down_payment')->nullable(); // DP
            $table->double('remaining_payment')->nullable(); // sisa pembayaran
            $table->enum('type', ['contract', 'daily'])->nullable(); // jenis proyek borongan atau harian
            $table->string('note')->nullable();
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
        Schema::dropIfExists('projects');
    }
}