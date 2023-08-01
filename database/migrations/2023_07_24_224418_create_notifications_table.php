<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('parent_id');
            $table->string('parent_model');
            $table->dateTime('readed_at')->nullable(); // ketika sudah di baca, maka tanda merah hilang
            $table->boolean('is_show')->default(false);
            $table->timestamps();

            // Add a unique constraint on parent_id and parent_model columns
            $table->unique(['parent_id', 'parent_model']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
