<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodeInsentifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periode_insentifs', function (Blueprint $table) {
            $table->id();
            $table->string('masa_kinerja');
            $table->string('slug');
            $table->string('periode_pembayaran');
            $table->enum('status',['aktif','nonaktif']);
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
        Schema::dropIfExists('periode_insentifs');
    }
}
