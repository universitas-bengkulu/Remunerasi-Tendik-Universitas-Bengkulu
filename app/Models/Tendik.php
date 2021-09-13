<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tendik extends Model
{
    use HasFactory;
    protected $fillable = [
        'jabatan_id',
        'nm_lengkap',
        'slug',
        'nip',
        'pangkat',
        'golongan',
        'jenis_kepegawaian',
        'jenis_kelamin',
        'kedekatan_hukum',
        'no_rekening',
        'no_npwp',
        'user_id_absensi',
    ];
}
