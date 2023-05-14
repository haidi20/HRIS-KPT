<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalLevelDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_level_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreignId("approval_level_id");
            $table->string("status"); // jenis persetujuan: submit = mengajukan, knowing = Mengetahui, approved = Disetujui
            $table->integer("level"); // prioritas: 1, 2, 3. tingkatan aproval.
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
        Schema::dropIfExists('approval_level_details');
    }
}
