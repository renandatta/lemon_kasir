<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLisensiProfilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lisensi_profil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profil_id');
            $table->unsignedBigInteger('lisensi_id');
            $table->string('no_lisensi')->nullable();
            $table->date('berlaku_dari');
            $table->date('berlaku_sampai')->nullable();
            $table->double('harga')->default(0);
            $table->smallInteger('is_aktif')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('profil_id')->references('id')->on('profil');
            $table->foreign('lisensi_id')->references('id')->on('lisensi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lisensi_profil');
    }
}
