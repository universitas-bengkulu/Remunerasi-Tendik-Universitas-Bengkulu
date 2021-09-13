<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTendiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tendiks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('jabatan_id')->nullable();
            $table->unsignedInteger('user_id_absensi')->nullable();
            $table->string('nm_lengkap')->nullable();
            $table->string('slug');
            $table->string('nip')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('golongan')->nullable();
            $table->string('jenis_kepegawaian')->nullable();
            $table->enum('jenis_kelamin',['L','P'])->nullable();
            $table->string('kedekatan_hukum')->nullable();
            $table->string('no_rekening')->nullable();
            $table->string('no_npwp')->nullable();            
            $table->enum('status',['aktif','nonaktif']);
            $table->string('password')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('tendiks');
    }
}
