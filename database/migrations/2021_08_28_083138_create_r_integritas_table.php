<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRIntegritasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_integritas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('tendik_id');
            $table->unsignedInteger('periode_id');
            $table->enum('laporan_lhkpn_lhkasn',['sudah','belum'])->default('sudah')->nullable();
            $table->enum('sanksi_disiplin',['ada','tidak'])->default('tidak')->nullable();
            $table->string('pajak_pph')->nullable();
            $table->string('remun_30')->nullable();
            $table->string('remun_70')->nullable();
            $table->string('total_remun_30')->nullable();
            $table->string('total_remun_70')->nullable();
            $table->string('total_remun')->nullable();
            $table->string('potongan_lhkpn_lhkasn')->nullable();
            $table->string('potongan_sanksi_disiplin')->nullable();
            $table->string('integritas_satu_bulan')->nullable();
            $table->string('total_integritas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_integritas');
    }
}
