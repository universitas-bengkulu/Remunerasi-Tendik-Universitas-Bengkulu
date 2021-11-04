<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailIsianRubriksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_isian_rubriks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('isian_rubrik_id')->constrained('isian_rubriks');
            $table->string('nip');
            $table->string('nama_dosen');
            $table->string('keterangan');
            $table->integer('rate_remun');
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
        Schema::dropIfExists('detail_isian_rubriks');
    }
}
