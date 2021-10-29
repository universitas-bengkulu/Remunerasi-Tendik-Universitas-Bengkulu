<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIsianRubriksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isian_rubriks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rubrik_id')->constrained('pengguna_rubriks');
            $table->string('nomor_sk')->constrained('rubriks');
            $table->unsignedBigInteger('periode_id')->constrained('periodes');
            $table->string('isian_1')->nullable();
            $table->string('isian_2')->nullable();
            $table->string('isian_3')->nullable();
            $table->string('isian_4')->nullable();
            $table->integer('isian_5')->nullable();
            $table->integer('isian_6')->nullable();
            $table->integer('isian_7')->nullable();
            $table->integer('isian_8')->nullable();
            $table->date('isian_9')->nullable();
            $table->date('isian_10')->nullable();
            $table->string('file_upload');
            $table->enum('status_validasi',['menunggu','terkirim','diterima','ditolak']);
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
        Schema::dropIfExists('isian_rubriks');
    }
}
