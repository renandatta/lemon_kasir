<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePenjualanTableAddPembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->double('total')->nullable();
            $table->double('dibayar')->nullable();
            $table->date('tanggal_waktu_dibayar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropColumn('total');
            $table->dropColumn('dibayar');
            $table->dropColumn('tanggal_waktu_dibayar');
        });
    }
}
