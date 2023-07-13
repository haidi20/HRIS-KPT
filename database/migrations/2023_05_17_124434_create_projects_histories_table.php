<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id');
            $table->foreignId('location_id'); // lokasi doc 1 / 2
            // $table->foreignId('company_id')->nullable(); // perusahaan
            $table->foreignId('foreman_id')->nullable(); // pengawas
            $table->foreignId('barge_id')->nullable(); // kapal
            // $table->string("code"); // kode proyek
            $table->string("name"); // nama proyek
            $table->date('date_end')->nullable(); // tanggal selesai
            $table->integer('day_duration')->nullable(); // berapa lama hari pengerjaan
            $table->double('price')->nullable(); // biaya proyek
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
        Schema::dropIfExists('project_histories');
    }
}
