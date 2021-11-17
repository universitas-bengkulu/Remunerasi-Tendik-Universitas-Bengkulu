<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNmDosenColumnToDetailIsianRubriksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_isian_rubriks', function (Blueprint $table) {
            $table->renameColumn('nama_dosen','nm_tendik');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_isian_rubriks', function (Blueprint $table) {
            //
        });
    }
}
