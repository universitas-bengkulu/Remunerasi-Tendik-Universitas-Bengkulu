<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRCapaianSkpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_capaian_skps', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('tendik_id');
            $table->unsignedInteger('periode_id');
            $table->float('nilai_skp', 8, 2);
            $table->string('file_skp');
            $table->enum('status',['menunggu','terkirim','berhasil','gagal'])->default('menunggu');
            $table->string('potongan_skp')->nullable();
            $table->string('nominal_potongan')->nullable();
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
        Schema::dropIfExists('r_capaian_skps');
    }
}
