<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobStatusHasParentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_status_has_parent_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_status_has_parent_id');
            $table->foreignId('parent_id');
            $table->string('parent_model');
            /*
                active - finish,
                pending - pending finish,
                overtime - overtime finish,
                correction - correction finish
            */
            $table->enum('status', [
                'active', 'pending', 'overtime',
                'correction', 'assessment',
            ])->nullable();
            $table->datetime('datetime_start');
            $table->datetime('datetime_end')->nullable();
            $table->text('note_start')->nullable();
            $table->text('note_end')->nullable();
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
        Schema::dropIfExists('job_status_has_parent_histories');
    }
}
