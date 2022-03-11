<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;
    protected $fillable = [
        'nm_periode',
        'tanggal_awal',
        'tanggal_akhir',
        'tanggal_akhir_skp',
        'jumlah_bulan',
        'slug'
    ];
}
