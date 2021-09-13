<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRAbsensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_absens', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('tendik_id');
            $table->unsignedInteger('periode_id');
            $table->integer('potongan_bulan_1')->nullable();
            $table->integer('potongan_bulan_2')->nullable();
            $table->integer('potongan_bulan_3')->nullable();
            $table->integer('potongan_bulan_4')->nullable();
            $table->integer('potongan_bulan_5')->nullable();
            $table->integer('potongan_bulan_6')->nullable();
            $table->string('nominal_bulan_1')->nullable();
            $table->string('nominal_bulan_2')->nullable();
            $table->string('nominal_bulan_3')->nullable();
            $table->string('nominal_bulan_4')->nullable();
            $table->string('nominal_bulan_5')->nullable();
            $table->string('nominal_bulan_6')->nullable();
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
        Schema::dropIfExists('r_absens');
    }
}
