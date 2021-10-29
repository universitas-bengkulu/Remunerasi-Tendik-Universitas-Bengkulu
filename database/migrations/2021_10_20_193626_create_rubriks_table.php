<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRubriksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rubriks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rubrik');
            $table->string('nama_kolom_1')->nullable();
            $table->string('nama_kolom_2')->nullable();
            $table->string('nama_kolom_3')->nullable();
            $table->string('nama_kolom_4')->nullable();
            $table->string('nama_kolom_5')->nullable();
            $table->string('nama_kolom_6')->nullable();
            $table->string('nama_kolom_7')->nullable();
            $table->string('nama_kolom_8')->nullable();
            $table->string('nama_kolom_9')->nullable();
            $table->string('nama_kolom_10')->nullable();
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
        Schema::dropIfExists('rubriks');
    }
}
