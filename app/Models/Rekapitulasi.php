<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekapitulasi extends Model
{
    use HasFactory;
    public function periode()
    {
        return $this->belongsTo('App\Models\Periode');
    }
}
