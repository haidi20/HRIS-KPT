<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_agreements', function (Blueprint $table) {
            $table->id();
            $table->foreignId("approval_level_id");
            $table->foreignId("user_id"); // karyawan yang telah melakukan approval
            $table->foreignId("user_behalf_id")->nullable(); // karyawan ATAS NAMA yang telah melakukan approval
            $table->foreignId("model_id"); // id data yang menggunakan approval
            $table->string("name_model"); // nama model yang menggunakan approval. jadi bisa dinamis
            $table->string("status_approval"); //review, not yet, accept, reject, revision, etc | tinjau, belum, terima, tolak, revisi, dll
            $table->integer("level_approval")->default(0); // sudah di tahap apa proses approval
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
        Schema::dropIfExists('approval_agreements');
    }
}
