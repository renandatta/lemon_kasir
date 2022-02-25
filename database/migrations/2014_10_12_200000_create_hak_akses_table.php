<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHakAksesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hak_akses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fitur_program_id');
            $table->unsignedBigInteger('user_level_id');
            $table->smallInteger('flag_akses')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fitur_program_id')->references('id')->on('fitur_program');
            $table->foreign('user_level_id')->references('id')->on('user_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hak_akses');
    }
}
