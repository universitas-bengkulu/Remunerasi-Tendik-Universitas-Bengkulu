<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeInsentif extends Model
{
    use HasFactory;
    protected $fillable = [
        'masa_kinerja','periode_pembayaran','slug'
    ];

    public function isianrubrik()
    {
        return $this->hasOne('App\Models\IsianRubrik');
    }
    public function rekapitulasi(){
        return $this->hasMany('App\Models\Rekapitulasi');
    }
}
