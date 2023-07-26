<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditJobStatusHasParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_status_has_parents', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->change();
            $table->string('parent_model')->nullable()->change();
        });
        Schema::table('job_status_has_parent_histories', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->change();
            $table->string('parent_model')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_status_has_parents', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable(false)->change();
            $table->string('parent_model')->nullable(false)->change();
        });
        Schema::table('job_status_has_parent_histories', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable(false)->change();
            $table->string('parent_model')->nullable(false)->change();
        });
    }
}
